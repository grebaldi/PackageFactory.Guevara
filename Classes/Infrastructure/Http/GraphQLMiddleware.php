<?php declare(strict_types=1);
namespace Neos\Neos\Ui\Infrastructure\Http;

/*
 * This file is part of the Neos.Neos.Ui package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use Mouf\Composer\ClassNameMapper;
use Neos\Cache\Backend\FileBackend;
use Neos\Cache\EnvironmentConfiguration;
use Neos\Cache\Psr\SimpleCache\SimpleCache;
use Neos\Cache\Psr\SimpleCache\SimpleCacheFactory;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Configuration\ConfigurationManager;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Neos\Flow\ObjectManagement\ObjectManagerInterface;
use Neos\Flow\Package\PackageManager;
use Neos\Flow\Utility\Environment;
use Neos\Http\Factories\ResponseFactory;
use Neos\Http\Factories\StreamFactory;
use Neos\Utility\Files;
use TheCodingMachine\GraphQLite\SchemaFactory;
use TheCodingMachine\GraphQLite\Http\Psr15GraphQLMiddlewareBuilder;

/**
 * @Flow\Scope("singleton")
 */
final class GraphQLMiddleware implements MiddlewareInterface
{
    /**
     * @Flow\Inject(lazy=false)
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @Flow\InjectConfiguration(path="cache.applicationIdentifier", package="Neos.Flow")
     * @var string
     */
    protected $applicationIdentifier;

    /**
     * @Flow\Inject
     * @var Environment
     */
    protected $environment;

    /**
     * @Flow\Inject
     * @var ConfigurationManager
     */
    protected $configurationManager;

    /**
     * @Flow\Inject
     * @var PackageManager
     */
    protected $packageManager;


    /**
     * @Flow\InjectConfiguration(path="graphQL.endpointPath")
     * @var string
     */
    protected $endpointPath;


    /**
     * @return SimpleCache
     */
    protected function createCache(): SimpleCache
    {
        $environmentConfiguration = new EnvironmentConfiguration(
            $this->applicationIdentifier,
            $this->environment->getPathToTemporaryDirectory()
        );

        $identifier = 'Neos_Ui_GraphQL';
        $configuration = $this->configurationManager->getConfiguration(
            ConfigurationManager::CONFIGURATION_TYPE_CACHES,
            $identifier
        ) ?? [];

        $backendObjectName = $configuration['backend'] ?? FileBackend::class;
        $backendOptions = $configuration['backendOptions'] ?? [
            'defaultLifetime' => 0
        ];

        return (new SimpleCacheFactory($environmentConfiguration))
            ->create($identifier, $backendObjectName, $backendOptions);
    }

    /**
     * @return string
     */
    protected function getEndpointPath(): string
    {
        return $this->endpointPath ?? '/graphql';
    }

    /**
     * @param ServerRequestInterface $request
     * @return Uri
     */
    protected function getAbsoluteEndpointUri(ServerRequestInterface $request): Uri
    {
        return $request->getUri()->withPath($this->getEndpointPath());
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        if ($request->getUri()->getPath() === $this->getEndpointPath()) {
            if ($request->getMethod() === 'GET') {
                return $this->respondWithGraphiQLClient($request);
            } else if ($request->getMethod() === 'POST') {
                return $this->respondWithGraphQLEndpoint($request, $handler);
            } else {
                return $this->respondWithMethodNotAllowed();
            }
        }

        return $handler->handle($request);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function respondWithGraphiQLClient(
        ServerRequestInterface $request
    ): ResponseInterface {
        $graphiQLTemplate = Files::getFileContents(
            'resource://Neos.Neos.Ui/Private/Templates/GraphiQL/GraphiQL.html'
        );
        $graphiQL = str_replace(
            '{endpointUri}',
            $this->getAbsoluteEndpointUri($request),
            $graphiQLTemplate
        );

        return new Response(200, [], $graphiQL);
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function respondWithGraphQLEndpoint(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $package = $this->packageManager->getPackage('Neos.Neos.Ui');
        $schema = (new SchemaFactory($this->createCache(), $this->objectManager))
            ->setClassNameMapper(
                ClassNameMapper::createFromComposerFile(
                    $package->getPackagePath() . '/composer.json',
                    FLOW_PATH_PACKAGES
                )
            )
            ->addControllerNamespace('Neos\\Neos\\Ui\\Application\\Controller\\')
            ->addTypeNamespace('Neos\\Neos\\Ui\\Presentation')
            ->createSchema();
        $middleware = (new Psr15GraphQLMiddlewareBuilder($schema))
            ->setUrl($this->getEndpointPath())
            ->setResponseFactory(new ResponseFactory())
            ->setStreamFactory(new StreamFactory())
            ->createMiddleware();

        return $middleware->process($request, $handler);
    }

    /**
     * @return ResponseInterface
     */
    public function respondWithMethodNotAllowed(): ResponseInterface
    {
        return new Response(405);
    }
}

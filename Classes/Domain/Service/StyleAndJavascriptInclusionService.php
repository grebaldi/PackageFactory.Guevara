<?php
namespace Neos\Neos\Ui\Domain\Service;

/*
 * This file is part of the Neos.Neos.Ui package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Eel\CompilingEvaluator;
use Neos\Eel\Utility;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\ResourceManagement\ResourceManager;
use Neos\Utility\PositionalArraySorter;

/**
 * @Flow\Scope("singleton")
 */
class StyleAndJavascriptInclusionService
{

    /**
     * @Flow\Inject
     * @var ResourceManager
     */
    protected $resourceManager;

    /**
     * @Flow\Inject(lazy=false)
     * @var CompilingEvaluator
     */
    protected $eelEvaluator;

    /**
     * @Flow\InjectConfiguration(package="Neos.Fusion", path="defaultContext")
     * @var array
     */
    protected $fusionDefaultEelContext;

    /**
     * @Flow\InjectConfiguration(path="configurationDefaultEelContext")
     * @var array
     */
    protected $additionalEelDefaultContext;

    /**
     * @Flow\InjectConfiguration(path="resources.javascript")
     * @var array
     */
    protected $javascriptResources;

    /**
     * @Flow\InjectConfiguration(path="resources.stylesheets")
     * @var array
     */
    protected $stylesheetResources;

    public function getHeadScripts()
    {
        return $this->build($this->javascriptResources, function ($uri, $defer, $configuration) {
            return '<script src="' . $uri . '" ' . implode(' ', array_filter([$defer, $configuration])) . '></script>';
        });
    }

    public function getHeadStylesheets()
    {
        return $this->build($this->stylesheetResources, function ($uri, $defer) {
            return '<link rel="stylesheet" href="' . $uri . '" ' . $defer . '/>';
        });
    }

    protected function build(array $resourceArrayToSort, \Closure $builderForLine)
    {
        $sortedResources = (new PositionalArraySorter($resourceArrayToSort))->toArray();

        $result = '';
        foreach ($sortedResources as $element) {
            $resourceExpression = $element['resource'];
            if (substr($resourceExpression, 0, 2) === '${' && substr($resourceExpression, -1) === '}') {
                $resourceExpression = Utility::evaluateEelExpression(
                    $resourceExpression,
                    $this->eelEvaluator,
                    [],
                    array_merge($this->fusionDefaultEelContext, $this->additionalEelDefaultContext)
                );
            }

            $configurationExpression = $element['configuration'] ?? '';
            if (substr($configurationExpression, 0, 2) === '${' && substr($configurationExpression, -1) === '}') {
                $configurationExpression = Utility::evaluateEelExpression(
                    $configurationExpression,
                    $this->eelEvaluator,
                    [],
                    array_merge($this->fusionDefaultEelContext, $this->additionalEelDefaultContext)
                );
            }

            $hash = null;

            if (strpos($resourceExpression, 'resource://') === 0) {
                // Cache breaker
                $hash = substr(md5_file($resourceExpression), 0, 8);
                $resourceExpression = $this->resourceManager->getPublicPackageResourceUriByPath($resourceExpression);
            }
            $finalUri = $hash ? $resourceExpression . '?' . $hash : $resourceExpression;
            $defer = key_exists('defer', $element) && $element['defer'] ? 'defer ' : '';
            $configuration = $configurationExpression ? sprintf('data-configuration="%s"', htmlspecialchars(json_encode($configurationExpression))) : null;
            $result .= $builderForLine($finalUri, $defer, $configuration);
        }

        return $result;
    }
}

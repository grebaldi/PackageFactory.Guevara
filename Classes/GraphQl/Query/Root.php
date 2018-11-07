<?php
namespace Neos\Neos\Ui\GraphQl\Query;

/*
 * This file is part of the Neos.Neos.Ui package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Annotations as Flow;
use GraphQL\Type\Definition\ObjectType;
use Neos\Neos\Domain\Service\ContentContextFactory;
use Neos\Neos\Ui\GraphQl\Type\Type;

/**
 * Root query for the neos user interface
 */
class Root extends ObjectType
{
    /**
     * @Flow\Inject
     * @var ContentContextFactory
     */
    protected $contentContextFactory;

    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'Query',
            'description' => 'The Neos.Ui Root Query',
        ], $configuration, [
            'fields' => function () {
                return [
                    'contentContext' => [
                        'type' => Type::nonNull(Type::contentContext()),
                        'description' => 'A content context',
                        'args' => [
                            'properties' => [
                                'type' => Type::contentContextPropertiesInput(),
                                'description' => 'Properties of the context',
                                'defaultValue' => [
                                    'workspaceName' => 'live',
                                    'invisibleContentShown' => true,
                                    'inaccessibleContentShown' => true
                                ]
                            ]
                        ],
                        'resolve' => function ($_, array $arguments) {
                            return $this->contentContextFactory->create($arguments['properties']);
                        }
                    ]
                ];
            }
        ]));
    }
}

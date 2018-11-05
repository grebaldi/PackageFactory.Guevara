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

use GraphQL\Type\Definition\ObjectType;
use Neos\Neos\Ui\GraphQl\Type\Type;
use Neos\ContentRepository\Domain\Model\NodeType;

/**
 * GraphQl representation of a node type
 */
class NodeType extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'NodeType',
            'description' => 'A node type',
        ], $configuration, [
            'fields' => [
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => '', // @TODO: Description for nodeType.name
                    'resolve' => function (NodeType $nodeType) {
                        return $nodeType->getName();
                    }
                ],
                'declaredSuperTypes' => [
                    'type' => Type::listOf(Type::nodeType()),
                    'description' => '', // @TODO: Description for nodeType.declaredSuperTypes
                    'resolve' => function (NodeType $nodeType) {
                        return $nodeType->getDeclaredSuperTypes();
                    }
                ],
                'isAggregate' => [
                    'type' => Type::boolean(),
                    'description' => '', // @TODO: Description for nodeType.isAggregate
                    'resolve' => function (NodeType $nodeType) {
                        return $nodeType->isAggregate();
                    }
                ],
                'isOfType' => [
                    'type' => Type::boolean(),
                    'description' => '', // @TODO: Description for nodeType.isOfType
                    'args' => [
                        'nodeTypeName' => [
                            'type' => Type::nonNull(Type::string()),
                            'description' => '' // @TODO: Description for nodeType.isOfType arg
                        ]
                    ],
                    'resolve' =>  function (NodeType $nodeType, array $arguments) {
                        return $nodeType->isOfType($arguments['nodeTypeName']);
                    }
                ],
                'hasConfiguration' => [
                    'type' => Type::boolean(),
                    'description' => '', // @TODO: Description for nodeType.hasConfiguration,
                    'args' => [
                        'path' => [
                            'type' => Type::string(),
                            'description' => '', // @TODO: Description for nodeType.hasConfiguration args
                        ]
                    ],
                    'resolve' => function (NodeType $nodeType, array $arguments) {
                        return $nodeType->hasConfiguration($arguments['path']);
                    }
                ],
                'configuration' => [
                    'type' => Type::json(),
                    'description' => '', // @TODO: Description for nodeType.configuration,
                    'args' => [
                        'path' => [
                            'type' => Type::string(),
                            'description' => '', // @TODO: Description for nodeType.configuration args
                        ]
                    ],
                    'resolve' => function (NodeType $nodeType, array $arguments) {
                        return $nodeType->getConfiguration($arguments['path']);
                    }
                ],
                'label' => [
                    'type' => Type::string(),
                    'description' => '', // @TODO: Description for nodeType.label,
                    'resolve' => function (NodeType $nodeType) {
                        return $nodeType->getLabel();
                    }
                ],
                'options' => [
                    'type' => Type::json(),
                    'description' => '', // @TODO: Description for nodeType.options,
                    'resolve' => function (NodeType $nodeType) {
                        return $nodeType->getOptions();
                    }
                ],
                'properties' => [
                    'type' => Type::listOf(Type::property()),
                    'description' => '', // @TODO: Description for nodeType.properties,
                    'resolve' => function(NodeType $nodeType) {
                        foreach ($nodeType->getProperties() as $name => $property) {
                            yield [
                                'name' => $name,
                                'type' => $property['type'],
                                'value' => $nodeType->getDefaultValueForProperty($name)
                            ];
                        }
                    }
                ],
                'autoCreatedChildNodes' => [
                    'type' => Type::listOf(Type::autoCreatedChildNode()),
                    'description' => '', // @TODO: Description for nodeType.autoCreatedChildNodes,
                    'resolve' => function (NodeType $nodeType) {
                        foreach ($nodeType->getAutoCreatedChildNodes() as $name => $childNodeType) {
                            yield [
                                'name' => $name,
                                'childNodeType' => $childNodeType,
                                'owningNodeType' => $nodeType
                            ];
                        }
                    }
                ]
            ]
        ]))
    }
}

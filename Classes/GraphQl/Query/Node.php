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
use Neos\ContentRepository\Domain\Model\NodeInterface;

/**
 * GraphQl representation of a node
 */
class Node extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'Node',
            'description' => 'A node'
        ], $configuration, [
            'fields' => function () {
                return [
                    'name' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'The node name',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getName();
                        }
                    ],
                    'label' => [
                        'type' => Type::nonNUll(Type::string()),
                        'description' => 'The node label',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getLabel();
                        }
                    ],
                    'context' => [
                        'type' => Type::nonNUll(Type::contentContext()),
                        'description' => 'The content context of the node',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getContext();
                        }
                    ],
                    'hasProperty' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates, whether the given property exists in this node',
                        'args' => [
                            'propertyName' => [
                                'type' => Type::string(),
                                'description' => 'The property name'
                            ]
                        ],
                        'resolve' => function (NodeInterface $node, $arguments) {
                            return $node->hasProperty($arguments['propertyName']);
                        }
                    ],
                    'property' => [
                        'type' => Type::property(),
                        'description' => 'Get a specific property',
                        'args' => [
                            'propertyName' => [
                                'type' => Type::nonNull(Type::string()),
                                'description' => 'The property name'
                            ]
                        ],
                        'resolve' => function (NodeInterface $node, $arguments) {
                            return [
                                'name' => $arguments['propertyName'],
                                'type' => $node->getNodeType()->getPropertyType($arguments['propertyName']),
                                'value' => $node->getProperty($arguments['propertyName'])
                            ];
                        }
                    ],
                    'properties' => [
                        'type' => Type::listOf(Type::property()),
                        'description' => 'Get all properties of this node',
                        'resolve' => function (NodeInterface $node) {
                            foreach ($node->getProperties() as $propertyName => $propertyValue) {
                                yield [
                                    'name' => $propertyName,
                                    'type' => $node->getNodeType()->getPropertyType($propertyName),
                                    'value' => $propertyValue
                                ];
                            }
                        }
                    ],
                    'propertyNames' => [
                        'type' => Type::listOf(Type::string()),
                        'description' => 'A list of all property names in this node',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getPropertyNames();
                        }
                    ],
                    'nodeType' => [
                        'type' => Type::nonNull(Type::nodeType()),
                        'description' => 'The node type of this node',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getNodeType();
                        }
                    ],
                    'isHidden' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether this node is hidden',
                        'resolve' => function (NodeInterface $node) {
                            return $node->isHidden();
                        }
                    ],
                    'hiddenBeforeDateTime' => [
                        'type' => Type::dateTime(),
                        'description' => 'The node is invisible before this date time occurs.',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getHiddenBeforeDateTime();
                        }
                    ],
                    'hiddenAfterDateTime' => [
                        'type' => Type::dateTime(),
                        'description' => 'The node is invisible after this date time occurs.',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getHiddenBeforeDateTime();
                        }
                    ],
                    'isHiddenInIndex' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether this node should be hidden in indexes',
                        'resolve' => function (NodeInterface $node) {
                            return $node->isHiddenInIndex();
                        }
                    ],
                    'accessRoles' => [
                        'type' => Type::listOf(Type::role()),
                        'description' => 'A list of roles that have access to this node',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getAccessRoles();
                        }
                    ],
                    'path' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'The node path',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getPath();
                        }
                    ],
                    'contextPath' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'The node context path',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getContextPath();
                        }
                    ],
                    'depth' => [
                        'type' => Type::int(),
                        'description' => 'The (tree-)depth of the node',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getDepth();
                        }
                    ],
                    'workspace' => [
                        'type' => Type::nonNull(Type::workspace()),
                        'description' => 'The workspace of this node',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getWorkspace();
                        }
                    ],
                    'identifier' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'The node identifier',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getIdentifier();
                        }
                    ],
                    'parent' => [
                        'type' => Type::nonNull(Type::node()),
                        'description' => 'The parent node of this node',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getParent();
                        }
                    ],
                    'parentPath' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'The path of the parent node of this node',
                        'resolve' => function (NodeInterface $node) {
                            return $node->getParentPath();
                        }
                    ],
                    'node' => [
                        'type' => Type::node(),
                        'description' => 'Retreive a node by path',
                        'args' => [
                            'path' => [
                                'type' => Type::nonNull(Type::string()),
                                'description' => 'The relative path of the target node'
                            ]
                        ],
                        'resolve' => function (NodeInterface $noe, array $arguments) {
                            return $node->getNode($arguments['path']);
                        }
                    ],
                    'childNodes' => [
                        'type' => Type::listOf(Type::node()),
                        'description' => 'All child nodes of this node',
                        'args' => [
                            'nodeTypeFilter' => [
                                'type' => Type::string(),
                                'description' => 'An optional node type filter',
                                'defaultValue' => null
                            ]
                        ],
                        'resolve' => function (NodeInterface $node, array $arguments) {
                            return $node->getChildNodes($arguments['nodeTypeFilter']);
                        }
                    ],
                    'hasChildNodes' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether this node has any children',
                        'args' => [
                            'nodeTypeFilter' => [
                                'type' => Type::string(),
                                'description' => 'An optional node type filter',
                                'defaultValue' => null
                            ]
                        ],
                        'resolve' => function (NodeInterface $node, array $arguments) {
                            return $node->hasChildNodes($arguments['nodeTypeFilter']);
                        }
                    ],
                    'isRemoved' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether this node has been removed',
                        'resolve' => function (NodeInterface $node) {
                            return $node->isRemoved();
                        }
                    ],
                    'isVisible' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether this node is visible',
                        'resolve' => function (NodeInterface $node) {
                            return $node->isVisible();
                        }
                    ],
                    'isAccessible' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether this node is accessible',
                        'resovle' => function (NodeInterface $node) {
                            return $node->isAccessible();
                        }
                    ],
                    'hasAccessRestrictions' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether any access restrictions apply to this node',
                        'resolve' => function (NodeInterface $node) {
                            return $node->hasAccessRestrictions();
                        }
                    ]
                ];
            }
        ]));
    }
}

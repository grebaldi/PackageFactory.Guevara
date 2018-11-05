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
use Neos\ContentRepository\Domain\Service\Context;

/**
 * GraphQl representation of a content context
 */
class ContentContext extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'ContentContext',
            'description' => 'A content context',
        ], $configuration, [
            'fields' => [
                'workspace' => [
                    'type' => Type::workspace(),
                    'description' => 'The workspace of this context',
                    'resolve' => function (Context $context) {
                        return $context->getWorkspace();
                    }
                ],
                'currentDateTime' => [
                    'type' => Type::dateTime(),
                    'description' => 'The current date and time according to this context',
                    'resolve' => function (Context $context) {
                        return $context->getCurrentDateTime();
                    }
                ],
                'rootNode' => [
                    'type' => Type::nonNull(Type::node()),
                    'description' => 'The root node',
                    'resolve' => function (Context $context) {
                        return $context->getRootNode();
                    }
                ],
                'node' => [
                    'type' => Type::node(),
                    'description' => 'Retrieve a node by path',
                    'args' => [
                        'path' => [
                            'type' => Type::nonNull(Type::string()),
                            'description' => 'The absolute path of the target node'
                        ]
                    ],
                    'resolve' => function (Context $context, array $arguments) {
                        return $context->getNode($arguments['path']);
                    }
                ],
                'nodeByIdentifier' => [
                    'type' => Type::node(),
                    'description' => 'Retrieve a node by identifier',
                    'args' => [
                        'identifier' => [
                            'type' => Type::nonNull(Type::string()),
                            'description' => 'The identifier of the target node'
                        ]
                    ],
                    'resolve' => function (Context $context, array $arguments) {
                        return $context->getNodeByIdentifier($arguments['identifier']);
                    }
                ],
                'nodeVariantsByIdentifier' => [
                    'type' => Type::listOf(Type::node()),
                    'description' => 'Retrieve all node variants by identifier',
                    'args' => [
                        'identifier' => [
                            'type' => Type::nonNull(Type::string()),
                            'description' => 'The identifier of the target node'
                        ]
                    ],
                    'resolve' => function (Context $context, array $arguments) {
                        return $context->getNodeVariantsByIdentifier($arguments['identifier']);
                    }
                ],
                'nodesOnPath' => [
                    'type' => Type::listOf(Type::node()),
                    'description' => 'Retrieve all nodes on the given path',
                    'args' => [
                        'path' => [
                            'type' => Type::nonNull(Type::string()),
                            'description' => 'An absolute node path'
                        ]
                    ],
                    'resolve' => function (Context $context, array $arguments) {
                        return $context->getNodesOnPath($arguments['path']);
                    }
                ],
                'isInvisibleContentShown' => [
                    'type' => Type::boolean(),
                    'description' => 'Indicates whether invisible content is made visible in this context',
                    'resolve' => function (Context $context) {
                        return $context->isInvisibleContentShown();
                    }
                ],
                'isRemovedContentShown' => [
                    'type' => Type::boolean(),
                    'description' => 'Indicates whether removed content is made visible in this context',
                    'resolve' => function (Context $context) {
                        return $context->isRemovedContentShown();
                    }
                ],
                'isInaccessibleContentShown' => [
                    'type' => Type::boolean(),
                    'description' => 'Indicates whether inaccessible content is made visible in this context',
                    'resolve' => function (Context $context) {
                        return $context->isInaccessibleContentShown();
                    }
                ],
                'dimensions' => [
                    'type' => Type::listOf(Type::dimension()),
                    'description' => 'The content dimensions of this context',
                    'resolve' => function (Context $context) {
                        return $context->getDimensions();
                    }
                ],
                'targetDimensions' => [
                    'type' => Type::listOf(Type::targetDimension()),
                    'description' => 'The target dimensions of this context',
                    'resolve' => function (Context $context) {
                        return $context->getTargetDimensions();
                    }
                ]
            ]
        ]));
    }
}

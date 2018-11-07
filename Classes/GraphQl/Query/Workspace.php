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
use Neos\ContentRepository\Domain\Model as ContentRepository;

/**
 * GraphQl representation of a workspace
 */
class Workspace extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'Workspace',
            'description' => 'A workspace',
        ], $configuration, [
            'fields' => function () {
                return [
                    'name' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'The workspace name',
                        'resolve' => function (ContentRepository\Workspace $workspace) {
                            return $workspace->getName();
                        }
                    ],
                    'title' => [
                        'type' => Type::string(),
                        'description' => 'The workspace title',
                        'resolve' => function (ContentRepository\Workspace $workspace) {
                            return $workspace->getTitle();
                        }
                    ],
                    'description' => [
                        'type' => Type::string(),
                        'description' => 'The workspace description',
                        'resolve' => function (ContentRepository\Workspace $workspace) {
                            return $workspace->getDescription();
                        }
                    ],
                    'owner' => [
                        'type' => Type::user(),
                        'description' => 'The owner (user) of the workspace',
                        'resolve' => function (ContentRepository\Workspace $workspace) {
                            return $workspace->getOwner();
                        }
                    ],
                    'isPersonalWorkspace' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether this is a personal (user-) workspace',
                        'resolve' => function (ContentRepository\Workspace $workspace) {
                            return $workspace->isPersonalWorkspace();
                        }
                    ],
                    'isPrivateWorkspace' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether this is a private (user-) workspace',
                        'resolve' => function (ContentRepository\Workspace $workspace) {
                            return $workspace->isPrivateWorkspace();
                        }
                    ],
                    'isInternalWorkspace' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether this is an internal workspace',
                        'resolve' => function (ContentRepository\Workspace $workspace) {
                            return $workspace->isInternalWorkspace();
                        }
                    ],
                    'isPublicWorkspace' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether this is a public workspace',
                        'resolve' => function (ContentRepository\Workspace $workspace) {
                            return $workspace->isPublicWorkspace();
                        }
                    ],
                    'baseWorkspace' => [
                        'type' => Type::workspace(),
                        'description' => 'The base workspace of this workspace',
                        'resolve' => function (ContentRepository\Workspace $workspace) {
                            return $workspace->getBaseWorkspace();
                        }
                    ],
                    'nodeCount' => [
                        'type' => Type::int(),
                        'description' => 'The number of nodes in this workspace',
                        'resolve' => function (ContentRepository\Workspace $workspace) {
                            return $workspace->getNodeCount();
                        }
                    ]
                ];
            }
        ]));
    }
}

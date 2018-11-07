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
use Neos\Flow\Security\Policy;

/**
 * GraphQl representation of a flow security role
 */
class Role extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'Role',
            'description' => 'A security role',
        ], $configuration, [
            'fields' => function () {
                return [
                    'identifier' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'The role identifier',
                        'resolve' => function (Policy\Role $role) {
                            return $role->getIdentifier();
                        }
                    ],
                    'packageKey' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'The role package key',
                        'resolve' => function (Policy\Role $role) {
                            return $role->getPackageKey();
                        }
                    ],
                    'name' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'The role name',
                        'resolve' => function (Policy\Role $role) {
                            return $role->getName();
                        }
                    ],
                    'isAbstract' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether the role is abstract',
                        'resolve' => function (Policy\Role $role) {
                            return $role->isAbstract();
                        }
                    ],
                    'parentRoles' => [
                        'type' => Type::listOf(Type::role()),
                        'description' => 'The parent roles of this role',
                        'resolve' => function (Policy\Role $role) {
                            return $role->getParentRoles();
                        }
                    ],
                    'allParentRoles' => [
                        'type' => Type::listOf(Type::role()),
                        'description' => 'All parent roles of this role',
                        'resolve' => function (Policy\Role $role) {
                            return $role->getAllParentRoles();
                        }
                    ],
                    'hasParentRole' => [
                        'type' => Type::listOf(Type::role()),
                        'description' => 'Indicates whether this role has the given parent role',
                        'args' => [
                            'parentRoleIdentifier' => [
                                'type' => Type::nonNull(Type::string()),
                                'description' => 'The identifier of the parent role'
                            ]
                        ],
                        'resolve' => function (Policy\Role $role, array $arguments) {
                            return $role->hasParentRole(arguments['parentRoleIdentifier']);
                        }
                    ]
                ];
            }
        ]));
    }
}

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
use neos\Neos\Domain\Model\User;

/**
 * GraphQl representation of a neos user
 */
class User extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'User',
            'description' => 'A neos user',
        ], $configuration, [
            'label' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The label (full name) of the user',
                'resolve' => function (User $user) {
                    return $user->getLabel();
                }
            ],
            'preferences' => [
                'type' => Type::nonNull(Type::userPreferences()),
                'description' => 'The user\'s preferences',
                'resolve' => function (User $user) {
                    return $user->getPreferences();
                }
            ],
            'isActive' => [
                'type' => Type::boolean(),
                'description' => 'Indicates whether the user is active',
                'resolve' => function (User $user) {
                    return $user->isActive();
                }
            ],
            'name' => [
                'type' => Type::nonNull(Type::personName()),
                'description' => 'The name of the user',
                'resolve' => function (User $user) {
                    return $user->getName();
                }
            ],
            'electronicAddresses' => [
                'type' => Type::listOf(Type::electronicAddress()),
                'description' => 'All registered electronic addresses (e.g. email, twitter-handle, etc.) of the user',
                'resolve' => function (User $user) {
                    return $user->getElectronicAddresses();
                }
            ],
            'primaryElectronicAddress' => [
                'type' => Type::electronicAddress(),
                'description' => 'The primary registered electronic address (e.g. email, twitter-handle, etc.) of the user',
                'resolve' => function (User $user) {
                    return $user->getPrimaryElectronicAddress();
                }
            ],
            'accounts' => [
                'type' => Type::listOf(Type::account()),
                'description' => 'All accounts associated with this user',
                'resolve' => function (User $user) {
                    return $user->getAccounts();
                }
            ]
        ]))
    }
}

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
use Neos\Flow\Security;

/**
 * GraphQl representation of a flow account
 */
class Account extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'Account', // @TODO: name
            'description' => 'An account', // @TODO: description
        ], $configuration, [
            'accountIdentifier' => [
                'type' => Type::string(),
                'description' => 'The account identifier',
                'resolve' => function (Security\Account $account) {
                    return $account->getAccountIdentifier();
                }
            ],
            'getRoles' => [
                'type' => Type::listOf(Type::role()),
                'description' => 'The roles of this account',
                'resolve' => function (Security\Account $account) {
                    return $account->getRoles();
                }
            ],
            'hasRole' => [
                'type' => Type::boolean(),
                'description' => 'Indicates whether this account has the given role',
                'args' => [
                    'roleIdentifier' => [
                        'type' => type::nonNull(Type::string()),
                        'description' => 'The identifier of the role'
                    ]
                ],
                'resolve' => function (Security\Account $account, array $arguments) {
                    return $account->hasRole($arguments['roleIdentifier']);
                }
            ],
            'isActive' => [
                'type' => Type::boolean(),
                'description' => 'Indicates whether this account is active',
                'resolve' => function (Security\Account $account) {
                    return $account->isActive();
                }
            ]
        ]))
    }
}

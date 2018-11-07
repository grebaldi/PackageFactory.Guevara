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
use GraphQL\Type\Definition\UnionType;
use Neos\Neos\Ui\GraphQl\Type\Type;
use Neos\Neos\Domain\Model as Neos;

/**
 * GraphQl representation of neos user preferences
 */
class UserPreferences extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'UserPreferences',
            'description' => 'Neos user preferences',
        ], $configuration, [
            'fields' => function () {
                return [
                    'get' => [
                        'type' => Type::json(),
                        'description' => 'Get a cusom preference value',
                        'args' => [
                            'key' => [
                                'type' => Type::nonNull(Type::string()),
                                'description' => 'The preference key'
                            ]
                        ],
                        'resolve' => function (Neos\UserPreferences $userPreferences, array $arguments) {
                            return $userPreferences->get($arguments['key']);
                        }
                    ],
                    'interfaceLanguage' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'The configured interface language',
                        'resolve' => function (Neos\UserPreferences $userPreferences) {
                            return $userPreferences->getInterfaceLanguage();
                        }
                    ]
                ];
            }
        ]));
    }
}

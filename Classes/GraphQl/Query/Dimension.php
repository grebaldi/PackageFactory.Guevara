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

/**
 * GraphQl representation of a content dimension
 */
class Dimension extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'Dimension',
            'description' => 'A content dimension'
        ], $configuration, [
            'fields' => function () {
                return [
                    'name' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'Name of the content dimension',
                        'resolve' => function(array $dimension) {
                            return $dimension['name'];
                        }
                    ],
                    'values' => [
                        'type' => Type::listOf(Type::string()),
                        'description' => 'Possible dimension values',
                        'resolve' => function(array $dimension) {
                            return $dimension['values'];
                        }
                    ]
                ];
            }
        ]));
    }
}

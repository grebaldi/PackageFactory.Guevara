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
 * GraphQl representation of a node property
 */
class Property extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'Property',
            'description' => 'A node property',
        ], $configuration, [
            'fields' => [
                'name' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Name of the property',
                    'resolve' => function(array $propertyDescriptor) {
                        return $propertyDescriptor['name'];
                    }
                ],
                'type' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'Type of the property',
                    'resolve' => function(array $propertyDescriptor) {
                        return $propertyDescriptor['type'];
                    }
                ],
                'value' => [
                    'type' => Type::propertyValueType(),
                    'description' => 'Value of the property',
                    'resolve' => function(array $propertyDescriptor) {
                        return $propertyDescriptor['value'];
                    }
                ]
            ]
        ]));
    }
}

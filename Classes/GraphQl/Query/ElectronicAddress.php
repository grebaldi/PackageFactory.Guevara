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
use Neos\Party\Domain\Model as Party;

/**
 * GraphQl representation of an electronic address
 */
class ElectronicAddress extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'ElectronicAddress',
            'description' => 'An electronic address',
        ], $configuration, [
            'fields' => function () {
                return [
                    'identifier' => [
                        'type' => Type::nonNull(Type::string()),
                        'description' => 'The electronic address type',
                        'resolve' => function (Party\ElectronicAddress $electronicAddress) {
                            return $electronicAddress->getIdentifier();
                        }
                    ],
                    'type' => [
                        'type' => Type::nonNull(Type::electronicAddressType()),
                        'description' => 'The electronic address type',
                        'resolve' => function (Party\ElectronicAddress $electronicAddress) {
                            return $electronicAddress->getType();
                        }
                    ],
                    'usage' => [
                        'type' => Type::nonNull(Type::electronicAddressType()),
                        'description' => 'The electronic address usage',
                        'resolve' => function (Party\ElectronicAddress $electronicAddress) {
                            return $electronicAddress->getUsage();
                        }
                    ],
                    'isApproved' => [
                        'type' => Type::boolean(),
                        'description' => 'Indicates whether this electronic address has been approved',
                        'resolve' => function (Party\ElectronicAddress $electronicAddress) {
                            return $electronicAddress->isApproved();
                        }
                    ]
                ];
            }
        ]));
    }
}

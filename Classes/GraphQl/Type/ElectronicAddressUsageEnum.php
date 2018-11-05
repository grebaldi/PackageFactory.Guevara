<?php
namespace Neos\Neos\Ui\GraphQl\Type;

/*
 * This file is part of the Neos.Neos.Ui package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use GraphQL\Type\Definition\EnumType;
use Neos\Party\Domain\Model\ElectronicAddress;

/**
 * GraphQl representation of an electronic address usage
 */
final class ElectronicAddressUsageEnum extends EnumType
{
    public function __construct()
    {
        return parent::__construct([
            'name' => 'ElectronicAddressUsage',
            'description' => 'All available electronic address usages',
            'values' => [
                'USAGE_HOME' => [ 'value' =>  ElectronicAddress::USAGE_HOME],
                'USAGE_WORK' => [ 'value' =>  ElectronicAddress::USAGE_WORK]
            ]
        ]);
    }
}

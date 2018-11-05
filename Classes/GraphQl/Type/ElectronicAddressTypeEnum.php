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
 * GraphQl representation of an electronic address type
 */
final class ElectronicAddressTypeEnum extends EnumType
{
    public function __construct()
    {
        return parent::__construct([
            'name' => 'ElectronicAddressType',
            'description' => 'All available electronic address types',
            'values' => [
                'TYPE_AIM' => [ 'value' =>  ElectronicAddress::TYPE_AIM],
                'TYPE_EMAIL' => [ 'value' =>  ElectronicAddress::TYPE_EMAIL],
                'TYPE_ICQ' => [ 'value' =>  ElectronicAddress::TYPE_ICQ],
                'TYPE_JABBER' => [ 'value' =>  ElectronicAddress::TYPE_JABBER],
                'TYPE_MSN' => [ 'value' =>  ElectronicAddress::TYPE_MSN],
                'TYPE_SIP' => [ 'value' =>  ElectronicAddress::TYPE_SIP],
                'TYPE_SKYPE' => [ 'value' =>  ElectronicAddress::TYPE_SKYPE],
                'TYPE_URL' => [ 'value' =>  ElectronicAddress::TYPE_URL],
                'TYPE_YAHOO' => [ 'value' =>  ElectronicAddress::TYPE_YAHOO],
            ]
        ])
    }
}

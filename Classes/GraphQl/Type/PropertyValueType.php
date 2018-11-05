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

use GraphQL\Type\Definition as GraphQl;
use Neos\Neos\Ui\GraphQl\Exception;

/**
 * Extensible (via configuration) all-purpose property value type
 */
final class PropertyValueType extends GraphQl\UnionType
{
    public function __construct()
    {
        return parent::__construct([
            'name' => 'PropertyValue',
            'types' => function () {
                throw new Exception\NotImplementedYetException('PropertyValueType::types');
            },
            'resolveType' => function () {
                throw new Exception\NotImplementedYetException('PropertyValueType::resolveType');
            }
        ]);
    }
}

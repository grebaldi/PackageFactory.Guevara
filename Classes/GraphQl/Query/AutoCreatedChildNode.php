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
 * GraphQl representation of an auto created child node
 */
class AutoCreatedChildNode extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'AutoCreatedChildNode',
            'description' => 'An auto created child node',
        ], $configuration, [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the auto created child node',
                'resolve' => function (array $autoCreatedChildNodeDescriptor) {
                    return $autoCreatedChildNodeDescriptor['name'];
                }
            ],
            'nodeType' => [
                'type' => Type::nonNull(Type::nodeType()),
                'description' => 'The node type of the auto created child node',
                'resolve' => function (array $autoCreatedChildNodeDescriptor) {
                    return $autoCreatedChildNodeDescriptor['childNodeType'];
                }
            ],
            'owningNodeType' => [
                'type' => Type::nonNull(Type::nodeType()),
                'description' => 'The owning node type of the auto created child node',
                'resolve' => function (array $autoCreatedChildNodeDescriptor) {
                    return $autoCreatedChildNodeDescriptor['owningNodeType'];
                }
            ]
        ]))
    }
}

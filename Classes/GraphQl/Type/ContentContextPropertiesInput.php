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

use GraphQL\Type\Definition\InputObjectType;

/**
 * GraphQl representation of content context properties
 */
class ContentContextPropertiesInput extends InputObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'ContentContextProperties',
            'description' => 'Properties for a content context'
        ], $configuration, [
            'fields' => [
                'workspaceName' => [
                    'type' => Type::nonNull(Type::string()),
                    'description' => 'The name of the workspace for the content context'
                ],
                'currentDateTime' => [
                    'type' => Type::dateTimeScalar(),
                    'description' => 'The current date time according to the content context'
                ],
                'dimensions' => [
                    'type' => new InputObjectType([
                        'name' => 'Dimensions',
                        'description' => 'A set of content dimensions',
                        'fields' => [
                            'key' => [
                                'type' => Type::nonNull(Type::string())
                            ],
                            'values' => [
                                'type' => Type::listOf(Type::nonNull(Type::string()))
                            ]
                        ]
                    ])
                ],
                'targetDimensions' => [
                    'type' => new InputObjectType([
                        'name' => 'TargetDimensions',
                        'description' => 'A set of target dimensions',
                        'fields' => [
                            'key' => [
                                'type' => Type::nonNull(Type::string())
                            ],
                            'value' => [
                                'type' => Type::nonNull(Type::string())
                            ]
                        ]
                    ])
                ],
                'invisibleContentShown' => [
                    'type' => Type::boolean(),
                    'description' => 'Indicates whether invisible content should be made visible in the content context'
                ],
                'removedContentShown' => [
                    'type' => Type::boolean(),
                    'description' => 'Indicates whether removed content should be made visible in the content context'
                ],
                'inaccessibleContentShown' => [
                    'type' => Type::boolean(),
                    'description' => 'Indicates whether inaccessible content should be made visible in the content context'
                ]
            ]
        ]));
    }
}

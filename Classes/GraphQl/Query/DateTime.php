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
 * A GraphQl representation of a \DateTime object
 */
class DateTime extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'DateTime',
            'description' => 'Date and Time',
        ], $configuration, [
            'fields' => function () {
                return [
                    'format' => [
                        'type' => Type::string(),
                        'description' => 'Format date and time',
                        'args' => [
                            'format' => [
                                'type' => Type::string(),
                                'description' => 'The format, see http://php.net/manual/de/function.date.php',
                                'defaultValue' => \DateTime::ATOM
                            ]
                        ],
                        'resolve' => function (\DateTimeInterface $dateTime, array $arguments) {
                            return $dateTime->format($arguments['format']);
                        }
                    ]
                ];
            }
        ]));
    }
}

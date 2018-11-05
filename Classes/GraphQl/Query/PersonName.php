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
 * GraphQl representation of a person name
 */
class PersonName extends ObjectType
{
    /**
     * Constructor
     *
     * @param array $configuration Can be used to override definition
     */
    public function __construct(array $configuration = [])
    {
        return parent::__construct(array_merge([
            'name' => 'PersonName',
            'description' => 'A person name',
        ], $configuration, [
            'firstName' => [
                'type' => Type::string(),
                'description' => 'The first name',
                'resolve' => function (Party\PersonName $personName) {
                    return $personName->getFirstName();
                }
            ],
            'middleName' => [
                'type' => Type::string(),
                'description' => 'The middle name',
                'resolve' => function (Party\PersonName $personName) {
                    return $personName->getMiddleName();
                }
            ],
            'lastName' => [
                'type' => Type::string(),
                'description' => 'The last name',
                'resolve' => function (Party\PersonName $personName) {
                    return $personName->getLastName();
                }
            ],
            'title' => [
                'type' => Type::string(),
                'description' => 'The title',
                'resolve' => function (Party\PersonName $personName) {
                    return $personName->getTitle();
                }
            ],
            'otherName' => [
                'type' => Type::string(),
                'description' => 'Another name',
                'resolve' => function (Party\PersonName $personName) {
                    return $personName->getOtherName();
                }
            ],
            'alias' => [
                'type' => Type::string(),
                'description' => 'An alias',
                'resolve' => function (Party\PersonName $personName) {
                    return $personName->getAlias();
                }
            ],
            'fullName' => [
                'type' => Type::string(),
                'description' => 'The full name',
                'resolve' => function (Party\PersonName $personName) {
                    return $personName->getFullName();
                }
            ]
        ]));
    }
}

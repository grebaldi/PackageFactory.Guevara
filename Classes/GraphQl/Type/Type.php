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
use Neos\Neos\Ui\GraphQl\Query;

/**
 * Expanded Type index containing base types and Neos-specific types
 */
class Type extends GraphQl\Type
{
    /**
     * @var Query\ContentContext
     */
    private static $contentContext;

    /**
     * @var ContentContextPropertiesInput
     */
    private static $contentContextPropertiesInput;

    /**
     * @var Query\NodeType
     */
    private static $nodeType;

    /**
     * @var Query\Node
     */
    private static $node;

    /**
     * @var Query\Workspace
     */
    private static $workspace;

    /**
     * @var Query\Property
     */
    private static $property;

    /**
     * @var Query\AutoCreatedChildNode
     */
    private static $autoCreatedChildNode;

    /**
     * @var Query\Dimension
     */
    private static $dimension;

    /**
     * @var Query\TargetDimension
     */
    private static $targetDimension;

    /**
     * @var Query\User
     */
    private static $user;

    /**
     * @var Query\ElectronicAddress
     */
    private static $electronicAddress;

    /**
     * @var Query\PersonName
     */
    private static $personName;

    /**
     * @var Query\Account
     */
    private static $account;

    /**
     * @var Query\Role
     */
    private static $role;

    /**
     * @var Query\UserPreferences
     */
    private static $userPreferences;

    /**
     * @var DateTimeScalarTime
     */
    private static $dateTime;

    /**
     * @var DateTimeScalar
     */
    private static $dateTimeScalar;

    /**
     * @return JsonScalar
     */
    private static $json;

    /**
     * @return ElectronicAddressTypeEnum
     */
    private static $electronicAddressType;

    /**
     * @return ElectronicAddressUsageEnum
     */
    private static $electronicAddressUsage;

    /**
     * @return Query\ContentContext
     */
    public static function contentContext() : Query\ContentContext
    {
        return self::$contentContext ?: (self::$contentContext = new Query\ContentContext());
    }

    /**
     * @return ContentContextPropertiesInput
     */
    public static function contentContextPropertiesInput() : ContentContextPropertiesInput
    {
        return self::$contentContextPropertiesInput ?: (self::$contentContextPropertiesInput = new ContentContextPropertiesInput());
    }

    /**
     * @return Query\NodeType
     */
    public static function nodeType() : Query\NodeType
    {
        return self::$nodeType ?: (self::$nodeType = new Query\NodeType());
    }

    /**
     * @return Query\Node
     */
    public static function node() : Query\Node
    {
        return self::$node ?: (self::$node = new Query\Node());
    }

    /**
     * @return Query\Workspace
     */
    public static function workspace() : Query\Workspace
    {
        return self::$workspace ?: (self::$workspace = new Query\Workspace());
    }

    /**
     * @return Query\Property
     */
    public static function property() : Query\Property
    {
        return self::$property ?: (self::$property = new Query\Property());
    }

    /**
     * @return Query\AutoCreatedChildNode
     */
    public static function autoCreatedChildNode() : Query\AutoCreatedChildNode
    {
        return self::$autoCreatedChildNode ?: (self::$autoCreatedChildNode = new Query\AutoCreatedChildNode());
    }

    /**
     * @return Query\Dimension
     */
    public static function dimension() : Query\Dimension
    {
        return self::$dimension ?: (self::$dimension = new Query\Dimension());
    }

    /**
     * @return Query\TargetDimension
     */
    public static function targetDimension() : Query\TargetDimension
    {
        return self::$targetDimension ?: (self::$targetDimension = new Query\TargetDimension());
    }

    /**
     * @return Query\User
     */
    public static function user() : Query\User
    {
        return self::$user ?: (self::$user = new Query\User());
    }

    /**
     * @return Query\ElectronicAddress
     */
    public static function electronicAddress() : Query\ElectronicAddress
    {
        return self::$electronicAddress ?: (self::$electronicAddress = new Query\ElectronicAddress());
    }

    /**
     * @return Query\PersonName
     */
    public static function personName() : Query\PersonName
    {
        return self::$personName ?: (self::$personName = new Query\PersonName());
    }

    /**
     * @return Query\Account
     */
    public static function account() : Query\Account
    {
        return self::$account ?: (self::$account = new Query\Account());
    }

    /**
     * @return Query\Role
     */
    public static function role() : Query\Role
    {
        return self::$role ?: (self::$role = new Query\Role());
    }

    /**
     * @return Query\UserPreferences
     */
    public static function userPreferences() : Query\UserPreferences
    {
        return self::$userPreferences ?: (self::$userPreferences = new Query\UserPreferences());
    }

    /**
     * @return Query\DateTime
     */
    public static function dateTime() : Query\DateTime
    {
        return self::$dateTime ?: (self::$dateTime = new Query\DateTime());
    }

    /**
     * @return DateTimeScalar
     */
    public static function dateTimeScalar() : DateTimeScalar
    {
        return self::$dateTimeScalar ?: (self::$dateTimeScalar = new DateTimeScalar());
    }

    /**
     * @return JsonScalar
     */
    public static function json() : JsonScalar
    {
        return self::$json ?: (self::$json = new JsonScalar());
    }

    /**
     * @return ElectronicAddressTypeEnum
     */
    public static function electronicAddressType() : ElectronicAddressTypeEnum
    {
        return self::$electronicAddressType ?: (self::$electronicAddressType = new ElectronicAddressTypeEnum());
    }

    /**
     * @return ElectronicAddressUsageEnum
     */
    public static function electronicAddressUsage() : ElectronicAddressUsageEnum
    {
        return self::$electronicAddressUsage ?: (self::$electronicAddressUsage = new ElectronicAddressUsageEnum());
    }
}

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

use GraphQL\Language\AST\Node as AstNode;
use GraphQL\Language\AST\StringValue;
use GraphQL\Type\Definition\ScalarType;

class DateTimeScalar extends ScalarType
{
    /**
     * @var string
     */
    public $name = 'DateTimeScalar';

    /**
     * @var string
     */
    public $description = 'Date and Time, represented as ISO 8601 conform string, (see: http://php.net/manual/de/class.datetimeinterface.php#datetime.constants.iso8601)';

    /**
     * @param \DateTimeInterface $value
     * @return string
     */
    public function serialize($value)
    {
        if (!$value instanceof \DateTimeInterface) {
            return null;
        }

        return $value->format(DATE_ISO8601);
    }

    /**
     * @param string $value
     * @return \DateTimeImmutable
     */
    public function parseValue($value)
    {
        if (!is_string($value)) {
            return null;
        }

        $dateTime = \DateTimeImmutable::createFromFormat(DATE_ISO8601, $value);

        if ($dateTime === false) {
            return null;
        }

        return $dateTime;
    }

    /**
     * @param AstNode $valueAST
     * @return \DateTimeImmutable
     */
    public function parseLiteral($valueAST)
    {
        if (!$valueAST instanceof StringValue) {
            return null;
        }

        return $this->parseValue($valueAST->value);
    }
}

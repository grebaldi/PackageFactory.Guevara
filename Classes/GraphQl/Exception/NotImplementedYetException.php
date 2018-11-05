<?php
namespace neos\Neos\Ui\GraphQl\Exception;

/*
 * This file is part of the Neos.Neos.Ui package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

class NotImplementedYetException extends \Exception
{
        /**
     * @param string $message
     * @param integer $code
     * @param \Exception $previous
     */
    public function __construct($message = null, $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            $message ?: $this->getDebugMessage(),
            $code,
            $previous
        );
    }

    /**
     * @return string
     */
    private function getDebugMessage(): string
    {
        return sprintf(
            '%s::%s has not been implemented yet',
            str_replace('_Original', '', debug_backtrace()[2]['class']),
            debug_backtrace()[2]['function']
        );
    }
}

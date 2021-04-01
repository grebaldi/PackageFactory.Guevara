<?php
namespace Neos\Neos\Ui\Application\Controller;

/*
 * This file is part of the Neos.Neos.Ui package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Annotations as Flow;
use TheCodingMachine\GraphQLite\Annotations\Query;

/**
 * @Flow\Scope("singleton")
 */
final class QueryController
{
    /**
     * If there's something strange...
     * ...in the neighborhood...
     * ...who you're gonna call?
     * @Query
     */
    public function ping(): string
    {
        return 'pong';
    }
}

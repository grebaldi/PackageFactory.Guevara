<?php

namespace Neos\Neos\Ui\Service;

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
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Neos\Fusion\ContentElementWrappingStrategyInterface;

#[Flow\Scope("singleton")]
final class ContentElementWrappingStrategy implements ContentElementWrappingStrategyInterface
{
    public function wrapContentElement(string $renderedContent, NodeInterface $node, string $fusionPath): string
    {
        return sprintf(
            '<!--start:neos-ui-content-element:%s-->%s<!--end:neos-ui-content-element:%s-->',
            $node->getContextPath(),
            $renderedContent,
            $node->getContextPath()
        );
    }

    public function wrapContentCollection(string $renderedContent, NodeInterface $node): string
    {
        return sprintf(
            '%s<!--neos-ui-insertion-anchor:%s-->',
            $renderedContent,
            $node->getContextPath()
        );
    }

    public function wrapEditableProperty(string $renderedContent, NodeInterface $node, string $propertyName): string
    {
        return sprintf(
            '<!--neos-ui-editable:%s#%s-->%s',
            $node->getContextPath(),
            $propertyName,
            $renderedContent
        );
    }
}

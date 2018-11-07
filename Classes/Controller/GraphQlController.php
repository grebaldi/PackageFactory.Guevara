<?php
namespace Neos\Neos\Ui\Controller;

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
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Flow\Mvc\View\JsonView;
use Neos\FluidAdaptor\View\TemplateView;
use Neos\Neos\Ui\GraphQl\Query;
use GraphQL\GraphQL;
use GraphQL\Schema;

class GraphQlController extends ActionController
{
    /**
     * @var array
     */
    protected $supportedMediaTypes = [
        'application/json',
        'text/html'
    ];

    /**
     * @var array
     */
    protected $viewFormatToObjectNameMap = [
        'json' => JsonView::class,
        'html' => TemplateView::class
    ];

    /**
     * @return void
     */
    public function indexAction()
    {
    }

    /**
     * @param string $query
     * @param array $variables
     * @param string $operationName
     * @return void
     */
    public function endpointAction(string $query, $variables = null, string $operationName = null)
    {
        $schema = new Schema([
            'query' => new Query\Root()
        ]);

        $result = GraphQL::execute(
            $schema,
            $query,
            null,
            null,
            $variables,
            $operationName
        );

        $this->view->assign('value', $result);
    }
}

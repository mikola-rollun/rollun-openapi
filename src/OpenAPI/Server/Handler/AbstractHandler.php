<?php
declare(strict_types=1);

namespace OpenAPI\Server\Handler;

use Articus\PathHandler\Exception\HttpCode;
use OpenAPI\Server\Producer\Transfer;
use OpenAPI\Server\Rest\RestInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\RouteResult;

/**
 * Class AbstractHandler
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
abstract class AbstractHandler
{
    /**
     * @var RestInterface
     */
    protected $restObject;

    /**
     * @param ServerRequestInterface $request
     * @param string                 $method
     *
     * @return array
     */
    protected function runAction(ServerRequestInterface $request, string $method, $operationId = null)
    {
        // get errors
        $errors = $request->getAttribute('errors');

        if (!empty($errors)) {
            throw new HttpCode(500, "Request validation failed. Details: " . Transfer::errorsToStr($errors));
        }

        // prepare input data
        $id = empty($request->getAttribute('id')) ? null : $request->getAttribute('id');
        $queryData = empty($request->getAttribute('queryData')) ? null : $request->getAttribute('queryData');
        $bodyData = empty($request->getAttribute('bodyData')) ? null : $request->getAttribute('bodyData');

        $restObject = $this->restObject;

        if ($operationId && method_exists($restObject, $operationId)) {
            $pathData = array_intersect_key(
                $request->getAttributes(),
                $request->getAttribute(RouteResult::class)->getMatchedParams()
            );
            return $this->runCustomAction($operationId, $pathData, $queryData, $bodyData);
        }

        switch ($method) {
            case 'Post()':
                $result = $restObject->post($bodyData);
                break;
            case 'Put()':
                $result = $restObject->putById($id, $bodyData);
                break;
            case 'Patch()':
                if (!empty($id)) {
                    $result = $restObject->patchById($id, $bodyData);
                } else {
                    $result = $restObject->patch($queryData, $bodyData);
                }
                break;
            case 'Delete()':
                if (!empty($id)) {
                    $result = $restObject->deleteById($id);
                } else {
                    $result = empty($queryData) ? $restObject->delete() : $restObject->delete($queryData);
                }
                break;
            case 'Get()':
                if (!empty($id)) {
                    $result = $restObject->getById($id);
                } else {
                    $result = empty($queryData) ? $restObject->get() : $restObject->get($queryData);
                }
                break;
            default:
                throw new \InvalidArgumentException('Unknown http method');
        }

        return $result;
    }

    protected function runCustomAction($operationId, $pathData, $queryData, $bodyData)
    {
        $params = [];
        if ($pathData) {
            $params = array_merge($params, $pathData);
        }
        if ($queryData) {
            $params['queryData'] = $queryData;
        }
        if ($bodyData) {
            $params['bodyData'] = $bodyData;
        }

        return call_user_func_array([$this->restObject, $operationId], $params);
    }
}

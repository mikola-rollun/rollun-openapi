<?php
declare(strict_types=1);


namespace DataStoreExample\OpenAPI\V1\Server\Handler;

use Articus\PathHandler\Annotation as PHA;
use Articus\PathHandler\Consumer as PHConsumer;
use Articus\PathHandler\Producer as PHProducer;
use Articus\PathHandler\Attribute as PHAttribute;
use Articus\PathHandler\Exception as PHException;
use OpenAPI\Server\Producer\Transfer;
use OpenAPI\Server\Handler\AbstractHandler;
use OpenAPI\Server\Rest\RestInterface;
use Psr\Http\Message\ServerRequestInterface;
use rollun\dic\InsideConstruct;

/**
 * @PHA\Route(pattern="/User")
 */
class User extends AbstractHandler
{
    /**
     * ATTENTION! REST_OBJECT should be declared in service manager
     */
    public const REST_OBJECT = \DataStoreExample\OpenAPI\V1\Server\Rest\User::class;

    /**
     * User constructor.
     *
     * @param RestInterface|null $restObject
     *
     * @throws \ReflectionException
     */
    public function __construct(RestInterface $restObject = null)
    {
        InsideConstruct::init(['restObject' => self::REST_OBJECT]);
    }

    /**
     * @PHA\Delete()
     * @PHA\Attribute(name=PHAttribute\Transfer::class, options={
     *     "type":\DataStoreExample\OpenAPI\V1\DTO\UserDELETEQueryData::class,
     *     "objectAttr":"queryData",
     *     "source": PHAttribute\Transfer::SOURCE_GET
     * })
     * @PHA\Producer(name=Transfer::class, mediaType="application/json", options={"responseType":\DataStoreExample\OpenAPI\V1\DTO\Result::class})
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    public function userDelete(ServerRequestInterface $request)
    {
        return $this->runAction($request, 'Delete()', 'userDelete');
    }
    /**
     * @PHA\Get()
     * @PHA\Attribute(name=PHAttribute\Transfer::class, options={
     *     "type":\DataStoreExample\OpenAPI\V1\DTO\UserGETQueryData::class,
     *     "objectAttr":"queryData",
     *     "source": PHAttribute\Transfer::SOURCE_GET
     * })
     * @PHA\Producer(name=Transfer::class, mediaType="application/json", options={"responseType":\DataStoreExample\OpenAPI\V1\DTO\UsersResult::class})
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    public function userGet(ServerRequestInterface $request)
    {
        return $this->runAction($request, 'Get()', 'userGet');
    }
    /**
     * @PHA\Patch()
     * @PHA\Attribute(name=PHAttribute\Transfer::class, options={
     *     "type":\DataStoreExample\OpenAPI\V1\DTO\UserPATCHQueryData::class,
     *     "objectAttr":"queryData",
     *     "source": PHAttribute\Transfer::SOURCE_GET
     * })
     * TODO check if consumer is valid, if it has correct priority and if it can be moved to class annotation
     * @PHA\Consumer(name=PHConsumer\Json::class, mediaRange="application/json")
     * @PHA\Attribute(name=PHAttribute\Transfer::class, options={"type":\DataStoreExample\OpenAPI\V1\DTO\User::class,"objectAttr":"bodyData", "errorAttr":"errors"})
     * @PHA\Producer(name=Transfer::class, mediaType="application/json", options={"responseType":\DataStoreExample\OpenAPI\V1\DTO\UsersResult::class})
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    public function userPatch(ServerRequestInterface $request)
    {
        return $this->runAction($request, 'Patch()', 'userPatch');
    }
    /**
     * @PHA\Post()
     * TODO check if consumer is valid, if it has correct priority and if it can be moved to class annotation
     * @PHA\Consumer(name=PHConsumer\Json::class, mediaRange="application/json")
     * TODO check if attribute is valid and can handle your container type
     * @PHA\Attribute(name=PHAttribute\Transfer::class, options={"type":"\DataStoreExample\OpenAPI\V1\DTO\PostUser[]","objectAttr":"bodyData", "errorAttr":"errors"})
     * @PHA\Producer(name=Transfer::class, mediaType="application/json", options={"responseType":\DataStoreExample\OpenAPI\V1\DTO\UsersResult::class})
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    public function userPost(ServerRequestInterface $request)
    {
        return $this->runAction($request, 'Post()', 'userPost');
    }
}

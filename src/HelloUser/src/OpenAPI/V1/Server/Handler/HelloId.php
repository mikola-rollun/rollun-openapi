<?php
declare(strict_types=1);


namespace HelloUser\OpenAPI\V1\Server\Handler;

use Articus\PathHandler\Annotation as PHA;
use Articus\PathHandler\Consumer as PHConsumer;
use Articus\PathHandler\Producer as PHProducer;
use Articus\PathHandler\Attribute as PHAttribute;
use Articus\PathHandler\Exception as PHException;
use HelloUser\OpenAPI\V1\Server\Rest\HelloInterface;
use OpenAPI\Server\Producer\Transfer;
use OpenAPI\Server\Handler\AbstractHandler;
use OpenAPI\Server\Rest\RestInterface;
use Psr\Http\Message\ServerRequestInterface;
use rollun\dic\InsideConstruct;

/**
 * @PHA\Route(pattern="/Hello/{id}")
 */
class HelloId extends AbstractHandler
{
    /**
     * HelloId constructor.
     *
     * @param HelloInterface|null $restObject
     *
     * @throws \ReflectionException
     */
    public function __construct(HelloInterface $restObject = null)
    {
        InsideConstruct::init(['restObject' => HelloInterface::class]);
    }

    /**
     * @PHA\Get()
     * @PHA\Producer(name=Transfer::class, mediaType="application/json", options={"responseType":\HelloUser\OpenAPI\V1\DTO\HelloResult::class})
     * @param ServerRequestInterface $request
     *
     * @return array
     */
    public function helloIdGet(ServerRequestInterface $request)
    {
        return $this->runAction($request, 'Get()');
    }
}

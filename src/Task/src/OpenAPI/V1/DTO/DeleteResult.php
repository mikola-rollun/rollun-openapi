<?php
declare(strict_types=1);

namespace Task\OpenAPI\V1\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 */
class DeleteResult
{
    /**
     * @DTA\Data(field="data", nullable=true)
     * @DTA\Strategy(name="Object", options={"type":\Task\OpenAPI\V1\DTO\Delete::class})
     * @DTA\Validator(name="TypeCompliant", options={"type":\Task\OpenAPI\V1\DTO\Delete::class})
     * @var \Task\OpenAPI\V1\DTO\Delete
     */
    public $data;
    /**
     * @DTA\Data(field="messages", nullable=true)
     * TODO check validator and strategy are correct and can handle container item type
     * @DTA\Strategy(name="ObjectArray", options={"type":\Task\OpenAPI\V1\DTO\Message::class})
     * @DTA\Validator(name="Collection", options={"validators":{
     *     {"name":"TypeCompliant", "options":{"type":\Task\OpenAPI\V1\DTO\Message::class}}
     * }})
     * @var \Task\OpenAPI\V1\DTO\Message[]
     */
    public $messages;
}

<?php
declare(strict_types=1);

namespace DataStoreExample\OpenAPI\V1\DTO;

use Articus\DataTransfer\Annotation as DTA;

/**
 * Query parameters for userGET
 */
class UserGETQueryData
{
    /**
     * @DTA\Data(field="offset", nullable=true)
     * @DTA\Strategy(name="QueryParameter", options={"type":"int"})
     * @DTA\Validator(name="QueryParameterType", options={"type":"int"})
     * @var int
     */
    public $offset;
    /**
     * @DTA\Data(field="sortOrder", nullable=true)
     * @DTA\Strategy(name="QueryParameter", options={"type":"string"})
     * @DTA\Validator(name="QueryParameterType", options={"type":"string"})
     * @DTA\Validator(name="Enum", options={"allowed":{
     *      "'asc'",
     *      "'desc'"
     * }})
     * @var string
     */
    public $sortOrder;
    /**
     * @DTA\Data(field="limit", nullable=true)
     * @DTA\Strategy(name="QueryParameter", options={"type":"int"})
     * @DTA\Validator(name="QueryParameterType", options={"type":"int"})
     * @var int
     */
    public $limit;
    /**
     * @DTA\Data(field="sortBy", nullable=true)
     * @DTA\Strategy(name="QueryParameter", options={"type":"string"})
     * @DTA\Validator(name="QueryParameterType", options={"type":"string"})
     * @var string
     */
    public $sortBy;
    /**
     * @DTA\Data(field="rql", nullable=true)
     * @DTA\Strategy(name="QueryParameter", options={"type":"string"})
     * @DTA\Validator(name="QueryParameterType", options={"type":"string"})
     * @var string
     */
    public $rql;
}

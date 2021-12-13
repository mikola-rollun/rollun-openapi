<?php

namespace Test\OpenAPI\V1_0_1\Client\Rest;

use OpenAPI\Client\Rest\BaseAbstract;

/**
 * Class Test
 */
class Test extends BaseAbstract
{
	public const API_NAME = '\Test\OpenAPI\V1_0_1\Client\Api\TestApi';

	/**
	 * @inheritDoc
	 *
	 * @param array $queryData
	 */
	public function get($queryData = [])
	{
		// validation of $queryData
		if ($queryData instanceof \Test\OpenAPI\V1_0_1\DTO\TestGETQueryData) {
		    $queryData = $this->toArray($queryData);
		}
		$queryDataObject = $this->transfer((array)$queryData, '\Test\OpenAPI\V1_0_1\DTO\TestGETQueryData');


		// send request
		$data = $this->getApi()->testGet($queryDataObject->name, $queryDataObject->id, $queryDataObject->test);

		// validation of response
		$result = $this->transfer((array)$data, \Test\OpenAPI\V1_0_1\DTO\Collection::class);

		return $result;
	}


	/**
	 * @return \Test\OpenAPI\V1_0_1\Client\Api\TestApi
	 */
	protected function getApi(): \OpenAPI\Client\Api\ApiInterface
	{
		return $this->api;
	}


	/**
	 * @inheritDoc
	 */
	public function getById($id)
	{
		// send request
		$data = $this->getApi()->testIdGet($id);

		// validation of response
		$result = $this->transfer((array)$data, \Test\OpenAPI\V1_0_1\DTO\Test::class);

		return $result;
	}


	/**
	 * @inheritDoc
	 */
	public function testPathParamCustomGet($pathParam, $queryParam = null, $arrayParam = null)
	{
		if (is_array($arrayParam)) {
		    $arrayParam = implode(',', $arrayParam);
		}


		// send request
		$data = $this->getApi()->testPathParamCustomGet($pathParam, $queryParam, $arrayParam);

		// validation of response
		$result = $this->transfer((array)$data, \Test\OpenAPI\V1_0_1\DTO\TestCustomResponse::class);

		return $result;
	}


	/**
	 * @inheritDoc
	 *
	 * @param array $bodyData
	 */
	public function post($bodyData = null)
	{
		// validation of $bodyData
		if ($bodyData instanceof \Test\OpenAPI\V1_0_1\DTO\Test) {
		    $bodyData = $this->toArray($bodyData);
		}
		$bodyDataObject = $this->transfer((array)$bodyData, '\Test\OpenAPI\V1_0_1\DTO\Test');


		// send request
		$data = $this->getApi()->testPost($bodyData);

		// validation of response
		$result = $this->transfer((array)$data, \Test\OpenAPI\V1_0_1\DTO\Test::class);

		return $result;
	}
}

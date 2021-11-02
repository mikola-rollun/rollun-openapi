<?php

declare(strict_types=1);

namespace HelloUser\User\Controller\V1;

use Articus\DataTransfer\Service as DataTransferService;
use HelloUser\OpenAPI\V1\DTO\User;
use HelloUser\OpenAPI\V1\DTO\UserResult;
use HelloUser\OpenAPI\V1\UserInterface;

class UserController implements UserInterface
{
    const DIR = 'data/examples/user';
    /**
     * @var DataTransferService
     */
    private $dataTransfer;

    public function __construct(DataTransferService $dataTransfer)
    {
        $this->dataTransfer = $dataTransfer;
    }

    /**
     * @param $id
     *
     * @return string
     */
    protected function getFilePath($id): string
    {
        return self::DIR . '/' . $id . '.json';
    }

    public function post(User $bodyData): UserResult
    {
        if (!file_exists(self::DIR)) {
            mkdir(self::DIR, 0777, true);
            sleep(1);
        }

        // prepare fileName
        $fileName = $this->getFilePath($bodyData->id);

        if (file_exists($fileName)) {
            throw new \InvalidArgumentException('Such user already exists');
        }

        // save data to file
        file_put_contents($fileName, json_encode(['id' => $bodyData->id, 'name' => $bodyData->name]));
        sleep(1);

        return $this->getById($bodyData->id);
    }

    public function getById(string $id): UserResult
    {
        // prepare fileName
        $fileName = $this->getFilePath($id);

        if (!file_exists($fileName)) {
            throw new \InvalidArgumentException('No such user');
        }

        return $this->transfer([
            'data' => json_decode(file_get_contents($fileName), true)
        ]);
    }

    private function transfer(array $array): UserResult
    {
        $result = new UserResult();
        $this->dataTransfer->transferToTypedData($array, $result);
        return $result;
    }
}
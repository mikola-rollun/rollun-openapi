<?php
declare(strict_types=1);

namespace OpenAPI;

use OpenAPI\Client\Factory\ApiAbstractFactory;
use OpenAPI\Client\Factory\RestAbstractFactory;
use OpenAPI\Client\Factory\ConfigurationAbstractFactory;
use OpenAPI\Config\DataTransferConfig;
use OpenAPI\Config\PathHandlerConfig;
use OpenAPI\Server\Response\MessageCollector;
use OpenAPI\Server\Response\MessageReaderInterface;
use OpenAPI\Server\Response\MessageWriterInterface;
use OpenAPI\Server\Validator;
use Laminas\Validator\ValidatorPluginManager;
use Laminas\Validator\ValidatorPluginManagerFactory;

/**
 * Class ConfigProvider
 *
 * @author r.ratsun <r.ratsun.rollun@gmail.com>
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        $config = [
            'dependencies' => [
                'aliases' => [
                    MessageWriterInterface::class => MessageCollector::class,
                    MessageReaderInterface::class => MessageCollector::class
                ],
                'abstract_factories' => [
                    RestAbstractFactory::class,
                    ApiAbstractFactory::class,
                    ConfigurationAbstractFactory::class,
                ],
                'invokables' => [
                    MessageCollector::class
                ]
            ],
        ];

        $zendValidatorsConfig = $this->getZendValidatorsPluginManagerConfig();
        $dataTransferConfig = DataTransferConfig::getConfig();
        $pathHandlerConfig = PathHandlerConfig::getConfig();

        return array_merge_recursive(
            $zendValidatorsConfig,
            $dataTransferConfig,
            $pathHandlerConfig,
            $config
        );
    }

    public function getZendValidatorsPluginManagerConfig(): array
    {
        return [
            'dependencies' => [
                'factories' => [
                    ValidatorPluginManager::class => ValidatorPluginManagerFactory::class
                ],
            ],
            'validators' => [
                'invokables' => [
                    Validator\DateTime::class => Validator\DateTime::class,
                    Validator\Type::class => Validator\Type::class,
                    Validator\Enum::class => Validator\Enum::class,
                    Validator\QueryParameterType::class => Validator\QueryParameterType::class,
                    Validator\QueryParameterArrayType::class => Validator\QueryParameterArrayType::class,
                ],
                'aliases' => [
                    'Date' => Validator\DateTime::class,
                    'Type' => Validator\Type::class,
                    'Enum' => Validator\Enum::class,
                    'QueryParameterType' => Validator\QueryParameterType::class,
                    'QueryParameterArrayType' => Validator\QueryParameterArrayType::class,
                ]
            ],
        ];
    }
}

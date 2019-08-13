<?php

declare(strict_types=1);

namespace Tseguier\AzureSbHealthCheckerBundle\Service;

use Throwable;
use Tseguier\HealthCheckBundle\Dto\HealthData;
use Tseguier\HealthCheckBundle\HealthCheckInterface;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\ServiceBus\Internal\IServiceBus;

final class HealthCheckerService implements HealthCheckInterface
{
    private const UNAUTHORIZED_CODE = 401;
    private const UNAUTHORIZED_MESSAGE = 'Unauthorized';

    private $serviceBuses;

    /**
     * @param IServiceBus[] $serviceBuses
     */
    public function __construct(iterable $serviceBuses)
    {
        $this->serviceBuses = $serviceBuses;
    }

    public function checkHealth(): HealthData
    {
        $status = true;
        foreach ($this->serviceBuses as $serviceBus) {
            if (!$this->getStatus($serviceBus)) {
                $status = false;
            }
        }

        return new HealthData($status);
    }

    public function getStatus(IServiceBus $serviceBus): bool
    {
        try {
            $serviceBus->listQueues();

            return true;
        } catch (ServiceException $exception) {
            if (self::UNAUTHORIZED_CODE === $exception->getCode() && 'Unauthorized' === $exception->getErrorText()) {
                return true;
            }
        } catch (Throwable $exception) {
        }

        return false;
    }
}

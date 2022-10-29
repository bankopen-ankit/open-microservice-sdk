<?php

namespace Bankopen\OpenMicroserviceSdk\Auditing;

use Bankopen\OpenMicroserviceSdk\Utility\RemoteRequest;

/**
 * Class AuditService
 *
 * @author Ankit Tiwari <ankit.tiwari@bankopen.co>
 */
class AuditService
{
    /**
     * https://github.com/Architectural-Documents/audit-log/blob/main/000-audit-log-service.md#data-definition-m---mandatory-o---optional
     * @var array
     */
    private array $paramKeys = [
        'product', 'event_source', 'event_type', 'event_action', 'event_data', 'event_created_at'
    ];
    /**
     * @var array
     */
    private array $headerKeys = ['Authorization'];

    /**
     * @param $url
     * @param $parameters
     * @param $headers
     * @return mixed
     * @throws \Exception
     */
    private function createAudit($url, $parameters, $headers): mixed
    {
        $this->validateKeys($this->paramKeys, $parameters);
        $this->validateKeys($this->headerKeys, $headers);

        return (new RemoteRequest($url, $parameters, $headers))->post();
    }

    /**
     * @param $which
     * @param $keys
     * @throws \Exception
     */
    private function validateKeys($which, $keys)
    {
        foreach ($keys as $key => $value) {
            if (in_array($key, $which)) {
                continue;
            }

            throw new \Exception($key . ' is missing');
        }
    }
}

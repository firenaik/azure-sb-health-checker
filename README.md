# azure-sb-health-checker

A bundle that provides a healthcheck service for Azure Service Bus queues connections. It relies on the [Symfony health check bundle](https://github.com/tseguier/health-check), so please see further configuration there. 

> ⚠️ **Warning**: while this package checks that the queue server is accessible, it does not validate the given credentials. Indeed, as a connection string can give different privileges (read/send/admin), there is no way to find out which functions can be used.

## Installation
Install with composer:

```
composer require tseguier/tseguier/azure-sb-health-checker
```

Add the bundle to your bundles.php

```
Tseguier\HealthCheckBundle\HealthCheckBundle::class => ['all' => true],
```

## Provide Azure ServiceBus connections

Any service tagged with `WindowsAzure\ServiceBus\Internal\IServiceBus` will be injected in the health check service.

To register services, you will need to add the service definition. Here's an example for the default `config/services.yaml` definition file:

```
WindowsAzure\Common\ServicesBuilder:
  factory: ['WindowsAzure\Common\ServicesBuilder', 'getInstance']

app.azure_sb.myservicebus:
  factory: ['@WindowsAzure\Common\ServicesBuilder', 'createServiceBusService']
  arguments: ['my_azure_connection_string']
  tags: ['WindowsAzure\ServiceBus\Internal\IServiceBus']
  class: WindowsAzure\ServiceBusRestProxy
```

The first definition is required in order to use the factory in the second definition. It's only required once.

The second definition can be repeated as many time as you have queues to test.
The main parameter is `arguments` where the value of the string should be a valid connection string as described in [Azure's SDK documentation](https://github.com/Azure/azure-sdk-for-php/blob/master/README.md#getting-started-1).

```
Endpoint=[yourEndpoint];SharedSecretIssuer=[yourWrapAuthenticationName];SharedSecretValue=[yourWrapPassword]
```


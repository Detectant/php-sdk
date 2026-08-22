# Detectant PHP Library

![](https://example.com/banner)

[![fern shield](https://img.shields.io/badge/%F0%9F%8C%BF-Built%20with%20Fern-brightgreen)](https://buildwithfern.com?utm_source=github&utm_medium=github&utm_campaign=readme&utm_source=https%3A%2F%2Fgithub.com%2FDetectant%2Fphp-sdk)
[![php shield](https://img.shields.io/badge/php-packagist-pink)](https://packagist.org/packages/detectant/sdk)

Official SDK for the Detectant malware scanning API

## Table of Contents

- [Install](#install)
- [Create A Client](#create-a-client)
- [Scan One File](#scan-one-file)
- [Scan A Batch](#scan-a-batch)
- [Configuration](#configuration)
- [Documentation](#documentation)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Environments](#environments)
- [Exception Handling](#exception-handling)
- [Advanced](#advanced)
  - [Custom Client](#custom-client)
  - [Retries](#retries)
  - [Timeouts](#timeouts)
- [Contributing](#contributing)

## Install

This SDK requires PHP 8.1 or later and a PSR-18 HTTP client implementation.

```bash
composer require detectant/sdk guzzlehttp/guzzle
```

Set your API key in the environment:

```bash
export DETECTANT_API_KEY="your-api-key"
```

## Create a client

```php
<?php

use Detectant\DetectantClient;

$detectant = new DetectantClient(
    apiKey: getenv('DETECTANT_API_KEY') ?: null,
);
```

By default, requests are sent to `https://api.detectant.com`.

## Scan one file

The simplest PHP option is a file path:

```php
use Detectant\Requests\CreateScanRequest;
use Detectant\Utils\File;

$result = $detectant->scan(new CreateScanRequest([
    'file' => File::createFromFilepath('./invoice.pdf'),
]));

echo $result->verdict . PHP_EOL;
print_r($result->detections);
```

The call completes after the file has been analyzed and returns its scan result.

### Supported file inputs

Choose the input that already fits your application:

```php
use Detectant\Requests\CreateScanRequest;
use Detectant\Utils\File;

// A path — recommended when the file is on disk
$file = File::createFromFilepath('./invoice.pdf');

// File contents already in memory
$file = File::createFromString(
    content: $fileBytes,
    filename: 'invoice.pdf',
    contentType: 'application/pdf',
);

// Any PSR-7 StreamInterface
$file = new File(
    stream: $stream,
    filename: 'invoice.pdf',
    contentType: 'application/pdf',
);

$result = $detectant->scan(new CreateScanRequest([
    'file' => $file,
]));
```

The SDK accepts file paths, in-memory strings, and PSR-7 streams. For in-memory
data and streams, provide a filename and content type when they are known.

## Scan a batch

Upload between 1 and 20 files. Results are returned in the same order as the inputs.

```php
use Detectant\Requests\CreateScanBatchRequest;
use Detectant\Utils\File;

$batch = $detectant->scanBatch(new CreateScanBatchRequest([
    'files' => [
        File::createFromFilepath('./invoice.pdf'),
        File::createFromFilepath('./archive.zip'),
    ],
]));

foreach ($batch->results as $item) {
    if ($item->scan !== null) {
        echo $item->filename . ': ' . $item->scan->verdict . PHP_EOL;
    } else {
        echo $item->filename . ': ' . $item->error . PHP_EOL;
    }
}
```

One file can fail without preventing the other files in the batch from being scanned. Check each item's `scan` and `error` values.

## Configuration

Use `baseUrl` for a self-hosted or local API, and increase the timeout for large files when needed:

```php
$detectant = new DetectantClient(
    apiKey: getenv('DETECTANT_API_KEY') ?: null,
    options: [
        'baseUrl' => 'http://127.0.0.1:8080',
        'timeout' => 120.0,
    ],
);
```

Requests retry transient failures twice by default. Override retries globally or for one request:

```php
$detectant = new DetectantClient(
    apiKey: getenv('DETECTANT_API_KEY') ?: null,
    options: ['maxRetries' => 3],
);

$result = $detectant->scan($request, options: ['maxRetries' => 0]);
```

### Custom HTTP client

The SDK discovers an installed PSR-18 client automatically. You can also provide one explicitly:

```php
use GuzzleHttp\Client;

$detectant = new DetectantClient(
    apiKey: getenv('DETECTANT_API_KEY') ?: null,
    options: [
        'client' => new Client(),
    ],
);
```

## Documentation

API reference documentation is available [here](https://docs.example.com).

## Requirements

This SDK requires PHP ^8.1.

## Installation

```sh
composer require detectant/sdk
```

## Usage

Instantiate and use the client with the following:

```php
<?php

namespace Example;

use Detectant\DetectantClient;
use Detectant\Requests\CreateScanRequest;
use Detectant\Utils\File;

$client = new DetectantClient(
    apiKey: '<value>',
);
$client->scan(
    new CreateScanRequest([
        'file' => File::createFromString("example_file", "example_file"),
    ]),
);

```

## Environments

This SDK allows you to configure different environments for API requests.

```php
The SDK defaults to the `Default_` environment. To use a different environment, pass it to the client constructor:

```php
use Detectant\DetectantClient;
use Detectant\Environments;

$client = new DetectantClient(
    token: '<YOUR_TOKEN>',
    options: [
        'baseUrl' => Environments::Staging->value
    ]
);
```

Available environments:
- `Environments::Default_`
```

## Exception Handling

When the API returns a non-success status code (4xx or 5xx response), an exception will be thrown.

```php
use Detectant\Exceptions\DetectantApiException;
use Detectant\Exceptions\DetectantException;

try {
    $response = $client->scan(...);
} catch (DetectantApiException $e) {
    echo 'API Exception occurred: ' . $e->getMessage() . "\n";
    echo 'Status Code: ' . $e->getCode() . "\n";
    echo 'Response Body: ' . $e->getBody() . "\n";
    // Optionally, rethrow the exception or handle accordingly.
}
```

## Advanced

### Custom Client

This SDK is built to work with any HTTP client that implements the [PSR-18](https://www.php-fig.org/psr/psr-18/) `ClientInterface`.
By default, if no client is provided, the SDK will use `php-http/discovery` to find an installed HTTP client.
However, you can pass your own client that adheres to `ClientInterface`:

```php
use Detectant\DetectantClient;

// Pass any PSR-18 compatible HTTP client implementation.
// For example, using Guzzle:
$customClient = new \GuzzleHttp\Client([
    'timeout' => 5.0,
]);

$client = new DetectantClient(options: [
    'client' => $customClient
]);

// Or using Symfony HttpClient:
// $customClient = (new \Symfony\Component\HttpClient\Psr18Client())
//     ->withOptions(['timeout' => 5.0]);
//
// $client = new DetectantClient(options: [
//     'client' => $customClient
// ]);
```

### Retries

The SDK is instrumented with automatic retries with exponential backoff. A request will be retried as long
as the request is deemed retryable and the number of retry attempts has not grown larger than the configured
retry limit (default: 2).

A request is deemed retryable when any of the following HTTP status codes is returned:

- [408](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/408) (Timeout)
- [429](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/429) (Too Many Requests)
- [5XX](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#server_error_responses) (Internal Server Error)

The `retryStatusCodes` configuration controls which [5XX](https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#server_error_responses) status codes are retried:

- `legacy` (default): Retries `408`, `429`, and all `>= 500`
- `recommended`: Retries `408`, `429`, `502`, `503`, `504` only (excludes `500 Internal Server Error` to avoid retrying non-idempotent failures)

Use the `maxRetries` request option to configure this behavior.

```php
$response = $client->scan(
    ...,
    options: [
        'maxRetries' => 0 // Override maxRetries at the request level
    ]
);
```

### Timeouts

The SDK defaults to a 30 second timeout. Use the `timeout` option to configure this behavior.

```php
$response = $client->scan(
    ...,
    options: [
        'timeout' => 3.0 // Override timeout at the request level
    ]
);
```

## Contributing

While we value open-source contributions to this SDK, this library is generated programmatically.
Additions made directly to this library would have to be moved over to our generation code,
otherwise they would be overwritten upon the next generated release. Feel free to open a PR as
a proof of concept, but know that we will not be able to merge it as-is. We suggest opening
an issue first to discuss with us!

On the other hand, contributions to the README are always very welcome!

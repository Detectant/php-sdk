<p align="center">
  <img src="../../app/dashboard/public/images/detectant-github-banner.png" alt="Detectant" width="100%">
</p>

# Detectant PHP SDK

[![fern shield](https://img.shields.io/badge/%F0%9F%8C%BF-Built%20with%20Fern-brightgreen)](https://buildwithfern.com?utm_source=github&utm_medium=github&utm_campaign=readme&utm_source=https%3A%2F%2Fgithub.com%2FDetectant%2Fphp-sdk)
[![php shield](https://img.shields.io/badge/php-packagist-pink)](https://packagist.org/packages/detectant/sdk)

## Install

This SDK requires PHP 8.1 or later and a PSR-18 HTTP client implementation.

```bash
composer require detectant/detectant guzzlehttp/guzzle
```
- [Advanced](#advanced)
  - [Custom Client](#custom-client)
  - [Retries](#retries)
  - [Timeouts](#timeouts)
- [Contributing](#contributing)

Set your API key in the environment:

This SDK requires PHP 8.1 or later and a PSR-18 HTTP client implementation.

```bash
composer require detectant/detectant guzzlehttp/guzzle
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
        'baseUrl' => 'https://api.example.com',
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

```bash
export DETECTANT_API_KEY="your-api-key"
```

## Create a client

```php
<?php

use Detectant\DetectantClient;

```sh
composer require detectant/sdk
```

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
        'baseUrl' => 'https://api.example.com',
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

## Exception handling

```php
use Detectant\Exceptions\DetectantApiException;
use Detectant\Exceptions\DetectantException;

try {
    $result = $detectant->scan($request);
} catch (DetectantApiException $exception) {
    echo $exception->getCode() . ': ' . $exception->getMessage() . PHP_EOL;
} catch (DetectantException $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
```

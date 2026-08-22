<p align="center">
  <img src="../../app/dashboard/public/images/detectant-github-banner.png" alt="Detectant" width="100%">
</p>

# Detectant PHP SDK

Scan files for malware from PHP.

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

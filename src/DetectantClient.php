<?php

namespace Detectant;

use Detectant\Health\HealthClient;
use Detectant\Scans\ScansClient;
use Psr\Http\Client\ClientInterface;
use Detectant\Core\Client\RawClient;
use Detectant\Requests\CreateScanRequest;
use Detectant\Types\Scan;
use Detectant\Exceptions\DetectantException;
use Detectant\Exceptions\DetectantApiException;
use Detectant\Core\Multipart\MultipartFormData;
use Detectant\Core\Multipart\MultipartApiRequest;
use Detectant\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Detectant\Requests\CreateScanBatchRequest;
use Detectant\Types\ScanBatchResponse;

class DetectantClient
{
    /**
     * @var HealthClient $health
     */
    public HealthClient $health;

    /**
     * @var ScansClient $scans
     */
    public ScansClient $scans;

    /**
     * @var array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options @phpstan-ignore-next-line Property is used in endpoint methods via HttpEndpointGenerator
     */
    private array $options;

    /**
     * @var RawClient $client
     */
    private RawClient $client;

    /**
     * @param ?string $apiKey The apiKey to use for authentication.
     * @param ?array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options
     */
    public function __construct(
        ?string $apiKey = null,
        ?array $options = null,
    ) {
        $defaultHeaders = [
            'X-Fern-Language' => 'PHP',
            'X-Fern-SDK-Name' => 'Detectant',
            'X-Fern-SDK-Version' => '0.0.1',
            'User-Agent' => 'detectant/detectant/0.0.1',
        ];
        if ($apiKey != null) {
            $defaultHeaders['X-API-Key'] = $apiKey;
        }

        $this->options = $options ?? [];

        $this->options['headers'] = array_merge(
            $defaultHeaders,
            $this->options['headers'] ?? [],
        );

        $this->client = new RawClient(
            options: $this->options,
        );

        $this->health = new HealthClient($this->client, $this->options);
        $this->scans = new ScansClient($this->client, $this->options);
    }

    /**
     * Uploads one file and synchronously runs content-type and malware analysis.
     * Only the first multipart part named `file` with a filename is
     * scanned; other parts are ignored. Free accounts accept files up to
     * 50 MiB; Grow and Scale accounts accept files up to 250 MiB.
     *
     * Example:
     * ```php
     * $client->scan(
     *     new CreateScanRequest([
     *         'file' => File::createFromString("example_file", "example_file"),
     *     ]),
     * );
     * ```
     *
     * @param CreateScanRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     * } $options
     * @return ?Scan
     * @throws DetectantException
     * @throws DetectantApiException
     */
    public function scan(CreateScanRequest $request, ?array $options = null): ?Scan
    {
        $options = array_merge($this->options, $options ?? []);
        $body = new MultipartFormData();
        $body->addPart($request->file->toMultipartFormDataPart('file'));
        try {
            $response = $this->client->sendRequest(
                new MultipartApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Default_->value,
                    path: "v1/scans",
                    method: HttpMethod::POST,
                    body: $body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return Scan::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new DetectantException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new DetectantException(message: $e->getMessage(), previous: $e);
        }
        throw new DetectantApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }

    /**
     * Uploads between 1 and 20 files in repeated `files` multipart parts. Each
     * file uses its account plan's 50 MiB or 250 MiB per-file limit, validation, content-type
     * analysis, malware detection, persistence, usage accounting, and billing path
     * as `createScan`. The encoded multipart request limit is the plan's
     * per-file limit × 20 plus 1 MiB for multipart framing.
     *
     * Results preserve submitted-file order. File-level validation or scanner
     * failures are returned in the corresponding result and do not prevent
     * other files from being scanned. The whole request is rejected only for
     * request-level failures such as invalid multipart data, authentication or
     * rate-limit failure, more than 20 files, or an oversized total request.
     *
     * Example:
     * ```php
     * $client->scanBatch(
     *     new CreateScanBatchRequest([
     *         'files' => [
     *             File::createFromString("example_files", "example_files"),
     *         ],
     *     ]),
     * );
     * ```
     *
     * @param CreateScanBatchRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     * } $options
     * @return ?ScanBatchResponse
     * @throws DetectantException
     * @throws DetectantApiException
     */
    public function scanBatch(CreateScanBatchRequest $request, ?array $options = null): ?ScanBatchResponse
    {
        $options = array_merge($this->options, $options ?? []);
        $body = new MultipartFormData();
        foreach ($request->files as $file) {
            $body->addPart($file->toMultipartFormDataPart('files'));
        }
        try {
            $response = $this->client->sendRequest(
                new MultipartApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Default_->value,
                    path: "v1/scans/batch",
                    method: HttpMethod::POST,
                    body: $body,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return ScanBatchResponse::fromJson($json);
            }
        } catch (JsonException $e) {
            throw new DetectantException(message: "Failed to deserialize response: {$e->getMessage()}", previous: $e);
        } catch (ClientExceptionInterface $e) {
            throw new DetectantException(message: $e->getMessage(), previous: $e);
        }
        throw new DetectantApiException(
            message: 'API request failed',
            statusCode: $statusCode,
            body: $response->getBody()->getContents(),
        );
    }
}

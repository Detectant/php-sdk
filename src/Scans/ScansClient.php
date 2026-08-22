<?php

namespace Detectant\Scans;

use Psr\Http\Client\ClientInterface;
use Detectant\Core\Client\RawClient;
use Detectant\Scans\Requests\ListScansRequest;
use Detectant\Types\ScanList;
use Detectant\Exceptions\DetectantException;
use Detectant\Exceptions\DetectantApiException;
use Detectant\Core\Json\JsonApiRequest;
use Detectant\Environments;
use Detectant\Core\Client\HttpMethod;
use JsonException;
use Psr\Http\Client\ClientExceptionInterface;
use Detectant\Types\Scan;

class ScansClient
{
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
     * @param RawClient $client
     * @param ?array{
     *   baseUrl?: string,
     *   client?: ClientInterface,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     * } $options
     */
    public function __construct(
        RawClient $client,
        ?array $options = null,
    ) {
        $this->client = $client;
        $this->options = $options ?? [];
    }

    /**
     * Returns scans owned by the authenticated account in descending creation order.
     *
     * Example:
     * ```php
     * $client->scans->listScans(
     *     new ListScansRequest([]),
     * );
     * ```
     *
     * @param ListScansRequest $request
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?ScanList
     * @throws DetectantException
     * @throws DetectantApiException
     */
    public function listScans(ListScansRequest $request = new ListScansRequest(), ?array $options = null): ?ScanList
    {
        $options = array_merge($this->options, $options ?? []);
        $query = [];
        if ($request->limit != null) {
            $query['limit'] = $request->limit;
        }
        if ($request->cursor != null) {
            $query['cursor'] = $request->cursor;
        }
        if ($request->verdict != null) {
            $query['verdict'] = $request->verdict;
        }
        if ($request->filename != null) {
            $query['filename'] = $request->filename;
        }
        if ($request->engineSignature != null) {
            $query['engine_signature'] = $request->engineSignature;
        }
        if ($request->detectionRule != null) {
            $query['detection_rule'] = $request->detectionRule;
        }
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Default_->value,
                    path: "v1/scans",
                    method: HttpMethod::GET,
                    query: $query,
                ),
                $options,
            );
            $statusCode = $response->getStatusCode();
            if ($statusCode >= 200 && $statusCode < 400) {
                $json = $response->getBody()->getContents();
                if (empty($json)) {
                    return null;
                }
                return ScanList::fromJson($json);
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
     * Returns one scan owned by the authenticated account.
     *
     * Example:
     * ```php
     * $client->scans->getScan(
     *     'scan_0123456789abcdef0123456789abcdef',
     * );
     * ```
     *
     * @param string $scanId Scan identifier returned by `createScan` or `listScans`.
     * @param ?array{
     *   baseUrl?: string,
     *   maxRetries?: int,
     *   timeout?: float,
     *   headers?: array<string, string>,
     *   queryParameters?: array<string, mixed>,
     *   bodyProperties?: array<string, mixed>,
     * } $options
     * @return ?Scan
     * @throws DetectantException
     * @throws DetectantApiException
     */
    public function getScan(string $scanId, ?array $options = null): ?Scan
    {
        $options = array_merge($this->options, $options ?? []);
        try {
            $response = $this->client->sendRequest(
                new JsonApiRequest(
                    baseUrl: $options['baseUrl'] ?? $this->client->options['baseUrl'] ?? Environments::Default_->value,
                    path: "v1/scans/" . RawClient::encodePathParam($scanId),
                    method: HttpMethod::GET,
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
}

# Reference
<details><summary><code>$client-&gt;scan($request) -> ?Scan</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Uploads one file and synchronously runs content-type and malware analysis.
Only the first multipart part named `file` with a filename is
scanned; other parts are ignored. Free accounts accept files up to
50 MiB; Grow and Scale accounts accept files up to 250 MiB.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->scan(
    new CreateScanRequest([
        'file' => File::createFromString("example_file", "example_file"),
    ]),
);
```
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;scanBatch($request) -> ?ScanBatchResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Uploads between 1 and 20 files in repeated `files` multipart parts. Each
file uses its account plan's 50 MiB or 250 MiB per-file limit, validation, content-type
analysis, malware detection, persistence, usage accounting, and billing path
as `createScan`. The encoded multipart request limit is the plan's
per-file limit × 20 plus 1 MiB for multipart framing.

Results preserve submitted-file order. File-level validation or scanner
failures are returned in the corresponding result and do not prevent
other files from being scanned. The whole request is rejected only for
request-level failures such as invalid multipart data, authentication or
rate-limit failure, more than 20 files, or an oversized total request.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->scanBatch(
    new CreateScanBatchRequest([
        'files' => [
            File::createFromString("example_files", "example_files"),
        ],
    ]),
);
```
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Health
<details><summary><code>$client-&gt;health-&gt;getLiveness() -> ?HealthResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns successfully while the API process can serve requests.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->health->getLiveness();
```
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;health-&gt;getReadiness() -> ?HealthResponse</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Checks the database, schema, scanner signatures, and scanning dependencies.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->health->getReadiness();
```
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

## Scans
<details><summary><code>$client-&gt;scans-&gt;listScans($request) -> ?ScanList</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns scans owned by the authenticated account in descending creation order.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->scans->listScans(
    new ListScansRequest([]),
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$limit:** `?int` — Maximum results to return. Values above 200 are capped at 200; omission uses 50.
    
</dd>
</dl>

<dl>
<dd>

**$cursor:** `?string` — Opaque cursor returned as `next_cursor` by a previous request.
    
</dd>
</dl>

<dl>
<dd>

**$verdict:** `?string` — Case-sensitive PostgreSQL `LIKE` fragment matched against the stored verdict; `%` and `_` act as wildcards.
    
</dd>
</dl>

<dl>
<dd>

**$scanId:** `?string` — Case-insensitive fragment matched against the scan identifier.
    
</dd>
</dl>

<dl>
<dd>

**$sourceType:** `?string` — Return direct API scans or scans submitted by an S3 integration.
    
</dd>
</dl>

<dl>
<dd>

**$storageIntegrationId:** `?string` — Return scans submitted by this S3 integration.
    
</dd>
</dl>

<dl>
<dd>

**$failure:** `?string` — Return scans by failure presence or customer-facing failure code.
    
</dd>
</dl>

<dl>
<dd>

**$filename:** `?string` — Case-sensitive PostgreSQL `LIKE` fragment matched against the stored filename; `%` and `_` act as wildcards.
    
</dd>
</dl>

<dl>
<dd>

**$engineSignature:** `?string` — Case-sensitive PostgreSQL `LIKE` fragment matched against the stored engine signature; `%` and `_` act as wildcards.
    
</dd>
</dl>

<dl>
<dd>

**$detectionRule:** `?string` — Case-sensitive PostgreSQL `LIKE` fragment matched against stored detection rules; `%` and `_` act as wildcards.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>

<details><summary><code>$client-&gt;scans-&gt;getScan($scanId) -> ?Scan</code></summary>
<dl>
<dd>

#### 📝 Description

<dl>
<dd>

<dl>
<dd>

Returns one scan owned by the authenticated account.
</dd>
</dl>
</dd>
</dl>

#### 🔌 Usage

<dl>
<dd>

<dl>
<dd>

```php
$client->scans->getScan(
    'scan_0123456789abcdef0123456789abcdef',
);
```
</dd>
</dl>
</dd>
</dl>

#### ⚙️ Parameters

<dl>
<dd>

<dl>
<dd>

**$scanId:** `string` — Scan identifier returned by `createScan` or `listScans`.
    
</dd>
</dl>
</dd>
</dl>


</dd>
</dl>
</details>


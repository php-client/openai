<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Batch;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

use function array_filter;

/**
 * Creates and executes a batch from an uploaded file of requests
 *
 * @see https://platform.openai.com/docs/api-reference/batch/create
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CreateBatchRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $inputFileId  The ID of an uploaded file that contains requests for the new batch.
     * Your input file must be formatted as a JSONL file, and must be uploaded with the purpose batch. The file can
     * contain up to 50,000 requests, and can be up to 200 MB in size.
     *
     * @param  string  $endpoint  The endpoint to be used for all requests in the batch.
     * Currently, `/v1/chat/completions`, `/v1/embeddings`, and `/v1/completions` are supported.
     * Note that `/v1/embeddings` batches are also restricted to a maximum of 50,000 embedding inputs across all
     * requests in the batch.
     *
     * @param  string  $completionWindow  The time frame within which the batch should be processed.
     * Currently only `24h` is supported.
     *
     * @param  array|null  $metadata  Set of 16 key-value pairs that can be attached to an object.
     * This can be useful for storing additional information about the object in a structured format, and querying
     * for objects via API or the dashboard. Keys are strings with a maximum length of 64 characters.
     * Values are strings with a maximum length of 512 characters.
     */
    public function __construct(
        public readonly string $inputFileId,
        public readonly string $endpoint,
        public readonly string $completionWindow,
        public readonly null|array $metadata = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/batches';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'input_file_id' => $this->inputFileId,
                'endpoint' => $this->endpoint,
                'completion_window' => $this->completionWindow,
                'metadata' => $this->metadata,
            ],
            callback: static fn($value): bool => $value !== null,
        );
    }
}

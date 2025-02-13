<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Batch;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Retrieves a batch.
 *
 * @see https://platform.openai.com/docs/api-reference/batch/retrieve
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class RetrieveBatchRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $batchId  The ID of the batch to retrieve.
     */
    public function __construct(
        protected string $batchId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/batches/{batch_id}';
    }

    protected function defaultQuery(): array
    {
        return [
            'batch_id' => $this->batchId,
        ];
    }
}

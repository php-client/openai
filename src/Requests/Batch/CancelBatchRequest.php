<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Batch;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Cancels an in-progress batch.
 *
 * The batch will be in status cancelling for up to 10 minutes, before changing to cancelled, where it will have
 * partial results (if any) available in the output file.
 *
 * @see https://platform.openai.com/docs/api-reference/batch/cancel
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CancelBatchRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $batchId  The ID of the batch to cancel.
     */
    public function __construct(
        public readonly string $batchId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/batches/{batch_id}/cancel';
    }

    protected function defaultBody(): array
    {
        return [
            'batch_id' => $this->batchId,
        ];
    }
}

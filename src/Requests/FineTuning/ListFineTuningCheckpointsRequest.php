<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\FineTuning;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List checkpoints for a fine-tuning job.
 *
 * @see https://platform.openai.com/docs/api-reference/fine-tuning/list-checkpoints
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class ListFineTuningCheckpointsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $fineTuningJobId  The ID of the fine-tuning job to get checkpoints for.
     *
     * @param  string|null  $after  Identifier for the last checkpoint ID from the previous pagination request.
     *
     * @param  int|null  $limit  Number of checkpoints to retrieve.
     */
    public function __construct(
        public readonly string $fineTuningJobId,
        public readonly null|string $after = null,
        public readonly null|int $limit = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v1/fine_tuning/jobs/$this->fineTuningJobId/checkpoints";
    }

    protected function defaultQuery(): array
    {
        return array_filter(
            array: [
                'after' => $this->after,
                'limit' => $this->limit,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}

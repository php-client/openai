<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\FineTuning;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get status updates for a fine-tuning job.
 *
 * @see https://platform.openai.com/docs/api-reference/fine-tuning/list-events
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class ListFineTuningEventsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $fineTuningJobId  The ID of the fine-tuning job to get events for.
     *
     * @param  string|null  $after  Identifier for the last event from the previous pagination request.
     *
     * @param  int|null  $limit  Number of events to retrieve.
     */
    public function __construct(
        public readonly string $fineTuningJobId,
        public readonly null|string $after = null,
        public readonly null|int $limit = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v1/fine_tuning/jobs/$this->fineTuningJobId/events";
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

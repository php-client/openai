<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\FineTuning;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * List your organization's fine-tuning jobs.
 *
 * @see https://platform.openai.com/docs/api-reference/fine-tuning/list
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class ListFineTuningJobsRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string|null  $after  Identifier for the last job from the previous pagination request.
     *
     * @param  int|null  $limit  Number of fine-tuning jobs to retrieve.
     */
    public function __construct(
        public readonly null|string $after = null,
        public readonly null|int $limit = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/fine_tuning/jobs';
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

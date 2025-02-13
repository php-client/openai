<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Batch;

use Saloon\Enums\Method;
use Saloon\Http\Request;

use function array_filter;

/**
 * List your organization's batches.
 *
 * @see https://platform.openai.com/docs/api-reference/batch/list
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class ListBatchRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string|null  $after  A cursor for use in pagination.
     * `after` is an object ID that defines your place in the list. For instance, if you make a list request
     * and receive 100 objects, ending with obj_foo, your subsequent call can include after=obj_foo in order
     * to fetch the next page of the list.
     *
     * @param  int|null  $limit  A limit on the number of objects to be returned. Limit can range between 1 and 100,
     * and the default is 20.
     */
    public function __construct(
        public readonly null|string $after = null,
        public readonly null|int $limit = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/batches';
    }

    protected function defaultQuery(): array
    {
        return array_filter(
            array: [
                'after' => $this->after,
                'limit' => $this->limit,
            ],
            callback: static fn($value): bool => $value !== null,
        );
    }
}

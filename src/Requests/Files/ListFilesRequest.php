<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Files;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Returns a list of files.
 *
 * @see https://platform.openai.com/docs/api-reference/files/list
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class ListFilesRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string|null  $purpose  Only return files with the given purpose.
     *
     * @param  int|null  $limit  A limit on the number of objects to be returned. Limit can range between 1 and 10,000,
     * and the default is 10,000.
     *
     * @param  string|null  $order  Sort order by the created_at timestamp of the objects. asc for ascending order
     * and desc for descending order.
     *
     * @param  string|null  $after  A cursor for use in pagination. after is an object ID that defines your place in
     * the list. For instance, if you make a list request and receive 100 objects, ending with obj_foo, your subsequent
     * call can include after=obj_foo in order to fetch the next page of the list.
     */
    public function __construct(
        public readonly null|string $purpose = null,
        public readonly null|int $limit = null,
        public readonly null|string $order = null,
        public readonly null|string $after = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/files';
    }

    protected function defaultQuery(): array
    {
        return array_filter(
            array: [
                'purpose' => $this->purpose,
                'limit' => $this->limit,
                'order' => $this->order,
                'after' => $this->after,
            ],
            callback: static fn($value): bool => $value !== null,
        );
    }
}

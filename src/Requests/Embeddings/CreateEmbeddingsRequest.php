<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Embeddings;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

use function array_filter;

/**
 * Creates an embedding vector representing the input text.
 *
 * @see https://platform.openai.com/docs/api-reference/embeddings/create
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CreateEmbeddingsRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string|array  $input  Input text to embed, encoded as a string or array of tokens.
     * To embed multiple inputs in a single request, pass an array of strings or array of token arrays. The input must
     * not exceed the max input tokens for the model (8192 tokens for text-embedding-ada-002), cannot be an empty
     * string, and any array must be 2048 dimensions or less. Example Python code for counting tokens. Some models
     * may also impose a limit on total number of tokens summed across inputs.
     *
     * @param  string  $model  ID of the model to use.
     *
     * @param  string|null  $encodingFormat  The format to return the embeddings in. Can be either `float` or `base64`.
     *
     * @param  int|null  $dimension  The number of dimensions the resulting output embeddings should have.
     * Only supported in text-embedding-3 and later models.
     *
     * @param  string|null  $user  A unique identifier representing your end-user, which can help OpenAI to monitor
     * and detect abuse.
     */
    public function __construct(
        public readonly string|array $input,
        public readonly string $model,
        public readonly null|string $encodingFormat = null,
        public readonly null|int $dimension = null,
        public readonly null|string $user = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/embeddings';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'input' => $this->input,
                'model' => $this->model,
                'encoding_format' => $this->encodingFormat,
                'dimension' => $this->dimension,
                'user' => $this->user,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}

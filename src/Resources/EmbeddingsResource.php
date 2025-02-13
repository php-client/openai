<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Resources;

use PhpClient\OpenAI\Requests\Embeddings\CreateEmbeddingsRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

final class EmbeddingsResource extends BaseResource
{
    /**
     * Creates an embedding vector representing the input text.
     *
     * @see https://platform.openai.com/docs/api-reference/embeddings/create
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
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
     *
     * @throws FatalRequestException|RequestException
     */
    public function createEmbeddings(
        string|array $input,
        string $model,
        null|string $encodingFormat = null,
        null|int $dimension = null,
        null|string $user = null,
    ): Response {
        return $this->connector->send(
            request: new CreateEmbeddingsRequest(
                input: $input,
                model: $model,
                encodingFormat: $encodingFormat,
                dimension: $dimension,
                user: $user,
            ),
        );
    }
}

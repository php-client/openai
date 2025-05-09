<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Files;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete a file.
 *
 * @see https://platform.openai.com/docs/api-reference/files/delete
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class DeleteFileRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $fileId  The ID of the file to use for this request.
     */
    public function __construct(
        public readonly string $fileId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v1/files/$this->fileId";
    }
}

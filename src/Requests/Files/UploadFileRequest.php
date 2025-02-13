<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Files;

use PhpClient\OpenAI\Helpers\MultipartValueHelper;
use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;

use function array_filter;

/**
 * Upload a file that can be used across various endpoints.
 * Individual files can be up to 512 MB, and the size of all files uploaded by one organization can be up to 100 GB.
 *
 * The Assistants API supports files up to 2 million tokens and of specific file types. See the Assistants Tools guide
 * for details.
 *
 * The Fine-tuning API only supports .jsonl files. The input also has certain required formats for fine-tuning chat
 * or completions models.
 *
 * The Batch API only supports .jsonl files up to 200 MB in size. The input also has a specific required format.
 *
 * @see https://platform.openai.com/docs/api-reference/files/create
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class UploadFileRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    /**
     * @param  MultipartValue|string  $file  The File (object or path) to be uploaded.
     *
     * @param  string  $purpose  The intended purpose of the uploaded file.
     * Use "assistants" for Assistants and Message files, "vision" for Assistants image file inputs,
     * "batch" for Batch API, and "fine-tune" for Fine-tuning.
     */
    public function __construct(
        public readonly MultipartValue|string $file,
        public readonly string $purpose,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/files';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'file' => MultipartValueHelper::ensureFile(file: $this->file),
                'purpose' => $this->purpose,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}

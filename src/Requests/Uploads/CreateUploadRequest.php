<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Uploads;

use RuntimeException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates an intermediate Upload object that you can add Parts to.
 *
 * Currently, an Upload can accept at most 8 GB in total and expires after an hour after you create it.
 * Once you complete the Upload, we will create a File object that contains all the parts you uploaded.
 * This File is usable in the rest of our platform as a regular File object.
 *
 * @see https://platform.openai.com/docs/api-reference/uploads/create
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CreateUploadRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $filename  The name of the file to upload.
     *
     * @param  string  $purpose  The intended purpose of the uploaded file.
     *
     * @param  int  $bytes  The number of bytes in the file you are uploading.
     *
     * @param  string  $mimeType  This must fall within the supported MIME types for your file purpose.
     * See the supported MIME types for assistants and vision.
     */
    public function __construct(
        public readonly string $filename,
        public readonly string $purpose,
        public readonly int $bytes,
        public readonly string $mimeType,
    ) {}

    public function resolveEndpoint(): string
    {
        throw new RuntimeException(message: 'Not implemented');
    }

    protected function defaultBody(): array
    {
        return [
            'filename' => $this->filename,
            'purpose' => $this->purpose,
            'bytes' => $this->bytes,
            'mime_type' => $this->mimeType,
        ];
    }
}

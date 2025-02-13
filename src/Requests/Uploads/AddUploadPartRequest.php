<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Uploads;

use PhpClient\OpenAI\Helpers\MultipartValueHelper;
use Psr\Http\Message\StreamInterface;
use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;

/**
 * Adds a Part to an Upload object. A Part represents a chunk of bytes from the file you are trying to upload.
 *
 * Each Part can be at most 64 MB, and you can add Parts until you hit the Upload maximum of 8 GB.
 * It is possible to add multiple Parts in parallel. You can decide the intended order of the Parts when you complete
 * the Upload.
 *
 * @see https://platform.openai.com/docs/api-reference/uploads/add-part
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class AddUploadPartRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $uploadId  The ID of the Upload.
     *
     * @param  MultipartValue|StreamInterface|resource|string|int  $data  The chunk of bytes for this Part.
     * Data can be a MultipartValue, Stream, resource, string or integer.
     */
    public function __construct(
        public readonly string $uploadId,
        public readonly mixed $data,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v1/uploads/$this->uploadId/parts";
    }

    protected function defaultBody(): array
    {
        return [
            'data' => MultipartValueHelper::ensureData(data: $this->data),
        ];
    }
}

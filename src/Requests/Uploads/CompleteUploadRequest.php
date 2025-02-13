<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Uploads;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Completes the Upload.
 *
 * Within the returned Upload object, there is a nested File object that is ready to use in the rest of the platform.
 * You can specify the order of the Parts by passing in an ordered list of the Part IDs.
 *
 * The number of bytes uploaded upon completion must match the number of bytes initially specified when creating
 * the Upload object. No Parts may be added after an Upload is completed.
 *
 * @see https://platform.openai.com/docs/api-reference/uploads/complete
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CompleteUploadRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $uploadId  The ID of the Upload.
     *
     * @param  array  $partIds  The ordered list of Part IDs.
     *
     * @param  string|null  $md5  The optional md5 checksum for the file contents to verify if the bytes uploaded
     * matches what you expect.
     */
    public function __construct(
        public readonly string $uploadId,
        public readonly array $partIds,
        public readonly null|string $md5 = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v1/uploads/$this->uploadId/complete";
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'part_ids' => $this->partIds,
                'md5' => $this->md5,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}

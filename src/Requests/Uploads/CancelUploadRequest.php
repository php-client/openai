<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Uploads;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Cancels the Upload. No Parts may be added after an Upload is cancelled.
 *
 * @see https://platform.openai.com/docs/api-reference/uploads/cancel
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CancelUploadRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $uploadId  The ID of the Upload.
     */
    public function __construct(
        public readonly string $uploadId,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/uploads/{upload_id}/cancel';
    }
}

<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Images;

use PhpClient\OpenAI\Helpers\MultipartValueHelper;
use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;

/**
 * Creates a variation of a given image.
 *
 * @see https://platform.openai.com/docs/api-reference/images/createVariation
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CreateImageVariationRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    /**
     * @param  MultipartValue|string  $image  The image (object or path to file) to use as the basis for the variation.
     * Must be a valid PNG file, less than 4MB, and square.
     *
     * @param  string|null  $model  The model to use for image generation. Only `dall-e-2` is supported at this time.
     *
     * @param  int|null  $n  The number of images to generate. Must be between 1 and 10. For dall-e-3, only n=1
     * is supported.
     *
     * @param  string|null  $responseFormat  The format in which the generated images are returned. Must be one
     * of `url` or `b64_json`. URLs are only valid for 60 minutes after the image has been generated.
     *
     * @param  string|null  $size  The size of the generated images. Must be one of `256x256`, `512x512`, or `1024x1024`.
     *
     * @param  string|null  $user  A unique identifier representing your end-user, which can help OpenAI to monitor
     * and detect abuse.
     */
    public function __construct(
        public readonly MultipartValue|string $image,
        public readonly null|string $model = null,
        public readonly null|int $n = null,
        public readonly null|string $responseFormat = null,
        public readonly null|string $size = null,
        public readonly null|string $user = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/images/variations';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'image' => MultipartValueHelper::ensureFile(file: $this->image),
                'model' => $this->model,
                'n' => $this->n,
                'response_format' => $this->responseFormat,
                'size' => $this->size,
                'user' => $this->user,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}

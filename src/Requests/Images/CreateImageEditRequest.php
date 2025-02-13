<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Images;

use PhpClient\OpenAI\Helpers\MultipartValueHelper;
use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;

use function array_filter;

/**
 * Creates an edited or extended image given an original image and a prompt.
 *
 * @see https://platform.openai.com/docs/api-reference/images/createEdit
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CreateImageEditRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    /**
     * @param  MultipartValue|string  $image  The image to edit (object or path to file). Must be a valid PNG file,
     * less than 4MB, and square. If mask is not provided, image must have transparency, which will be used as the mask.
     *
     * @param  string  $prompt  A text description of the desired image(s). The maximum length is 1000 characters.
     *
     * @param  MultipartValue|string|null  $mask  An additional image (object or path to file) whose fully transparent
     * areas (e.g. where alpha is zero) indicate where image should be edited. Must be a valid PNG file, less than 4MB,
     * and have the same dimensions as image.
     *
     * @param  string|null  $model  The model to use for image generation. Only `dall-e-2` is supported at this time.
     *
     * @param  int|null  $n  The number of images to generate. Must be between 1 and 10.
     *
     * @param  string|null  $size  The size of the generated images. Must be one of `256x256`, `512x512`, or `1024x1024`.
     *
     * @param  string|null  $responseFormat  The format in which the generated images are returned.
     * Must be one of `url` or `b64_json`. URLs are only valid for 60 minutes after the image has been generated.
     *
     * @param  string|null  $user  A unique identifier representing your end-user, which can help OpenAI to monitor
     * and detect abuse.
     */
    public function __construct(
        public readonly MultipartValue|string $image,
        public readonly string $prompt,
        public readonly null|MultipartValue|string $mask = null,
        public readonly null|string $model = null,
        public readonly null|int $n = null,
        public readonly null|string $size = null,
        public readonly null|string $responseFormat = null,
        public readonly null|string $user = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/images/edits';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'image' => MultipartValueHelper::ensureFile(file: $this->image),
                'prompt' => $this->prompt,
                'mask' => $this->mask
                    ? MultipartValueHelper::ensureFile(file: $this->mask)
                    : null,
                'model' => $this->model,
                'n' => $this->n,
                'size' => $this->size,
                'response_format' => $this->responseFormat,
                'user' => $this->user,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}

<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Images;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates an image given a prompt.
 *
 * @see https://platform.openai.com/docs/api-reference/images/create
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CreateImageRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $prompt  A text description of the desired image(s).
     * The maximum length is 1000 characters for `dall-e-2` and 4000 characters for `dall-e-3`.
     *
     * @param  string|null  $model  The model to use for image generation.
     *
     * @param  int|null  $n  The number of images to generate. Must be between 1 and 10.
     * For `dall-e-3`, only `n=1` is supported.
     *
     * @param  string|null  $quality  The quality of the image that will be generated.
     * `hd` creates images with finer details and greater consistency across the image. This param is only supported
     * for `dall-e-3`.
     *
     * @param  string|null  $responseFormat  The format in which the generated images are returned.
     * Must be one of `url` or `b64_json`. URLs are only valid for 60 minutes after the image has been generated.
     *
     * @param  string|null  $size  The size of the generated images. Must be one of `256x256`, `512x512`,
     * or `1024x1024` for `dall-e-2`. Must be one of `1024x1024`, `1792x1024`, or `1024x1792` for `dall-e-3` models.
     *
     * @param  string|null  $style  The style of the generated images. Must be one of `vivid` or `natural`.
     * Vivid causes the model to lean towards generating hyper-real and dramatic images. Natural causes the model
     * to produce more natural, less hyper-real looking images. This param is only supported for `dall-e-3`.
     *
     * @param  string|null  $user  A unique identifier representing your end-user, which can help OpenAI to monitor
     * and detect abuse.
     */
    public function __construct(
        public readonly string $prompt,
        public readonly null|string $model = null,
        public readonly null|int $n = null,
        public readonly null|string $quality = null,
        public readonly null|string $responseFormat = null,
        public readonly null|string $size = null,
        public readonly null|string $style = null,
        public readonly null|string $user = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/images/generations';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'prompt' => $this->prompt,
                'model' => $this->model,
                'n' => $this->n,
                'quality' => $this->quality,
                'response_format' => $this->responseFormat,
                'size' => $this->size,
                'style' => $this->style,
                'user' => $this->user,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}

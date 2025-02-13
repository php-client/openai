<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Resources;

use PhpClient\OpenAI\Requests\Images\CreateImageEditRequest;
use PhpClient\OpenAI\Requests\Images\CreateImageRequest;
use PhpClient\OpenAI\Requests\Images\CreateImageVariationRequest;
use Saloon\Data\MultipartValue;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * Given a prompt and/or an input image, the model will generate a new image.
 *
 * @see https://platform.openai.com/docs/api-reference/images
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class ImagesResource extends BaseResource
{
    /**
     * Creates an image given a prompt.
     *
     * @see https://platform.openai.com/docs/api-reference/images/create
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
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
     *
     * @throws FatalRequestException|RequestException
     */
    public function createImage(
        string $prompt,
        null|string $model = null,
        null|int $n = null,
        null|string $quality = null,
        null|string $responseFormat = null,
        null|string $size = null,
        null|string $style = null,
        null|string $user = null,
    ): Response {
        return $this->connector->send(
            request: new CreateImageRequest(
                prompt: $prompt,
                model: $model,
                n: $n,
                quality: $quality,
                responseFormat: $responseFormat,
                size: $size,
                style: $style,
                user: $user,
            ),
        );
    }

    /**
     * Creates an edited or extended image given an original image and a prompt.
     *
     * @see https://platform.openai.com/docs/api-reference/images/createEdit
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
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
     *
     * @throws FatalRequestException|RequestException
     */
    public function createImageEdit(
        MultipartValue|string $image,
        string $prompt,
        null|MultipartValue|string $mask = null,
        null|string $model = null,
        null|int $n = null,
        null|string $size = null,
        null|string $responseFormat = null,
        null|string $user = null,
    ): Response {
        return $this->connector->send(
            request: new CreateImageEditRequest(
                image: $image,
                prompt: $prompt,
                mask: $mask,
                model: $model,
                n: $n,
                size: $size,
                responseFormat: $responseFormat,
                user: $user,
            ),
        );
    }

    /**
     * Creates a variation of a given image.
     *
     * @see https://platform.openai.com/docs/api-reference/images/createVariation
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
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
     *
     * @throws FatalRequestException|RequestException
     */
    public function createImageVariation(
        MultipartValue|string $image,
        null|string $model = null,
        null|int $n = null,
        null|string $responseFormat = null,
        null|string $size = null,
        null|string $user = null,
    ): Response {
        return $this->connector->send(
            request: new CreateImageVariationRequest(
                image: $image,
                model: $model,
                n: $n,
                responseFormat: $responseFormat,
                size: $size,
                user: $user,
            ),
        );
    }
}

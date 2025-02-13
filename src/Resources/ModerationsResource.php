<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Resources;

use PhpClient\OpenAI\Requests\Moderations\CreateModerationRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * Given text and/or image inputs, classifies if those inputs are potentially harmful across several categories.
 *
 * @see https://platform.openai.com/docs/api-reference/moderations
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class ModerationsResource extends BaseResource
{
    /**
     * Classifies if text and/or image inputs are potentially harmful. Learn more in the moderation guide.
     *
     * @see https://platform.openai.com/docs/api-reference/moderations/create
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string|array  $input  Input (or inputs) to classify. Can be a single string, an array of strings,
     * or an array of multi-modal input objects similar to other models.
     *
     * @param  string|null  $model  The content moderation model you would like to use.
     *
     * @throws FatalRequestException|RequestException
     */
    public function createModeration(string|array $input, null|string $model = null): Response
    {
        return $this->connector->send(
            request: new CreateModerationRequest(
                input: $input,
                model: $model,
            ),
        );
    }
}

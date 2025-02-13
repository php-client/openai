<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Resources;

use PhpClient\OpenAI\Requests\Models\DeleteFineTunedModelRequest;
use PhpClient\OpenAI\Requests\Models\ListModelsRequest;
use PhpClient\OpenAI\Requests\Models\RetrieveModelRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * List and describe the various models available in the API.
 * You can refer to the Models documentation to understand what models are available and the differences between them.
 *
 * @see https://platform.openai.com/docs/api-reference/models
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class ModelsResource extends BaseResource
{
    /**
     * Lists the currently available models, and provides basic information about each one such as the owner
     * and availability.
     *
     * @see https://platform.openai.com/docs/api-reference/models/list
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @throws FatalRequestException|RequestException
     */
    public function listModels(): Response
    {
        return $this->connector->send(
            request: new ListModelsRequest(),
        );
    }

    /**
     * Retrieves a model instance, providing basic information about the model such as the owner and permissioning.
     *
     * @see https://platform.openai.com/docs/api-reference/models/retrieve
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $model  The ID of the model to use for this request
     *
     * @throws FatalRequestException|RequestException
     */
    public function retrieveModel(string $model): Response
    {
        return $this->connector->send(
            request: new RetrieveModelRequest(
                model: $model,
            ),
        );
    }

    /**
     * Delete a fine-tuned model.
     * You must have the Owner role in your organization to delete a model.
     *
     * @see https://platform.openai.com/docs/api-reference/models/delete
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $model  The model to delete
     *
     * @throws FatalRequestException|RequestException
     */
    public function deleteFineTunedModel(string $model): Response
    {
        return $this->connector->send(
            request: new DeleteFineTunedModelRequest(
                model: $model,
            ),
        );
    }
}

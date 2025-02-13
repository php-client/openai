<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Models;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Delete a fine-tuned model.
 * You must have the Owner role in your organization to delete a model.
 *
 * @see https://platform.openai.com/docs/api-reference/models/delete
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class DeleteFineTunedModelRequest extends Request
{
    protected Method $method = Method::DELETE;

    /**
     * @param  string  $model  The model to delete
     */
    public function __construct(
        public readonly string $model,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v1/models/$this->model";
    }
}

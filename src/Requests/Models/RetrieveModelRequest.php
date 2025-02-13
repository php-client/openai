<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Models;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Retrieves a model instance, providing basic information about the model such as the owner and permissioning.
 *
 * @see https://platform.openai.com/docs/api-reference/models/retrieve
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class RetrieveModelRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $model  The ID of the model to use for this request
     */
    public function __construct(
        public readonly string $model,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v1/models/$this->model";
    }
}

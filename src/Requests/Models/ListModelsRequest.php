<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Models;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Lists the currently available models, and provides basic information about each one such as the owner
 * and availability.
 *
 * @see https://platform.openai.com/docs/api-reference/models/list
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class ListModelsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/v1/models';
    }
}

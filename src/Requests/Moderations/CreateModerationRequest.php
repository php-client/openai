<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Moderations;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Classifies if text and/or image inputs are potentially harmful. Learn more in the moderation guide.
 *
 * @see https://platform.openai.com/docs/api-reference/moderations/create
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CreateModerationRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string|array  $input  Input (or inputs) to classify. Can be a single string, an array of strings,
     * or an array of multi-modal input objects similar to other models.
     *
     * @param  string|null  $model  The content moderation model you would like to use.
     */
    public function __construct(
        public readonly string|array $input,
        public readonly null|string $model = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/moderations';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'input' => $this->input,
                'model' => $this->model,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}

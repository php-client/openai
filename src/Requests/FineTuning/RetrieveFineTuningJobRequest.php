<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\FineTuning;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Get info about a fine-tuning job.
 *
 * @see https://platform.openai.com/docs/api-reference/fine-tuning/retrieve
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class RetrieveFineTuningJobRequest extends Request
{
    protected Method $method = Method::GET;

    /**
     * @param  string  $fineTuningJobId  The ID of the fine-tuning job.
     */
    public function __construct(
        public readonly string $fineTuningJobId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v1/fine_tuning/jobs/$this->fineTuningJobId";
    }
}

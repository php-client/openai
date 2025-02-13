<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\FineTuning;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * Immediately cancel a fine-tune job.
 *
 * @see https://platform.openai.com/docs/api-reference/fine-tuning/cancel
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CancelFineTuningJobRequest extends Request
{
    protected Method $method = Method::POST;

    /**
     * @param  string  $fineTuningJobId  The ID of the fine-tuning job to cancel.
     */
    public function __construct(
        public readonly string $fineTuningJobId,
    ) {}

    public function resolveEndpoint(): string
    {
        return "/v1/fine_tuning/jobs/$this->fineTuningJobId/cancel";
    }
}

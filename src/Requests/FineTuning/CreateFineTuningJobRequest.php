<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\FineTuning;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Creates a fine-tuning job which begins the process of creating a new model from a given dataset.
 *
 * Response includes details of the enqueued job including job status and the name of the fine-tuned models
 * once complete.
 *
 * @see https://platform.openai.com/docs/api-reference/fine-tuning/create
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CreateFineTuningJobRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
     * @param  string  $model  The name of the model to fine-tune. You can select one of the supported models.
     *
     * @param  string  $trainingFile  The ID of an uploaded file that contains training data.
     * Your dataset must be formatted as a JSONL file. Additionally, you must upload your file with the purpose
     * fine-tune.
     * The contents of the file should differ depending on if the model uses the chat, completions format, or if
     * the fine-tuning method uses the preference format. See the fine-tuning guide for more details.
     *
     * @param  string|null  $suffix  A string of up to 64 characters that will be added to your fine-tuned model name.
     * For example, a `suffix` of "custom-model-name" would produce a model name like
     * `ft:gpt-4o-mini:openai:custom-model-name:7p4lURel`.
     *
     * @param  string|null  $validationFile  The ID of an uploaded file that contains validation data.
     * If you provide this file, the data is used to generate validation metrics periodically during fine-tuning.
     * These metrics can be viewed in the fine-tuning results file. The same data should not be present in both train
     * and validation files.
     * Your dataset must be formatted as a JSONL file. You must upload your file with the purpose fine-tune.
     * See the fine-tuning guide for more details.
     *
     * @param  array|null  $integrations  A list of integrations to enable for your fine-tuning job.
     *
     * @param  int|null  $seed  The seed controls the reproducibility of the job. Passing in the same seed and job
     * parameters should produce the same results, but may differ in rare cases. If a seed is not specified, one
     * will be generated for you.
     *
     * @param  array|null  $methodProperties  The method used for fine-tuning.
     */
    public function __construct(
        public readonly string $model,
        public readonly string $trainingFile,
        public readonly null|string $suffix = null,
        public readonly null|string $validationFile = null,
        public readonly null|array $integrations = null,
        public readonly null|int $seed = null,
        public readonly null|array $methodProperties = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/fine_tuning/jobs';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'model' => $this->model,
                'training_file' => $this->trainingFile,
                'suffix' => $this->suffix,
                'validation_file' => $this->validationFile,
                'integrations' => $this->integrations,
                'seed' => $this->seed,
                'method' => $this->methodProperties,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}

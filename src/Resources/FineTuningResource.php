<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Resources;

use PhpClient\OpenAI\Requests\FineTuning\CancelFineTuningJobRequest;
use PhpClient\OpenAI\Requests\FineTuning\CreateFineTuningJobRequest;
use PhpClient\OpenAI\Requests\FineTuning\ListFineTuningCheckpointsRequest;
use PhpClient\OpenAI\Requests\FineTuning\ListFineTuningEventsRequest;
use PhpClient\OpenAI\Requests\FineTuning\ListFineTuningJobsRequest;
use PhpClient\OpenAI\Requests\FineTuning\RetrieveFineTuningJobRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * Manage fine-tuning jobs to tailor a model to your specific training data.
 *
 * @see https://platform.openai.com/docs/api-reference/fine-tuning
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class FineTuningResource extends BaseResource
{
    /**
     * Creates a fine-tuning job which begins the process of creating a new model from a given dataset.
     *
     * Response includes details of the enqueued job including job status and the name of the fine-tuned models
     * once complete.
     *
     * @see https://platform.openai.com/docs/api-reference/fine-tuning/create
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
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
     *
     * @throws FatalRequestException|RequestException
     */
    public function createFineTuningJob(
        string $model,
        string $trainingFile,
        null|string $suffix = null,
        null|string $validationFile = null,
        null|array $integrations = null,
        null|int $seed = null,
        null|array $methodProperties = null,
    ): Response {
        return $this->connector->send(
            request: new CreateFineTuningJobRequest(
                model: $model,
                trainingFile: $trainingFile,
                suffix: $suffix,
                validationFile: $validationFile,
                integrations: $integrations,
                seed: $seed,
                methodProperties: $methodProperties,
            ),
        );
    }

    /**
     * List your organization's fine-tuning jobs
     *
     * @see https://platform.openai.com/docs/api-reference/fine-tuning/list
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string|null  $after  Identifier for the last job from the previous pagination request.
     *
     * @param  int|null  $limit  Number of fine-tuning jobs to retrieve.
     *
     * @throws FatalRequestException|RequestException
     */
    public function listFineTuningJobs(null|string $after = null, null|int $limit = null): Response
    {
        return $this->connector->send(
            request: new ListFineTuningJobsRequest(
                after: $after,
                limit: $limit,
            ),
        );
    }

    /**
     * Get status updates for a fine-tuning job.
     *
     * @see https://platform.openai.com/docs/api-reference/fine-tuning/list-events
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $fineTuningJobId  The ID of the fine-tuning job to get events for.
     *
     * @param  string|null  $after  Identifier for the last event from the previous pagination request.
     *
     * @param  int|null  $limit  Number of events to retrieve.
     *
     * @throws FatalRequestException|RequestException
     */
    public function listFineTuningEvents(
        string $fineTuningJobId,
        null|string $after = null,
        null|int $limit = null,
    ): Response {
        return $this->connector->send(
            request: new ListFineTuningEventsRequest(
                fineTuningJobId: $fineTuningJobId,
                after: $after,
                limit: $limit,
            ),
        );
    }

    /**
     * List checkpoints for a fine-tuning job.
     *
     * @see https://platform.openai.com/docs/api-reference/fine-tuning/list-checkpoints
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $fineTuningJobId  The ID of the fine-tuning job to get checkpoints for.
     *
     * @param  string|null  $after  Identifier for the last checkpoint ID from the previous pagination request.
     *
     * @param  int|null  $limit  Number of checkpoints to retrieve.
     *
     * @throws FatalRequestException|RequestException
     */
    public function listFineTuningCheckpoints(
        string $fineTuningJobId,
        null|string $after = null,
        null|int $limit = null,
    ): Response {
        return $this->connector->send(
            request: new ListFineTuningCheckpointsRequest(
                fineTuningJobId: $fineTuningJobId,
                after: $after,
                limit: $limit,
            ),
        );
    }

    /**
     * Get info about a fine-tuning job.
     *
     * @see https://platform.openai.com/docs/api-reference/fine-tuning/retrieve
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $fineTuningJobId  The ID of the fine-tuning job.
     *
     * @throws FatalRequestException|RequestException
     */
    public function retrieveFineTuningJob(string $fineTuningJobId): Response
    {
        return $this->connector->send(
            request: new RetrieveFineTuningJobRequest(
                fineTuningJobId: $fineTuningJobId,
            ),
        );
    }

    /**
     *
     * Immediately cancel a fine-tune job.
     *
     * @see https://platform.openai.com/docs/api-reference/fine-tuning/cancel
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $fineTuningJobId  The ID of the fine-tuning job to cancel.
     *
     * @throws FatalRequestException|RequestException
     */
    public function cancelFineTuningJob(string $fineTuningJobId): Response
    {
        return $this->connector->send(
            request: new CancelFineTuningJobRequest(
                fineTuningJobId: $fineTuningJobId,
            ),
        );
    }
}

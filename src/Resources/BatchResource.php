<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Resources;

use PhpClient\OpenAI\Requests\Batch\CancelBatchRequest;
use PhpClient\OpenAI\Requests\Batch\CreateBatchRequest;
use PhpClient\OpenAI\Requests\Batch\ListBatchRequest;
use PhpClient\OpenAI\Requests\Batch\RetrieveBatchRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * Create large batches of API requests for asynchronous processing.
 * The Batch API returns completions within 24 hours for a 50% discount.
 *
 * @see https://platform.openai.com/docs/api-reference/batch
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class BatchResource extends BaseResource
{
    /**
     * Creates and executes a batch from an uploaded file of requests
     *
     * @see https://platform.openai.com/docs/api-reference/batch/create
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $inputFileId  The ID of an uploaded file that contains requests for the new batch.
     * Your input file must be formatted as a JSONL file, and must be uploaded with the purpose batch. The file can
     * contain up to 50,000 requests, and can be up to 200 MB in size.
     *
     * @param  string  $endpoint  The endpoint to be used for all requests in the batch.
     * Currently, `/v1/chat/completions`, `/v1/embeddings`, and `/v1/completions` are supported.
     * Note that `/v1/embeddings` batches are also restricted to a maximum of 50,000 embedding inputs across all
     * requests in the batch.
     *
     * @param  string  $completionWindow  The time frame within which the batch should be processed.
     * Currently only `24h` is supported.
     *
     * @param  array|null  $metadata  Set of 16 key-value pairs that can be attached to an object.
     * This can be useful for storing additional information about the object in a structured format, and querying
     * for objects via API or the dashboard. Keys are strings with a maximum length of 64 characters.
     * Values are strings with a maximum length of 512 characters.
     *
     * @throws FatalRequestException|RequestException
     */
    public function createBatch(
        string $inputFileId,
        string $endpoint,
        string $completionWindow,
        null|array $metadata = null,
    ): Response {
        return $this->connector->send(
            request: new CreateBatchRequest(
                inputFileId: $inputFileId,
                endpoint: $endpoint,
                completionWindow: $completionWindow,
                metadata: $metadata,
            ),
        );
    }

    /**
     * Retrieves a batch.
     *
     * @see https://platform.openai.com/docs/api-reference/batch/retrieve
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $batchId  The  ID of the batch to retrieve.
     *
     * @throws FatalRequestException|RequestException
     */
    public function retrieveBatch(string $batchId): Response
    {
        return $this->connector->send(
            request: new RetrieveBatchRequest(
                batchId: $batchId,
            ),
        );
    }

    /**
     * Cancels an in-progress batch.
     *
     * The batch will be in status cancelling for up to 10 minutes, before changing to cancelled, where it will have
     * partial results (if any) available in the output file.
     *
     * @param  string  $batchId  The ID of the batch to cancel.
     *
     * @throws FatalRequestException|RequestException
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @see https://platform.openai.com/docs/api-reference/batch/cancel
     */
    public function cancelBatch(string $batchId): Response
    {
        return $this->connector->send(
            request: new CancelBatchRequest(
                batchId: $batchId,
            ),
        );
    }

    /**
     * List your organization's batches.
     *
     * @see https://platform.openai.com/docs/api-reference/batch/list
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string|null  $after  A cursor for use in pagination.
     * `after` is an object ID that defines your place in the list. For instance, if you make a list request
     * and receive 100 objects, ending with obj_foo, your subsequent call can include after=obj_foo in order
     * to fetch the next page of the list.
     *
     * @param  int|null  $limit  A limit on the number of objects to be returned. Limit can range between 1 and 100,
     * and the default is 20.
     *
     * @throws FatalRequestException|RequestException
     */
    public function listBatch(
        null|string $after = null,
        null|int $limit = null,
    ): Response {
        return $this->connector->send(
            request: new ListBatchRequest(
                after: $after,
                limit: $limit,
            ),
        );
    }
}

<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Resources;

use PhpClient\OpenAI\Requests\Files\DeleteFileRequest;
use PhpClient\OpenAI\Requests\Files\ListFilesRequest;
use PhpClient\OpenAI\Requests\Files\RetrieveFileContentRequest;
use PhpClient\OpenAI\Requests\Files\RetrieveFileRequest;
use PhpClient\OpenAI\Requests\Files\UploadFileRequest;
use Saloon\Data\MultipartValue;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * Files are used to upload documents that can be used with features like Assistants, Fine-tuning, and Batch API.
 *
 * @see https://platform.openai.com/docs/api-reference/files
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class FilesResource extends BaseResource
{
    /**
     * Upload a file that can be used across various endpoints.
     * Individual files can be up to 512 MB, and the size of all files uploaded by one organization can be up to 100 GB.
     *
     * The Assistants API supports files up to 2 million tokens and of specific file types. See the Assistants Tools guide
     * for details.
     *
     * The Fine-tuning API only supports .jsonl files. The input also has certain required formats for fine-tuning chat
     * or completions models.
     *
     * The Batch API only supports .jsonl files up to 200 MB in size. The input also has a specific required format.
     *
     * @see https://platform.openai.com/docs/api-reference/files/create
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  MultipartValue|string  $file  The File (object or path) to be uploaded.
     *
     * @param  string  $purpose  The intended purpose of the uploaded file.
     * Use "assistants" for Assistants and Message files, "vision" for Assistants image file inputs,
     * "batch" for Batch API, and "fine-tune" for Fine-tuning.
     *
     * @throws FatalRequestException|RequestException
     */
    public function uploadFile(MultipartValue|string $file, string $purpose): Response
    {
        return $this->connector->send(
            request: new UploadFileRequest(
                file: $file,
                purpose: $purpose,
            ),
        );
    }

    /**
     * Returns a list of files.
     *
     * @see https://platform.openai.com/docs/api-reference/files/list
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string|null  $purpose  Only return files with the given purpose.
     *
     * @param  int|null  $limit  A limit on the number of objects to be returned. Limit can range between 1 and 10,000,
     * and the default is 10,000.
     *
     * @param  string|null  $order  Sort order by the created_at timestamp of the objects. asc for ascending order
     * and desc for descending order.
     *
     * @param  string|null  $after  A cursor for use in pagination. after is an object ID that defines your place in
     * the list. For instance, if you make a list request and receive 100 objects, ending with obj_foo, your subsequent
     * call can include after=obj_foo in order to fetch the next page of the list.
     *
     * @throws FatalRequestException|RequestException
     */
    public function listFiles(
        null|string $purpose = null,
        null|int $limit = null,
        null|string $order = null,
        null|string $after = null,
    ): Response {
        return $this->connector->send(
            request: new ListFilesRequest(
                purpose: $purpose,
                limit: $limit,
                order: $order,
                after: $after,
            ),
        );
    }

    /**
     * Returns information about a specific file.
     *
     * @see https://platform.openai.com/docs/api-reference/files/retrieve
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $fileId  The ID of the file to use for this request.
     *
     * @throws FatalRequestException|RequestException
     */
    public function retrieveFile(string $fileId): Response
    {
        return $this->connector->send(
            request: new RetrieveFileRequest(
                fileId: $fileId,
            ),
        );
    }

    /**
     * Delete a file.
     *
     * @see https://platform.openai.com/docs/api-reference/files/delete
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $fileId  The ID of the file to use for this request.
     *
     * @throws FatalRequestException|RequestException
     */
    public function deleteFile(
        string $fileId,
    ): Response {
        return $this->connector->send(
            request: new DeleteFileRequest(
                fileId: $fileId,
            ),
        );
    }

    /**
     * Returns the contents of the specified file.
     *
     * @see https://platform.openai.com/docs/api-reference/files/retrieve-contents
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $fileId  The ID of the file to use for this request.
     *
     * @throws FatalRequestException|RequestException
     */
    public function retrieveFileContent(string $fileId): Response
    {
        return $this->connector->send(
            request: new RetrieveFileContentRequest(
                fileId: $fileId,
            ),
        );
    }
}

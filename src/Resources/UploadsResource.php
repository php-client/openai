<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Resources;

use PhpClient\OpenAI\Requests\Uploads\AddUploadPartRequest;
use PhpClient\OpenAI\Requests\Uploads\CancelUploadRequest;
use PhpClient\OpenAI\Requests\Uploads\CompleteUploadRequest;
use PhpClient\OpenAI\Requests\Uploads\CreateUploadRequest;
use Psr\Http\Message\StreamInterface;
use Saloon\Data\MultipartValue;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

final class UploadsResource extends BaseResource
{
    /**
     * Creates an intermediate Upload object that you can add Parts to.
     *
     * Currently, an Upload can accept at most 8 GB in total and expires after an hour after you create it.
     * Once you complete the Upload, we will create a File object that contains all the parts you uploaded.
     * This File is usable in the rest of our platform as a regular File object.
     *
     * @see https://platform.openai.com/docs/api-reference/uploads/create
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $filename  The name of the file to upload.
     *
     * @param  string  $purpose  The intended purpose of the uploaded file.
     *
     * @param  int  $bytes  The number of bytes in the file you are uploading.
     *
     * @param  string  $mimeType  This must fall within the supported MIME types for your file purpose.
     * See the supported MIME types for assistants and vision.
     *
     * @throws FatalRequestException|RequestException
     */
    public function createUpload(
        string $filename,
        string $purpose,
        int $bytes,
        string $mimeType,
    ): Response {
        return $this->connector->send(
            request: new CreateUploadRequest(
                filename: $filename,
                purpose: $purpose,
                bytes: $bytes,
                mimeType: $mimeType,
            ),
        );
    }

    /**
     * Adds a Part to an Upload object. A Part represents a chunk of bytes from the file you are trying to upload.
     *
     * Each Part can be at most 64 MB, and you can add Parts until you hit the Upload maximum of 8 GB.
     * It is possible to add multiple Parts in parallel. You can decide the intended order of the Parts when you complete
     * the Upload.
     *
     * @see https://platform.openai.com/docs/api-reference/uploads/add-part
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $uploadId  The ID of the Upload.
     *
     * @param  MultipartValue|StreamInterface|resource|string|int  $data  The chunk of bytes for this Part.
     * Data can be a MultipartValue, Stream, resource, string or integer.
     *
     * @throws FatalRequestException|RequestException
     */
    public function addUploadPart(string $uploadId, mixed $data): Response
    {
        return $this->connector->send(
            request: new AddUploadPartRequest(
                uploadId: $uploadId,
                data: $data,
            ),
        );
    }

    /**
     * Completes the Upload.
     *
     * Within the returned Upload object, there is a nested File object that is ready to use in the rest of the platform.
     * You can specify the order of the Parts by passing in an ordered list of the Part IDs.
     *
     * The number of bytes uploaded upon completion must match the number of bytes initially specified when creating
     * the Upload object. No Parts may be added after an Upload is completed.
     *
     * @see https://platform.openai.com/docs/api-reference/uploads/complete
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $uploadId  The ID of the Upload.
     *
     * @param  array  $partIds  The ordered list of Part IDs.
     *
     * @param  string|null  $md5  The optional md5 checksum for the file contents to verify if the bytes uploaded
     * matches what you expect.
     *
     * @throws FatalRequestException|RequestException
     */
    public function completeUpload(
        string $uploadId,
        array $partIds,
        null|string $md5 = null,
    ): Response {
        return $this->connector->send(
            request: new CompleteUploadRequest(
                uploadId: $uploadId,
                partIds: $partIds,
                md5: $md5,
            ),
        );
    }

    /**
     * Cancels the Upload. No Parts may be added after an Upload is cancelled.
     *
     * @see https://platform.openai.com/docs/api-reference/uploads/cancel
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $uploadId  The ID of the Upload.
     *
     * @throws FatalRequestException|RequestException
     */
    public function cancelUpload(string $uploadId): Response
    {
        return $this->connector->send(
            request: new CancelUploadRequest(
                uploadId: $uploadId,
            ),
        );
    }
}

<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Resources;

use RuntimeException;
use Saloon\Http\BaseResource;

final class Api extends BaseResource
{
    public function audio(): AudioResource
    {
        return new AudioResource(
            connector: $this->connector,
        );
    }

    public function chat(): ChatResource
    {
        return new ChatResource(
            connector: $this->connector,
        );
    }

    public function embeddings(): EmbeddingsResource
    {
        return new EmbeddingsResource(
            connector: $this->connector,
        );
    }

    public function fineTuning(): FineTuningResource
    {
        return new FineTuningResource(
            connector: $this->connector,
        );
    }

    public function batch(): BatchResource
    {
        return new BatchResource(
            connector: $this->connector,
        );
    }

    public function files(): FilesResource
    {
        return new FilesResource(
            connector: $this->connector,
        );
    }

    public function uploads(): UploadsResource
    {
        return new UploadsResource(
            connector: $this->connector,
        );
    }

    public function images(): ImagesResource
    {
        return new ImagesResource(
            connector: $this->connector,
        );
    }

    public function models(): ModelsResource
    {
        return new ModelsResource(
            connector: $this->connector,
        );
    }

    public function moderations(): ModerationsResource
    {
        return new ModerationsResource(
            connector: $this->connector,
        );
    }

    public function assistants(): never
    {
        throw new RuntimeException(message: 'Not implemented');
    }

    public function administration(): never
    {
        throw new RuntimeException(message: 'Not implemented');
    }

    public function realtime(): never
    {
        throw new RuntimeException(message: 'Not implemented');
    }

    public function legacyCompletion(): LegacyCompletionResource
    {
        return new LegacyCompletionResource(
            connector: $this->connector,
        );
    }
}

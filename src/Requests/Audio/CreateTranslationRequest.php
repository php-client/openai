<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Audio;

use PhpClient\OpenAI\Helpers\MultipartValueHelper;
use Saloon\Contracts\Body\HasBody;
use Saloon\Data\MultipartValue;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasMultipartBody;

/**
 * Translates audio into English.
 *
 * @see https://platform.openai.com/docs/api-reference/audio/createTranslation
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CreateTranslationRequest extends Request implements HasBody
{
    use HasMultipartBody;

    protected Method $method = Method::POST;

    /**
     * @param  MultipartValue|string  $file  The audio file (object or path) to transcribe, in one of these formats:
     *  `flac`, `mp3`, `mp4`, `mpeg`, `mpga`, `m4a`, `ogg`, `wav`, or `webm`.
     *
     * @param  string  $model  ID  of the model to use. Only `whisper-1` is currently available.
     *
     * @param  string|null  $prompt  An optional text to guide the model's style or continue a previous audio segment.
     * The prompt should be in English.
     *
     * @param  string|null  $responseFormat  The format of the output, in one of these options:
     * `json`, `text`, `srt`, `verbose_json`, or `vtt`.
     *
     * @param  float|null  $temperature  The sampling temperature, between 0 and 1. Higher values like 0.8 will make
     * the output more random, while lower values like 0.2 will make it more focused and deterministic.
     * If set to 0, the model will use log probability to automatically increase the temperature until certain
     * thresholds are hit.
     */
    public function __construct(
        public readonly MultipartValue|string $file,
        public readonly string $model,
        public readonly null|string $prompt = null,
        public readonly null|string $responseFormat = null,
        public readonly null|float $temperature = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/audio/translations';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'file' => MultipartValueHelper::ensureFile(file: $this->file),
                'model' => $this->model,
                'prompt' => $this->prompt,
                'response_format' => $this->responseFormat,
                'temperature' => $this->temperature,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}

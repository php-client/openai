<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Resources;

use PhpClient\OpenAI\Requests\Audio\CreateSpeechRequest;
use PhpClient\OpenAI\Requests\Audio\CreateTranscriptionRequest;
use PhpClient\OpenAI\Requests\Audio\CreateTranslationRequest;
use Saloon\Data\MultipartValue;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * @see https://platform.openai.com/docs/api-reference/audio
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class AudioResource extends BaseResource
{
    /**
     * Generates audio from the input text.
     *
     * @see https://platform.openai.com/docs/api-reference/audio/createSpeech
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $model  One of the available TTS models: `tts-1` or `tts-1-hd`.
     *
     * @param  string  $input  The text to generate audio for. The maximum length is 4096 characters.
     *
     * @param  string  $voice  The voice to use when generating the audio. Supported voices are `alloy`, `ash`,
     * `coral`, `echo`, `fable`, `onyx`, `nova`, `sage` and `shimmer`.
     *
     * @param  string|null  $responseFormat  The format to audio in. Supported formats are `mp3`, `opus`, `aac`,
     * `flac`, `wav`, and `pcm`.
     *
     * @param  float|null  $speed  The speed of the generated audio. Select a value from `0.25` to `4.0`.
     * `1.0` is the default.
     *
     * @throws FatalRequestException|RequestException
     */
    public function createSpeech(
        string $model,
        string $input,
        string $voice,
        null|string $responseFormat = null,
        null|float $speed = null,
    ): Response {
        return $this->connector->send(
            request: new CreateSpeechRequest(
                model: $model,
                input: $input,
                voice: $voice,
                responseFormat: $responseFormat,
                speed: $speed,
            ),
        );
    }

    /**
     * Transcribes audio into the input language.
     *
     * @see https://platform.openai.com/docs/api-reference/audio/createTranscription
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  MultipartValue|string  $file  The audio file (object or path) to transcribe, in one of these formats:
     * `flac`, `mp3`, `mp4`, `mpeg`, `mpga`, `m4a`, `ogg`, `wav`, or `webm`.
     *
     * @param  string  $model  ID of the model to use. Only `whisper-1` is currently available.
     *
     * @param  string|null  $language  The language of the input audio. Supplying the input language in ISO-639-1
     * (e.g. en) format will improve accuracy and latency.
     *
     * @param  string|null  $prompt  An optional text to guide the model's style or continue a previous audio segment.
     * The prompt should match the audio language.
     *
     * @param  string|null  $responseFormat  The format of the output, in one of these options:
     * `json`, `text`, `srt`, `verbose_json`, or `vtt`.
     *
     * @param  float|null  $temperature  The sampling temperature, between 0 and 1. Higher values like 0.8 will make
     * the output more random, while lower values like 0.2 will make it more focused and deterministic.
     * If set to 0, the model will use log probability to automatically increase the temperature until certain
     * thresholds are hit.
     *
     * @param  array|null  $timestampGranularities  The timestamp granularities to populate for this transcription.
     * `$responseFormat` must be set `verbose_json` to use timestamp granularities. Either or both of these options
     * are supported: `word`, or `segment`. Note: There is no additional latency for segment timestamps, but generating
     * word timestamps incurs additional latency.
     *
     * @throws FatalRequestException|RequestException
     */
    public function createTranscription(
        MultipartValue|string $file,
        string $model,
        null|string $language = null,
        null|string $prompt = null,
        null|string $responseFormat = null,
        null|float $temperature = null,
        null|array $timestampGranularities = null,
    ): Response {
        return $this->connector->send(
            request: new CreateTranscriptionRequest(
                file: $file,
                model: $model,
                language: $language,
                prompt: $prompt,
                responseFormat: $responseFormat,
                temperature: $temperature,
                timestampGranularities: $timestampGranularities,
            ),
        );
    }

    /**
     * Translates audio into English.
     *
     * @see https://platform.openai.com/docs/api-reference/audio/createTranslation
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  MultipartValue|string  $file  The audio file (object or path) to transcribe, in one of these formats:
     * `flac`, `mp3`, `mp4`, `mpeg`, `mpga`, `m4a`, `ogg`, `wav`, or `webm`.
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
     *
     * @throws FatalRequestException|RequestException
     */
    public function createTranslation(
        MultipartValue|string $file,
        string $model,
        null|string $prompt = null,
        null|string $responseFormat = null,
        null|float $temperature = null,
    ): Response {
        return $this->connector->send(
            request: new CreateTranslationRequest(
                file: $file,
                model: $model,
                prompt: $prompt,
                responseFormat: $responseFormat,
                temperature: $temperature,
            ),
        );
    }
}

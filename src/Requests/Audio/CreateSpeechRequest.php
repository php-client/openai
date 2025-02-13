<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Requests\Audio;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

use function array_filter;

/**
 * Generates audio from the input text.
 *
 * @see https://platform.openai.com/docs/api-reference/audio/createSpeech
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class CreateSpeechRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    /**
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
     */
    public function __construct(
        public readonly string $model,
        public readonly string $input,
        public readonly string $voice,
        public readonly null|string $responseFormat = null,
        public readonly null|float $speed = null,
    ) {}

    public function resolveEndpoint(): string
    {
        return '/v1/audio/speech';
    }

    protected function defaultBody(): array
    {
        return array_filter(
            array: [
                'model' => $this->model,
                'input' => $this->input,
                'voice' => $this->voice,
                'response_format' => $this->responseFormat,
                'speed' => $this->speed,
            ],
            callback: static fn(mixed $value): bool => $value !== null,
        );
    }
}

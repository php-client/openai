<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Resources;

use PhpClient\OpenAI\Requests\LegacyCompletion\CreateCompletionRequest;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

/**
 * Given a prompt, the model will return one or more predicted completions along with the probabilities of alternative
 * tokens at each position.
 *
 * Most developer should use our Chat Completions API to leverage our best and newest models.
 *
 * @see https://platform.openai.com/docs/api-reference/completions
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class LegacyCompletionResource extends BaseResource
{
    /**
     * Creates a completion for the provided prompt and parameters.
     *
     * @see https://platform.openai.com/docs/api-reference/completions/create
     * @version Relevant for 2025-02-13, OpenAI API v1
     *
     * @param  string  $model  ID of the model to use.
     *
     * @param  string|array  $prompt  The prompt(s) to generate completions for, encoded as a string, array of strings,
     * array of tokens, or array of token arrays.
     * Note that `<|endoftext|>` is the document separator that the model sees during training, so if a prompt is not
     * specified the model will generate as if from the beginning of a new document.
     *
     * @param  int|null  $bestOf  Generates `best_of` completions server-side and returns the "best"
     * (the one with the highest log probability per token). Results cannot be streamed.
     * When used with `n`, `best_of` controls the number of candidate completions and `n` specifies how many
     * to return – `best_of` must be greater than `n`.
     * Note: Because this parameter generates many completions, it can quickly consume your token quota.
     * Use carefully and ensure that you have reasonable settings for max_tokens and stop.
     *
     * @param  bool|null  $echo  Echo back the prompt in addition to the completion
     *
     * @param  float|null  $frequencyPenalty  Number between -2.0 and 2.0. Positive values penalize new tokens based
     * on their existing frequency in the text so far, decreasing the model's likelihood to repeat the same line
     * verbatim.
     *
     * @param  array|null  $logitBias  Modify the likelihood of specified tokens appearing in the completion.
     * Accepts a JSON object that maps tokens (specified by their token ID in the GPT tokenizer) to an associated
     * bias value from -100 to 100. You can use this tokenizer tool to convert text to token IDs. Mathematically,
     * the bias is added to the logits generated by the model prior to sampling. The exact effect will vary per
     * model, but values between -1 and 1 should decrease or increase likelihood of selection; values like -100
     * or 100 should result in a ban or exclusive selection of the relevant token.
     * As an example, you can pass `{"50256": -100}` to prevent the `<|endoftext|>` token from being generated.
     *
     * @param  bool|null  $logprobs  Include the log probabilities on the `logprobs` most likely output tokens,
     * as well the chosen tokens. For example, if `logprobs` is 5, the API will return a list of the 5 most likely
     * tokens. The API will always return the `logprob` of the sampled token, so there may be up to `logprobs+1`
     * elements in the response.
     * The maximum value for `logprobs` is 5.
     *
     * @param  int|null  $maxTokens  The maximum number of tokens that can be generated in the completion.
     * The token count of your prompt plus `max_tokens` cannot exceed the model's context length.
     *
     * @param  int|null  $n  How many completions to generate for each prompt.
     * Note: Because this parameter generates many completions, it can quickly consume your token quota.
     * Use carefully and ensure that you have reasonable settings for `max_tokens` and `stop`.
     *
     * @param  float|null  $presencePenalty  Number between -2.0 and 2.0. Positive values penalize new tokens based
     * on whether they appear in the text so far, increasing the model's likelihood to talk about new topics.
     *
     * @param  int|null  $seed  If specified, our system will make a best effort to sample deterministically,
     * such that repeated requests with the same `seed` and parameters should return the same result.
     * Determinism is not guaranteed, and you should refer to the `system_fingerprint` response parameter to monitor
     * changes in the backend.
     *
     * @param  string|array|null  $stop  Up to 4 sequences where the API will stop generating further tokens.
     * The returned text will not contain the stop sequence.
     *
     * @param  bool|null  $stream  Whether to stream back partial progress. If set, tokens will be sent as data-only
     * server-sent events as they become available, with the stream terminated by a `data: [DONE]` message.
     *
     * @param  array|null  $streamOptions  Options for streaming response. Only set this when you set `stream: true`.
     *
     * @param  string|null  $suffix  The suffix that comes after a completion of inserted text.
     * This parameter is only supported for `gpt-3.5-turbo-instruct`.
     *
     * @param  float|null  $temperature  What sampling temperature to use, between 0 and 2. Higher values like 0.8
     * will make the output more random, while lower values like 0.2 will make it more focused and deterministic.
     * We generally recommend altering this or `top_p` but not both.
     *
     * @param  float|null  $topP  An alternative to sampling with temperature, called nucleus sampling, where the model
     * considers the results of the tokens with top_p probability mass. So 0.1 means only the tokens comprising the top
     * 10% probability mass are considered.
     * We generally recommend altering this or `temperature` but not both.
     *
     * @param  string|null  $user  A unique identifier representing your end-user, which can help OpenAI to monitor
     * and detect abuse.
     *
     * @throws FatalRequestException|RequestException
     */
    public function createCompletion(
        string $model,
        string|array $prompt,
        null|int $bestOf = null,
        null|bool $echo = null,
        null|float $frequencyPenalty = null,
        null|array $logitBias = null,
        null|bool $logprobs = null,
        null|int $maxTokens = null,
        null|int $n = null,
        null|float $presencePenalty = null,
        null|int $seed = null,
        null|string|array $stop = null,
        null|bool $stream = null,
        null|array $streamOptions = null,
        null|string $suffix = null,
        null|float $temperature = null,
        null|float $topP = null,
        null|string $user = null,
    ): Response {
        return $this->connector->send(
            request: new CreateCompletionRequest(
                model: $model,
                prompt: $prompt,
                bestOf: $bestOf,
                echo: $echo,
                frequencyPenalty: $frequencyPenalty,
                logitBias: $logitBias,
                logprobs: $logprobs,
                maxTokens: $maxTokens,
                n: $n,
                presencePenalty: $presencePenalty,
                seed: $seed,
                stop: $stop,
                stream: $stream,
                streamOptions: $streamOptions,
                suffix: $suffix,
                temperature: $temperature,
                topP: $topP,
                user: $user,
            ),
        );
    }
}

<?php

declare(strict_types=1);

namespace PhpClient\OpenAI;

use PhpClient\OpenAI\Resources\Api;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\HasTimeout;

use function array_filter;

/**
 * PHP Client for OpenAI API.
 *
 * @see https://platform.openai.com/docs/api-reference/introduction
 * @version Relevant for 2025-02-13, OpenAI API v1
 */
final class OpenAI extends Connector
{
    use HasTimeout;

    public readonly Api $api;

    /**
     * @param  string  $baseUrl  The base URL of the OpenAI server
     */
    public function __construct(
        private readonly string $baseUrl,
        private readonly null|string $token = null,
        private readonly null|string $organization = null,
        private readonly null|string $project = null,
        private readonly int $requestTimeout = 300,
    ) {
        $this->api = new Api(connector: $this);
    }

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    protected function defaultHeaders(): array
    {
        return array_filter(
            array: [
                'Accept' => 'application/json',
                'Authorization' => $this->token ? "Bearer $this->token" : null,
                'Content-Type' => 'application/json',
                'OpenAI-Organization' => $this->organization,
                'OpenAI-Project' => $this->project,
            ],
        );
    }
}

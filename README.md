# PHP client for OpenAI API.

This is a PHP client for the OpenAI API.

## Installation

Install the package via composer:

```bash
composer require php-client/openai
```

## Usage

```php
use PhpClient\OpenAI\OpenAI;

$syncthing = new OpenAI(
    baseUrl: 'https://api.openai.com',
    token: 'YOUR_API_TOKEN',
);

$response = $syncthing->api->chat()->createChatCompletion(
    model: 'gpt-4o',
    messages: [
        ['role' => 'user', 'content' => 'Hello'],
    ],
);

echo $response->json(key: 'choices.0.message.content');

// or

foreach ($response->json(key: 'choices') as $choice) {
    echo $choice['message']['content'];
}

```

## List of available API methods

- Audio
    - Create speech|transcription|translation
- Chat
    - Create chat completion
- Embeddings
    - Create embeddings
- Fine-tuning
    - Create|Retrieve|Cancel fine-tuning job
    - List fine-tuning jobs|events|checkpoints
- Batch
    - Create|Retrieve|Cancel|List batch
- Files
    - List files
    - Upload|Retrieve|Delete file
    - Retrieve file content
- Uploads
    - Create|Complete|Cancel upload
    - Add upload part
- Images
    - Create image
    - Create image edit|variation
- Models
    - List models
    - Retrieve model
    - Delete fine-tuned model
- Moderations
    - Create moderation
- LegacyCompletions
    - Create completion

## Not implemented API methods (in development)

- Assistants
- Administration
- Realtime
- Legacy

## License

This package is released under the [MIT License](LICENSE.md).

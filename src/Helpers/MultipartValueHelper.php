<?php

declare(strict_types=1);

namespace PhpClient\OpenAI\Helpers;

use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;
use Saloon\Data\MultipartValue;

use function is_int;
use function is_resource;
use function is_string;

final class MultipartValueHelper
{
    /**
     * @param  MultipartValue|string  $file  MultipartValue representation of file or string path to file
     * @return MultipartValue
     */
    public static function ensureFile(MultipartValue|string $file): MultipartValue
    {
        if (is_string(value: $file)) {
            if (!file_exists(filename: $file)) {
                throw new InvalidArgumentException(message: 'File does not exist');
            }

            $file = new MultipartValue(
                name: basename(path: $file),
                value: $file,
            );
        }

        return $file;
    }

    /**
     * @param  MultipartValue|StreamInterface|resource|string|int  $data
     * @return MultipartValue
     */
    public static function ensureData(mixed $data): MultipartValue
    {
        if ($data instanceof MultipartValue) {
            return $data;
        }

        if (
            $data instanceof StreamInterface
            || is_resource(value: $data)
            || is_string(value: $data)
            || is_int(value: $data)
        ) {
            return new MultipartValue(name: '', value: $data);
        }

        throw new InvalidArgumentException(
            message: 'Data must be a MultipartValue, StreamInterface, resource, string or integer.',
        );
    }
}

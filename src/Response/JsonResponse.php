<?php

declare(strict_types=1);

namespace Raketa\BackendTestTask\Response;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Класс заглушка
 */
final class JsonResponse implements ResponseInterface
{
    protected StreamInterface $body;
    protected int $statusCode;
    protected string $version;
    protected array $headers;
    protected string $reasonPhrase = "";

    public function __construct(int $statusCode = 200, string $reasonPhrase = "", array $headers = [],  string $version = "1.0")
    {
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;
        $this->version = $version;

        $this->headers = $headers;
        $this->headers["Content-Type"] = "application/json";
    }
    public function getProtocolVersion(): string
    {
        // TODO: Implement getProtocolVersion() method.
        return $this->version;
    }

    public function withProtocolVersion(string $version): MessageInterface
    {
        // TODO: Implement withProtocolVersion() method.
        $this->version = $version;
        return $this;
    }

    public function getHeaders(): array
    {
        // TODO: Implement getHeaders() method.
        return $this->headers;
    }

    public function hasHeader(string $name): bool
    {
        // TODO: Implement hasHeader() method.
        return isset($this->headers[$name]);
    }

    public function getHeader(string $name): array
    {
        // TODO: Implement getHeader() method.
        return $this->headers[$name] ?? [];
    }

    public function getHeaderLine(string $name): string
    {
        // TODO: Implement getHeaderLine() method.
        if (! isset($this->headers[$name])) {
            return "";
        }
        if (is_array($this->headers[$name])) {
            return implode(", ", $this->headers[$name]);
        }
        return (string) $this->headers[$name];
    }

    public function withHeader(string $name, $value): MessageInterface
    {
        // TODO: Implement withHeader() method.
        $this->headers[$name] = $value;
        return $this;
    }

    public function withAddedHeader(string $name, $value): MessageInterface
    {
        // TODO: Implement withAddedHeader() method.
        if (! $this->hasHeader($name)) {
            $this->headers[$name] = $value;
        } else {
            $this->headers[$name] = array_merge(
                is_array($this->headers[$name]) ? $this->headers[$name] : (array)$this->headers[$name],
                $value
            );
        }

        return $this;
    }

    public function withoutHeader(string $name): MessageInterface
    {
        // TODO: Implement withoutHeader() method.
        if ($this->hasHeader($name)) {
            unset($this->headers[$name]);
        }
        return $this;
    }

    public function getBody(): StreamInterface
    {
        // TODO: Implement getBody() method.
        return $this->body;
    }

    public function withBody(StreamInterface $body): MessageInterface
    {
        // TODO: Implement withBody() method.
        $this->body = $body;
        return $this;
    }

    public function getStatusCode(): int
    {
        // TODO: Implement getStatusCode() method.
        return $this->statusCode;
    }

    public function withStatus(int $code, string $reasonPhrase = ''): ResponseInterface
    {
        // TODO: Implement withStatus() method.
        $this->statusCode = $code;
        $this->reasonPhrase = $reasonPhrase;
        return $this;
    }

    public function getReasonPhrase(): string
    {
        // TODO: Implement getReasonPhrase() method.
        return $this->reasonPhrase;
    }
}

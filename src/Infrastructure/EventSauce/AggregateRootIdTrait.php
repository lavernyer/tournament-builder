<?php

declare(strict_types=1);

namespace App\Infrastructure\EventSauce;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

trait AggregateRootIdTrait
{
    private string $id;

    public static function create(): static
    {
        return new self(Uuid::uuid4()->toString());
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new self($aggregateRootId);
    }

    public function equals(self $identity): bool
    {
        return $this->id === $identity->id;
    }

    public function toString(): string
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    private function __construct(string $id)
    {
        $this->assertValidId($id);

        $this->id = $id;
    }

    protected function assertValidId(string $id): void
    {
        Assert::uuid($id);
    }
}

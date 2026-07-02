<?php
declare(strict_types=1);

namespace nostriphant\NIP01;


readonly class Rumor implements Taggable {
    public string $id;

    public function __construct(public int $created_at, public string $pubkey, public int $kind, public string $content, public array $tags) {
        $this->id = hash('sha256', Nostr::encode([0, $pubkey, $this->created_at, $this->kind, $this->tags, $this->content]));
    }

    public function __invoke(): array {
        return get_object_vars($this);
    }

    public static function __set_state(array $properties): self {
        return new self(...$properties);
    }
}

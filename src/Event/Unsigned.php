<?php

declare(strict_types=1);

namespace nostriphant\NIP01\Event;

use nostriphant\NIP01\Event;
use nostriphant\NIP01\Nostr;
use nostriphant\NIP01\Key;
use nostriphant\NIP01\Taggable;

readonly class Unsigned implements Taggable {

    public function __construct(public int $created_at, public int $kind, public string $content, public array $tags) {

    }

    public function __invoke(Key $private_key): Event {
        $pubkey = Key::derivePublicKey($private_key);
        $id = hash('sha256', Nostr::encode([0, $pubkey, $this->created_at, $this->kind, $this->tags, $this->content]));
        return new Event(
                id: $id,
                pubkey: $pubkey,
                created_at: $this->created_at,
                kind: $this->kind,
                tags: $this->tags,
                content: $this->content,
                sig: Key::sign($private_key, $id)
        );
    }

    public static function __set_state(array $properties): self {
        return new self(...$properties);
    }
}

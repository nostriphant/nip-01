<?php

namespace nostriphant\NIP01;


readonly class Rumor {
    
    public function __construct(public int $created_at, public int $kind, public string $content, public array $tags) {
    }

    public function __invoke(Key $private_key): Event {
        $pubkey = $private_key(Key::public());
        $id = hash('sha256', Nostr::encode([0, $pubkey, $this->created_at, $this->kind, $this->tags, $this->content]));
        return new Event(
            id: $id,
            pubkey: $pubkey,
            created_at: $this->created_at,
            kind: $this->kind,
            tags: $this->tags,
            content: $this->content,
            sig: $private_key(Key::signer($id))
        );
    }


    public static function __set_state(array $properties): self {
        return new self(...$properties);
    }
}

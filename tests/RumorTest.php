<?php

use nostriphant\NIP01\Key;
use nostriphant\NIP01\Rumor;
use nostriphant\NIP01\Nostr;

it('wraps message in a seal and seal in a gift', function () {
    $sender_key = Key::fromHex('a71a415936f2dd70b777e5204c57e0df9a6dffef91b3c78c1aa24e54772e33c3');
    $sender_pubkey = $sender_key(Key::public());

    $message = new Rumor(
            pubkey: $sender_pubkey,
            created_at: time(),
            kind: 14,
            content: 'Hello!!',
            tags: []
    );
    
    expect($message->id)->toBe(hash('sha256', Nostr::encode([0, $message->pubkey, $message->created_at, $message->kind, $message->tags, $message->content])));
    expect($message)->not()->toHaveProperty('sig');
    
    $event = $message($sender_key);
    
    expect(Key::verify($event->pubkey, $event->sig, $event->id))->toBeTrue();
});

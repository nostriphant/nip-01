<?php

use nostriphant\NIP01\Key;
use nostriphant\NIP01\Rumor;
use nostriphant\NIP01\Nostr;

it('wraps message in a seal and seal in a gift', function () {
    $sender_key = Key::fromHex('435790f13406085d153b10bd9e00a9f977e637f10ce37db5ccfc5d3440c12d6c');
    $sender_pubkey = $sender_key(Key::public());

    $message = new Rumor(
            created_at: time(),
            kind: 14,
            content: 'Hello!!',
            tags: [
                ['p', $sender_pubkey]
            ]
    );
    
    expect($message)->not()->toHaveProperty('sig');
    expect($message)->not()->toHaveProperty('id');
    
    expect(\nostriphant\NIP01\Event::hasTag($message, 'p'))->toBeTrue();
    expect(\nostriphant\NIP01\Event::hasTagValue($message, 'p', $sender_pubkey))->toBeTrue();
    expect(\nostriphant\NIP01\Event::extractTagValues($message, 'p'))->toBe([[$sender_pubkey]]);
    
    
    $event = $message($sender_key);  
    expect($event->id)->toBe(hash('sha256', Nostr::encode([0, $sender_pubkey, $message->created_at, $message->kind, $message->tags, $message->content])));  
    expect(\nostriphant\NIP01\Event::verify($event))->toBeTrue();
});

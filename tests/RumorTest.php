<?php

use nostriphant\NIP01\Key;
use nostriphant\NIP01\Rumor;
use nostriphant\NIP01\Nostr;

it('wraps message in a seal and seal in a gift', function () {
    $sender_key = Key::fromHex('435790f13406085d153b10bd9e00a9f977e637f10ce37db5ccfc5d3440c12d6c');
    $sender_pubkey = Key::derivePublicKey($sender_key);

    $rumor = new Rumor(
            created_at: time(),
            pubkey: $sender_pubkey,
            kind: 14,
            content: 'Hello!!',
            tags: [
                ['p', $sender_pubkey]
            ]
    );

    expect($rumor)->not()->toHaveProperty('sig');
    expect($rumor)->toHaveProperty('id');
    expect($rumor->id)->toBe(hash('sha256', Nostr::encode([0, $sender_pubkey, $rumor->created_at, $rumor->kind, $rumor->tags, $rumor->content])));
});


it('can have its tags extracted', function () {
    $sender_key = Key::fromHex('435790f13406085d153b10bd9e00a9f977e637f10ce37db5ccfc5d3440c12d6c');
    $sender_pubkey = Key::derivePublicKey($sender_key);

    $rumor = new Rumor(
            created_at: time(),
            pubkey: $sender_pubkey,
            kind: 14,
            content: 'Hello!!',
            tags: [
                ['p', $sender_pubkey]
            ]
    );


    expect(\nostriphant\NIP01\Event::hasTag($rumor, 'p'))->toBeTrue();
    expect(\nostriphant\NIP01\Event::hasTagValue($rumor, 'p', $sender_pubkey))->toBeTrue();
    expect(\nostriphant\NIP01\Event::extractTagValues($rumor, 'p'))->toBe([[$sender_pubkey]]);
});

<?php

namespace Pest;

use nostriphant\NIP01\Event;
use nostriphant\NIP01\Key;

function vectors_secp256k1(): object {
    return json_decode(file_get_contents(__DIR__ . '/vectors/ecdh-secp256k1.json'), false);
}

function key(string $hex): Key {
    return Key::fromHex($hex);
}

function key_sender(): Key {
    return key('a71a415936f2dd70b777e5204c57e0df9a6dffef91b3c78c1aa24e54772e33c3');
}

function pubkey_sender(): string {
    return key_sender()(Key::public());
}

function key_recipient(): Key {
    return key('6eeb5ad99e47115467d096e07c1c9b8b41768ab53465703f78017204adc5b0cc');
}

function pubkey_recipient(): string {
    return key_recipient()(Key::public());
}

function event(array $event): Event {
    return new Event(...array_merge([
                'id' => '',
                'pubkey' => '',
                'created_at' => time(),
                'kind' => 1,
                'content' => 'Hello World',
                'sig' => '',
                'tags' => []
                    ], $event));
}

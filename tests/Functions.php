<?php

namespace Pest;

use nostriphant\NIP01\Event;

function vectors(string $name): object {
    return json_decode(file_get_contents(__DIR__ . '/vectors/' . $name . '.json'), false);
}

function key(string $nsec): Key {
    return Key::fromHex(Bech32::fromNsec($nsec));
}

function key_sender(): Key {
    return key('nsec15udyzkfk7twhpdmhu5syc4lqm7dxmll0jxeu0rq65f89gaewx0ps89derx');
}

function pubkey_sender(): string {
    return key_sender()(Key::public());
}

function key_recipient(): Key {
    return key('nsec1dm444kv7gug4ge7sjms8c8ym3dqhdz44x3jhq0mcq9eqftw9krxqymj9qk');
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

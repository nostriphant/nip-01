<?php

use nostriphant\NIP01\Message;
use nostriphant\NIP01\Event;

it('can construct a message', function () {
    $message = new Message('TYPE', 'a', ['b' => 'c']);
    expect($message())->toBe(['TYPE', 'a', ['b' => 'c']]);
});

it('can convert a message to string', function () {
    $message = new Message('TYPE', 'a');
    expect($message . '')->toBe('["TYPE","a"]');
});

it('can decode a string into a message', function () {
    $message = Message::decode('["TYPE", "a", {"b":"c"}]');
    expect($message())->toBe(['TYPE', 'a', ['b' => 'c']]);
});


it('can fabric a message', function () {
    $message = Message::event('a', ['b' => 'c']);
    expect($message())->toBe(['EVENT', 'a', ['b' => 'c']]);
});

it('can fabric a message with an Event', function () {
    $message = Message::event($event = new Event(
            id: '',
            pubkey: '',
            created_at: 1734349976,
            kind: 1,
            content: 'Hello World',
            sig: '',
            tags: []
    ));

    expect($message())->toBe(["EVENT", $event]);
    expect('' . $message)->toBe('["EVENT",{"id":"","pubkey":"","created_at":1734349976,"kind":1,"content":"Hello World","sig":"","tags":[]}]');
});

<?php

use nostriphant\NIP01\Message;

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

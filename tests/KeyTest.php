<?php

namespace nostriphant\NIP01Tests;

use nostriphant\NIP01\Key;


it('generates a private key', function () {
    $private_key = Key::generate();
    $hex_private_key = $private_key(Key::private());
    expect($hex_private_key)->toBeString();

    $hex_public_key = Key::derivePublicKey($private_key);
    expect($hex_public_key)->toBe(substr((new \Elliptic\EC('secp256k1'))->keyFromPrivate($hex_private_key)->getPublic(true, 'hex'), 2));
});

it('generates a public key without an argument', function() {
    $private_key = Key::fromHex('435790f13406085d153b10bd9e00a9f977e637f10ce37db5ccfc5d3440c12d6c');
    expect(Key::derivePublicKey($private_key))->toBe('89ac55aeeb301252da33b51ca4d189cb1d665b8f00618f5ea72c2ec59ca555e9');
});

it('converts between bytes and hexidecimal', function () {

    $public_key_hex = '7e7e9c42a91bfef19fa929e5fda1b72e0ebc1a4c1141673e2794234d86addf4e';
    //$public_key_bech32 = 'npub10elfcs4fr0l0r8af98jlmgdh9c8tcxjvz9qkw038js35mp4dma8qzvjptg';
    $private_key_hex = '67dea2ed018072d675f5415ecfaed7d2597555e202d85b3d65ea4e58d2d92ffa';
    //$private_key_bech32 = 'nsec1vl029mgpspedva04g90vltkh6fvh240zqtv9k0t9af8935ke9laqsnlfe5';

    $key = Key::fromHex($private_key_hex);
    expect($key(fn() => func_get_arg(0)))->toBe($private_key_hex);
    expect(Key::derivePublicKey($key))->toBe($public_key_hex);
});


it('converts between bytes and hexidecimal for provided functions', function () {
    $private_key = Functions::key_sender();
    expect(Key::derivePublicKey($private_key))->toBe(Functions::pubkey_sender());

    $private_key = Functions::key_recipient();
    expect(Key::derivePublicKey($private_key))->toBe(Functions::pubkey_recipient());
})->with();

it('can sign a string and verify a signature', function () {
    $private_key = Key::fromHex('435790f13406085d153b10bd9e00a9f977e637f10ce37db5ccfc5d3440c12d6c');

    expect(Key::derivePublicKey($private_key))->toBe('89ac55aeeb301252da33b51ca4d189cb1d665b8f00618f5ea72c2ec59ca555e9');

    $hash = hash('sha256', 'hallo world');
    
    expect(Key::verify('89ac55aeeb301252da33b51ca4d189cb1d665b8f00618f5ea72c2ec59ca555e9', Key::sign($private_key, $hash), $hash))->toBeTrue();
});

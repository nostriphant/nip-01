<?php

namespace nostriphant\NIP01;

use nostriphant\Secp256k1\Secp256k1;

readonly class Key {

    public function __construct(#[\SensitiveParameter] private string $private_key) {
        
    }

    public function __invoke(callable $input): mixed {
        return $input($this->private_key);
    }

    static function fromHex(#[\SensitiveParameter] string $private_key): callable {
        return new self($private_key);
    }

    static function generate(): callable {
        return new self(Secp256k1::generate());
    }

    static function signer(string $hash): callable {
        return fn(string $private_key) => Secp256k1::sign($private_key, $hash);
    }

    static function verify(string $pubkey, string $signature, string $hash): bool {
        return Secp256k1::verify($pubkey, $hash, $signature);
    }

    static function public(): callable {
        return fn(#[\SensitiveParameter] string $private_key): string => Secp256k1::derive($private_key);
    }
    static function private(): callable {
        return fn(#[\SensitiveParameter] string $private_key): string => $private_key;
    }
}

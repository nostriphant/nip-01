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

    #[\Deprecated('use sign method instead', '3.0.0')]
    static function signer(string $hash): callable {
        return fn(string $private_key) => Secp256k1::sign($private_key, $hash);
    }
    static function sign(self $key, string $hash): string {
        return Secp256k1::sign($key->private_key, $hash);
    }

    static function verify(string $pubkey, string $signature, string $hash): bool {
        return Secp256k1::verify($pubkey, $hash, $signature);
    }

    #[\Deprecated('use derivePublicKey method instead', '3.0.0')]
    static function public(): callable {
        return fn(#[\SensitiveParameter] string $private_key): string => Secp256k1::derive($private_key);
    }
    static function derivePublicKey(self $key): string {
        return secp256k1::derive($key->private_key);
    }
    
    static function private(): callable {
        return fn(#[\SensitiveParameter] string $private_key): string => $private_key;
    }
}

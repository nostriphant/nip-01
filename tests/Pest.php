<?php
namespace {
    
}

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/
namespace Pest {

    use nostriphant\NIP01\Key;

    function key(string $nsec): Key {
        return Key::fromBech32($nsec);
    }

    function key_sender(): Key {
        return key('nsec15udyzkfk7twhpdmhu5syc4lqm7dxmll0jxeu0rq65f89gaewx0ps89derx');
    }

    function pubkey_sender(Key\Format $format = Key\Format::HEXIDECIMAL): string {
        return key_sender()(Key::public($format));
    }

    function key_recipient(): Key {
        return key('nsec1dm444kv7gug4ge7sjms8c8ym3dqhdz44x3jhq0mcq9eqftw9krxqymj9qk');
    }

    function pubkey_recipient(Key\Format $format = Key\Format::HEXIDECIMAL): string {
        return key_recipient()(Key::public($format));
    }


    function vectors(string $name): object {
        return json_decode(file_get_contents(__DIR__ . '/vectors/' . $name . '.json'), false);
    }

}
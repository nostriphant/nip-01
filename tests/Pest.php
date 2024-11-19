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

    function vectors(string $name): object {
        return json_decode(file_get_contents(__DIR__ . '/vectors/' . $name . '.json'), false);
    }

}
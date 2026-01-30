<?php

test('addition works', function () {
    expect(1 + 1)->toBe(2);
});

test('it can handle strings', function () {
    expect('Pest')->toBeString()->not->toBeEmpty();
});

test('it can handle arrays', function () {
    $array = [1, 2, 3];
    
    expect($array)
        ->toBeArray()
        ->toHaveCount(3)
        ->toContain(2)
        ->not->toContain(4);
});

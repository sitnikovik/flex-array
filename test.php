<?php

use Benb0nes\FlexArray\FlexArray;

include __DIR__ . '/src/FlexArray.php';

// Some array to be processed.
$array = [
    [0, 1, 2, 3, 5],
    'fruits' => ['apple', 'orange'],
    'persons' => [
        'john_doe' => [
            'name' => 'John Doe',
            'cars' => ['bmw', 'audi'],
            'isActive' => true,
            'comment' => 'some description',
        ],
        'mike_shepard' => [
            'name' => 'Mike Shepard',
            'cars' => [],
            'isActive' => false,
            'comment' => null
        ],
    ]
];

function test(...$conditions) {
    foreach ($conditions as $condition) {
        if (!$condition) {
            return '1';
        }
    }
    return '.';
}

// Making FlexArray.
$flex = new FlexArray($array);

$result = [];

/** get */
$result[] = test($flex->get('fruits') === $array['fruits']);

/** getAll */
$result[] = test($flex->getAll() === $array);

/** getKeys */
$result[] = test($flex->getKeys() === array_keys($array));

/** getAllBut */
$result[] = test($flex->getAllBut('persons') === array_merge([], [$array[0]], ['fruits' => $array['fruits']]));

/** getAllIntegers */
$result[] = test(
    $flex->getAllIntegers() === [],
    $flex->createByFirst()->getAllIntegers() === $array[0]
);

/** getAllStrings */
$result[] = test(
    $flex->getAllStrings() === [],
    $flex->createBy('fruits')->getAllStrings() === $array['fruits']
);

/** getAllBooleans */
$result[] = test(
    $flex->getAllBooleans() === [],
    $flex->createBy('persons')->createBy('john_doe')->getAllBooleans() === ['isActive' => true],
    $flex->createBy('persons')->createBy('mike_shepard')->getAllBooleans() === ['isActive' => false]
);

/** getAllCleaned */
$result[] = test(
    $flex->getAllCleaned() === $array,
    $flex->createBy('persons')->createBy('mike_shepard')->getAllCleaned() !== $array['persons']['mike_shepard'],
    $flex->createBy('persons')->createBy('john_doe')->getAllCleaned() === $array['persons']['john_doe']
);

/** getFirst */
$result[] = test(
    $flex->getFirst() == $array[0],
    $flex->createBy('persons')->getFirst() === $array['persons']['john_doe']
);

/** getFirstKey */
$result[] = test(
    $flex->getFirstKey() === 0,
    $flex->createBy('persons')->getFirstKey() === 'john_doe'
);

/** getLast */
$result[] = test(
    $flex->getLast() == $array['persons'],
    $flex->createBy('persons')->getLast() === $array['persons']['mike_shepard']
);

/** getLastKey */
$result[] = test(
    $flex->getLastKey() === 'persons',
    $flex->createBy('persons')->getLastKey() === 'mike_shepard'
);

/** getByIndex */
$result[] = test(
    $flex->getByIndex(0) === $array[0],
    $flex->getByIndex(2) === $array['persons'],
    $flex->getByIndex(7) === null,
    $flex->createBy('fruits')->getByIndex(0) === 'apple',
    $flex->createBy('fruits')->getByIndex(3) === null
);

/** getKeyOfIndex */
$result[] = test(
    $flex->getKeyOfIndex(0) === 0,
    $flex->getKeyOfIndex(1) === 'fruits',
    $flex->getKeyOfIndex(23) === null
);

/** getUpTo */
$result[] = test(
    $flex->getUpTo(2) === $array,
    $flex->getUpTo(123) === $array,
    $flex->getUpTo(0) === [$array[0]]

);

/** implodeAll */
$result[] = test(
    $flex->implodeAll(',') === "0,1,2,3,5,apple,orange,John Doe,bmw,audi,1,some description,Mike Shepard,,",
    $flex->implodeAll(',', true) === "0: 0,1: 1,2: 2,3: 3,4: 5,0: apple,1: orange,name: John Doe,0: bmw,1: audi,isActive: 1,comment: some description,name: Mike Shepard,,isActive: "
);

/** implode */
$result[] = test(
    $flex->implode(',') === "",
    $flex->implode(',', true) === "",
    $flex->createBy('persons')->createByFirst()->implode(',', true) === "name: John Doe,isActive: 1,comment: some description",
    $flex->createBy('persons')->createByLast()->implode(',', true) === "name: Mike Shepard,isActive: "
);

/** implodeKeys */
$result[] = test($flex->implodeKeys(',') === "0,fruits,persons");

/** count */
$result[] = test(
    $flex->count() === count($array),
    $flex->createByFirst()->count() === count($array[0])
);

/** keyOf */
$result[] = test(
    $flex->keyOf('fruits') === null,
    $flex->keyOf(['apple', 'orange']) === 'fruits'
);

/** keysOf */
$result[] = test(
    $flex->keysOf('fruits') === [],
    $flex->keysOf(['apple', 'orange']) === ['fruits']
);

/** indexOf */
$result[] = test(
    $flex->indexOf('fruits') === null,
    $flex->indexOf(['apple', 'orange']) === 1
);

/** indexesOf */
$result[] = test(
    $flex->indexesOf('fruits') === [],
    $flex->indexesOf(['apple', 'orange']) === [1]
);

/** binarySearch */
$result[] = test(
    $flex->binarySearch(0) === null,
    $flex->createByFirst()->binarySearch(3) === 3
);

/** binarySearch */
$result[] = test(
    $flex->binarySearch(0) === null,
    $flex->createByFirst()->binarySearch(5) === 4
);

/** toJson */
$result[] = test($flex->toJson() === json_encode($array));

/** touch */
$result[] = test(
    $flex->touch() === [],
    $flex->touch(0, 'fruits', 'apples') === array_merge([], [$array[0]], ['fruits' => $array['fruits']]),
    $flex->createBy('persons')->createByLast()->touch('isActive', 'description') === []
);

/** findValues */
$result[] = test(
    $flex->findValues(['apple', 'orange'], 'apple', 'orange') === ['fruits'=>['apple', 'orange']],
    $flex->createBy('persons')->createByFirst()->findValues(true) === ['isActive' => true],
    $flex->createBy('persons')->createByFirst()->findValues('true') === []
);

/** print result  */
echo implode('', $result);
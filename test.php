<?php

use sitnikovik\FlexArray\FlexArray;

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

/** indexOfKey */
$result[] = test(
    $flex->indexOfKey('fruits') === 1,
    $flex->indexOfKey(1) === null
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


/** ############# SETTERS ################ */

/** set */
$result[] = test($flex->set('fruits', 'apple')->get('fruits') === 'apple');

/** prepend */
$flex = new FlexArray($array);
$result[] = test($flex->prepend('apple')->getAll() === array_merge([], ['apple'], $array));

/** append */
$flex = new FlexArray($array);
$result[] = test($flex->append('apple')->getAll() === array_merge([], $array, ['apple']));

/** delete */
$flex = new FlexArray($array);
$_array = $array;
unset($_array['fruits']);
$result[] = test($flex->delete('fruits')->getAll() === $_array);

/** deleteOnFound */
$flex = new FlexArray($array);
$result[] = test(
    $flex->deleteOnFound(['apple', 'orange'])->getAll() === $_array,
    $flex->deleteOnFound('apple')->getAll() === $_array
);

/** deleteFirst */
$flex = new FlexArray($array);
$_array = $array;
unset($_array[0]);
$result[] = test($flex->deleteFirst()->getAll() === $_array);

/** deleteLast */
$flex = new FlexArray($array);
$_array = $array;
unset($_array['persons']);
$result[] = test($flex->deleteLast()->getAll() === $_array);

/** deleteByIndex */
$flex = new FlexArray($array);
$_array = $array;
unset($_array[0]);
$result[] = test(
    $flex->deleteByIndex(0)->getAll() === $_array,
    $flex->deleteByIndex(123)->getAll() === $_array
);

/** deleteAll */
$flex = new FlexArray($array);
$result[] = test($flex->deleteAll()->getAll() === []);

/** flip */
$flex = new FlexArray($array);
$_array = array_flip($array['fruits']);
$result[] = test($flex->createBy('fruits')->flip()->getAll() === $_array);

/** merge */
$flex = new FlexArray($array);
$_array = array_merge($array, ['cars' => ['bmw', 'audi']]);
$result[] = test($flex->merge(['cars' => ['bmw', 'audi']])->getAll() === $_array);

/** unique */
$flex = new FlexArray($array);
$_array = array_unique($array[0]);
$result[] = test($flex->createByFirst()->unique()->getAll() === $_array);

/** sort */
$flex = new FlexArray($array);
$_array = $array;
sort($_array);
$result[] = test($flex->sort()->getAll() === $_array);

/** rsort */
$flex = new FlexArray($array);
$_array = $array;
rsort($_array);
$result[] = test($flex->rsort()->getAll() === $_array);

/** ksort */
$flex = new FlexArray($array);
$_array = $array;
ksort($_array);
$result[] = test($flex->ksort()->getAll() === $_array);

/** krsort */
$flex = new FlexArray($array);
$_array = $array;
krsort($_array);
$result[] = test($flex->krsort()->getAll() === $_array);

/** asort */
$flex = new FlexArray($array);
$_array = $array;
asort($_array);
$result[] = test($flex->asort()->getAll() === $_array);

/** arsort */
$flex = new FlexArray($array);
$_array = $array;
arsort($_array);
$result[] = test($flex->arsort()->getAll() === $_array);

/** clean */
$flex = new FlexArray($array);
$result[] = test(
    $flex->clean()->getAll() === $_array,
    $flex->createByFirst()->clean()->getAll() === [0, 1, 2, 3, 5],
    $flex->createBy('persons')->createBy('mike_shepard')->clean()->getAll() === ['name' => 'Mike Shepard',]
);

/** ############## FACTORIES ################# */
$flex = new FlexArray($array);

/** createBy */
$_flex = new FlexArray($array['persons']);
$result[] = test(
    $flex->createBy('persons')->getAll() === $_flex->getAll(),
    $flex->createBy('john_doe')->getAll() === []
);

/** createByFirst */
$_flex = new FlexArray($array[0]);
$result[] = test($flex->createByFirst()->getAll() === $_flex->getAll());

/** createByLast */
$_flex = new FlexArray($array['persons']);
$result[] = test($flex->createByLast()->getAll() === $_flex->getAll());

/** createByIndex */
$_flex = new FlexArray($array['fruits']);
$result[] = test($flex->createByIndex(1)->getAll() === $_flex->getAll());

/** ############## PREDICATES ############ */

/** isEmpty */
$result[] = test(
    $flex->isEmpty('fruits') === false,
    $flex->isEmpty(1) === true,
    $flex->createBy('persons')->createBy('mike_shepard')->isEmpty('comment') === true,
    $flex->createBy('persons')->createBy('mike_shepard')->isEmpty('isActive') === true
);

/** keyExists */
$result[] = test(
    $flex->keyExists('fruits') === true,
    $flex->keyExists(1) === false,
    $flex->createBy('persons')->createBy('mike_shepard')->keyExists('comment') === true,
    $flex->createBy('persons')->createBy('mike_shepard')->keyExists('isActive') === true
);

/** hasKeys */
$result[] = test(
    $flex->hasKeys('fruits', 1) === false,
    $flex->hasKeys('fruits', 'persons') === true,
    $flex->hasKeys('fruits', 1, 'persons') === false
);

/** hasAnyKey */
$result[] = test(
    $flex->hasAnyKey('fruits', 1) === true,
    $flex->hasAnyKey('fruits', 'persons') === true
);

/** hasValues */
$result[] = test(
    $flex->hasValues(['apple', 'orange']) === true,
    $flex->hasValues(['apple', 'orange'], 'persons') === false,
    $flex->hasValues('0', ['apple', 'orange'], 'persons') === false
);

/** hasAnyValue */
$result[] = test(
    $flex->hasAnyValue(['apple', 'orange']) === true,
    $flex->hasAnyValue(['apple', 'orange'], 'persons') === true,
    $flex->hasAnyValue('0', ['apple', 'orange'], 'persons') === true,
    $flex->hasAnyValue(['apple', 'oranges'], 'persons') === false
);

/** inCount */
$result[] = test(
    $flex->inCount(1) === true,
    $flex->inCount(3) === true,
    $flex->inCount(4) === false,
    $flex->inCount(-1) === true,
    $flex->inCount(-4) === false
);

/** assertEqualsByKey */
$result[] = test(
    $flex->assertEqualsByKey('fruits', ['apple', 'orange']) === true,
    $flex->assertEqualsByKey(0, ['apple', 'orange']) === false,
    $flex->assertEqualsByKey('apple', null) == true
);

/** assertAnyEqualsByKey */
$result[] = test(
    $flex->assertAnyEqualsByKey('fruits', ['apple'], ['apple', 'orange']) === true,
    $flex->assertAnyEqualsByKey('fruits', ['apple'], ['apple', 'oranges']) === false
);


/** print result  */
echo implode('', $result);
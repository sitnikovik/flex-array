# Introduction
Make your array usage quite easy and fast.

---

# Get started
You have to provide you array to constructor and after that you can do a lot of operations on haystack via class methods.

```php
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

// Making FlexArray.
$array = new FlexArray($array);
```

--------------------

# Available methods

## Getters
* [get](#get)
* [getAll](#getAll)
* [getKeys](#getkeys)
* [getAllBut](#getallbut)
* [getAllIntegers](#getallintegers)
* [getAllStrings](#getallstrings)
* [getAllBooleans](#getallbooleans)
* [getAllCleaned](#getallcleaned)
* [getFirst](#getfirst)
* [getFirstKey](#getfirstkey)
* [getLast](#getlast)
* [getLastKey](#getlastkey)
* [getByIndex](#getbyindex)
* [getKeyOfIndex](#getkeyofindex)
* [getUpTo](#getupto)
* [implodeAll](#implodeall)
* [implode](#implode)
* [implodeKeys](#implodekeys)
* [count](#count)
* [keyOf](#keyof)
* [keysOf](#keysof)
* [indexOf](#indexof)
* [indexesOf](#indexesof)
* [binarySearch](#binarysearch)
* [toJson](#tojson)
* [touch](#touch)
* [findValues](#findvalues)

## Setters
* [set](#set)
* [prepend](#prepend)
* [append](#append)
* [delete](#delete)
* [deleteOnFound](#deleteonfound)
* [deleteFirst](#deletefirst)
* [deleteLast](#deletelast)
* [deleteByIndex](#deletebyindex)

## Modifiers
* [flip](#flip)
* [merge](#merge)
* [unique](#unique)
* [sort](#sort)
* [rsort](#rsort)
* [ksort](#ksort)
* [krsort](#krsort)
* [asort](#asort)
* [arsort](#arsort)
* [clean](#clean)

## Factories
* [createBy](#createby)
* [createByFirst](#createbyfirst)
* [createByLast](#createbylast)
* [createByIndex](#createbyindex)

# Predicates
* [isEmpty](#isEmpty)
* [keyExists](#keyexists)
* [hasKeys](#haskeys)
* [hasAnyKey](#hasanykey)
* [hasValues](#hasvalues)
* [hasAnyValue](#hasanyvalue)
* [inCount](#incount)
* [assertEqualsByKey](#assertequalsbykey)
* [assertAnyEqualsByKey](#assertanyequalsbykey)


--------------------

# Describing methods

## Getters ###################

--------------------

### get
```php
get(int|string $key, mixed $default = null): mixed
```
Returns value from haystack by `$key` or `$default` (*null* on default) on not set.

### getAll
```php
getAll(): array
```
Returns haystack as array.

### getKeys
```php
getKeys(): array
```
Return keys of the haystack.

### getAllBut
```php
getAllBut(int|string ...$keys): array
```
Returns list of haystack values but provided in `$keys`.

### getAllIntegers
```php
getAllIntegers(): array
```
Returns list of integer values indexed by its keys.

### getAllStrings ###
```php
getAllStrings(): array
```
Returns list of string values indexed by its keys.

### getAllBooleans
```php
getAllBooleans(): array
```
Returns list of boolean values indexed by its keys.

### getAllCleaned
```php
getAllClean(): array
```
Returns the haystack of not real empty values.

### getFirst
```php
getFirst(): mixed
```
Returns the first element.

### getFirstKey
```php
getFirstKey(): int|string|null
```
Returns first key of the haystack or null on empty haystack.

### getLast
```php
getLast(): mixed
```
Returns the last element.

### getLastKey
```php
getLastKey(): int|string|null
```
Returns last key of the haystack or null on empty haystack.

### getByIndex
```php
getByIndex(int $index): mixed
```
Returns value by index or nul if `$index` is not in haystack length. Pass negative number for reverse search.

### getKeyOfIndex
```php
getKeyOfIndex(int $index): int|string|null
```
Returns key of integer index in the haystack or nul if `$index` is not in haystack length. Pass negative number for reverse search.

### getUpTo 
```php
getUpTo(int $index): array
```
Return values up to `$index`. Pass negative number for reverse search.

### implodeAll
```php
implodeAll(string $separator, bool $associative = false): string
```
Returns array values imploded to string recursively.
Pass `true` in `$associative` to represent in indexed by its keys.

### implode
```php
implode(string $separator, bool $associative = false): string
```
Returns only scalar values in the haystack as string.
Pass `true` in `$associative` to represent in indexed by its keys.

### implodeKeys
```php
implodeKeys(string $separator): string
```
Returns haystack keys as string.

### count
```php
count(): int
```
Returns the haystack length.

### keyOf
```php
keyOf(int|string $key): int|string|null
```
Returns key of value in the haystack or `null` on found.

### keysOf
```php
keysOf(int|string $key): array
```
Returns list of keys for haystack values.

### indexOf
```php
indexOf(mixed $needle): int|null
```
Returns integer index of value or `null` on not found.

### indexesOf
```php
indexesOf(mixed $needle): array
```
Returns list of integer indexes of provided values.

### binarySearch
```php
binarySearch(int $needle): int|null
```
Binary search method for integer value in haystack.
Sorts the haystack due the process.
Returns the integer index of value on found or null on not.

### toJson
```php
toJson(): string
```
Represents haystack in JSON string content. Trows `Exception` on decode error.

### touch
```php
touch(int|string ...$keys): array
```
Returns only scalar values in the haystack as string.
Pass `true` in `$associative` to represent in indexed by its keys.

### findValues
```php
findValues(mixed ...$values): array
```
Returns list of found values associated with found keys in haystack.

## Setters ########################
___

### set
```php
set(int|string $key, mixed $value): self
```
Sets value by `$key`.

### prepend
```php
prepend(mixed $value): self
```
Adds value to haystack to the top of haystack.

### append
```php
append(mixed $value): self
```
Adds value to haystack in the end.

### delete
```php
delete(int|string $key): self
```
Deletes value by `$key`.

### deleteOnFound
```php
deleteOnFound(mixed ...$values): self
```
Remove haystack elements by values if exists.

### deleteFirst
```php
deleteFirst(): self
```
Deletes the first element.

### deleteLast
```php
deleteLast(): self
```
Deletes the last element.

### deleteByIndex
```php
deleteByIndex(int|string $key): self
```
Deletes element by index.

### deleteAll
```php
deleteAll(): self
```
Delete all values and sets empty array to haystack.

## Modifiers ########################
___

### flip
```php
flip(): self
```
Flips the haystack.

### merge
```php
merge(array ...$arrays): self
```
Merges the elements of one or more arrays together.

### unique
```php
unique(int $flags = SORT_STRING): self
```
Returns haystack keys as string.

Available flags
* SORT_REGULAR - compare items normally (don't change types)
* SORT_NUMERIC - compare items numerically
* SORT_STRING - compare items as strings
* SORT_LOCALE_STRING - compare items as strings, based on the current locale.

### sort
```php
sort(int $flags = SORT_REGULAR): self
```
Sort haystack.

Available flags
* SORT_REGULAR - compare items normally; the details are described in the comparison operators section
* SORT_NUMERIC - compare items numerically
* SORT_STRING - compare items as strings
* SORT_LOCALE_STRING - compare items as strings, based on the current locale. It uses the locale, which can be changed using `setlocale()`
* SORT_NATURAL - compare items as strings using "natural ordering" like `natsort()`
* SORT_FLAG_CASE - can be combined (bitwise OR) with SORT_STRING or SORT_NATURAL to sort strings case-insensitively

### rsort
```php
rsort(int $flags = SORT_REGULAR): self
```
Sort haystack in reverse order.

  Available flags
* SORT_REGULAR - compare items normally; the details are described in the comparison operators section
* SORT_NUMERIC - compare items numerically
* SORT_STRING - compare items as strings
* SORT_LOCALE_STRING - compare items as strings, based on the current locale. It uses the locale, which can be changed using `setlocale()`
* SORT_NATURAL - compare items as strings using "natural ordering" like `natsort()`
* SORT_FLAG_CASE - can be combined (bitwise OR) with SORT_STRING or SORT_NATURAL to sort strings case-insensitively

### ksort
```php
ksort(int $flags = SORT_REGULAR): self
```
Sort the haystack by keys.

Available flags
* SORT_REGULAR - compare items normally; the details are described in the comparison operators section
* SORT_NUMERIC - compare items numerically
* SORT_STRING - compare items as strings
* SORT_LOCALE_STRING - compare items as strings, based on the current locale. It uses the locale, which can be changed using `setlocale()`
* SORT_NATURAL - compare items as strings using "natural ordering" like `natsort()`
* SORT_FLAG_CASE - can be combined (bitwise OR) with SORT_STRING or SORT_NATURAL to sort strings case-insensitively

### krsort
```php
krsort(int $flags = SORT_REGULAR): self
```
Sort the haystack by keys in reverse order.

Available flags
* SORT_REGULAR - compare items normally; the details are described in the comparison operators section
* SORT_NUMERIC - compare items numerically
* SORT_STRING - compare items as strings
* SORT_LOCALE_STRING - compare items as strings, based on the current locale. It uses the locale, which can be changed using `setlocale()`
* SORT_NATURAL - compare items as strings using "natural ordering" like `natsort()`
* SORT_FLAG_CASE - can be combined (bitwise OR) with SORT_STRING or SORT_NATURAL to sort strings case-insensitively

### asort
```php
asort(int $flags = SORT_REGULAR): self
```
Sort an array and maintain index association.

Available flags
* SORT_REGULAR - compare items normally; the details are described in the comparison operators section
* SORT_NUMERIC - compare items numerically
* SORT_STRING - compare items as strings
* SORT_LOCALE_STRING - compare items as strings, based on the current locale. It uses the locale, which can be changed using `setlocale()`
* SORT_NATURAL - compare items as strings using "natural ordering" like `natsort()`
* SORT_FLAG_CASE - can be combined (bitwise OR) with SORT_STRING or SORT_NATURAL to sort strings case-insensitively

### arsort
```php
arsort(int $flags = SORT_REGULAR): self
```
Sort an array and maintain index association in reverse order.

Available flags
* SORT_REGULAR - compare items normally; the details are described in the comparison operators section
* SORT_NUMERIC - compare items numerically
* SORT_STRING - compare items as strings
* SORT_LOCALE_STRING - compare items as strings, based on the current locale. It uses the locale, which can be changed using `setlocale()`
* SORT_NATURAL - compare items as strings using "natural ordering" like `natsort()`
* SORT_FLAG_CASE - can be combined (bitwise OR) with SORT_STRING or SORT_NATURAL to sort strings case-insensitively

### clean
```php
clean(): self
```
Cleans real empty values in the haystack.

## Factories ##############################
___

### createBy
```php
createBy(int|string $key): self
``` 
Creates and returns inner collection (`new static()`) by `$key` if indexed value in the haystack is array. Otherwise, collection with empty haystack returns. Now, inner array is available to processed with all described methods.

### createByFirst
```php
createByFirst(): self
```
Creates class object by first element.

### createByLast
```php
createByLast(): self
```
Creates class object by last element.

### createByIndex
```php
createByIndex(): self
```
Creates class object by element located by index. Pass negative number to get it in reverse order.

## Predicates ###############

---

### isEmpty
```php
isEmpty(int|string $key): bool
```
Defines if value by `$key` exists and is not empty

### keyExists
```php
keyExists(int|string $key): bool
```
Defines if the given key or index exists in the haystack even nullable.

### hasKeys
```php
hasKeys(mixed ...$keys): bool
```
Defines if all provided keys exists.

### hasAnyKey
```php
hasAnyKey(mixed ...$keys): bool
```
Defines if the haystack has any value (even nullable) indexed by keys provided.

### hasValues
```php
hasValues(mixed ...$values): bool
```
Defines if the haystack has any value provided.

### hasAnyValue
```php
hasAnyValue(mixed ...$values): bool
```
Defines if the haystack has any value provided.

### inCount
```php
inCount(int ...$count): bool
```
Defines if the haystack length in provided value.

### assertEqualsByKey
```php
assertEqualsByKey(int|string $key, mixed ...$values): bool
```
Asserts if each value identically equals the value in the haystack by key.

### assertAnyEqualsByKey
```php
assertAnyEqualsByKey(int|string $key, mixed ...$values): bool
```
Asserts if any value identically equals the value in the haystack by key.
# FlexArray
 Make your array usage quite easy and fast.

---

## Get started
You have to provide you array to constructor and after that you can do a lot of operations on haystack via class methods.

```php
// Some array to be processed.
$array = [
    [0, 1, 2, 3],
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
## Available methods

* [createBy](#createby) 
* [get](#get)
* [getKeys](#getkeys)
* [getAll](#getAll)
* [getAllBut](#getallbut)
* [getAllIntegers](#getallintegers) 
* [getAllStrings](#getallstrings)
* [getAllBooleans](#getallbooleans)
* [implodeAll](#implodeall)
* [implode](#implode)
* [implodeKeys](#implodekeys)
* [flip](#flip)
* [merge](#merge)
* [unique](#unique)
* [sort](#sort)
* [rsort](#rsort)
* [ksort](#ksort)
* [krsort](#krsort)
* [asort](#asort)
* [arsort](#arsort)
* [touch](#touch)

### createBy
```php
createBy(int|string $key): self
``` 
Creates and returns inner collection (`new static()`) by `$key` if indexed value in the haystack is array. Otherwise, collection with empty haystack returns. Now, inner array is available to processed with all described methods.

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

### count
```php
count(): int
```
Returns the haystack length.

### set
```php
set(int|string $key, mixed $value): self
```
Sets value by `$key`.

### append
```php
append(mixed $value): self
```
Append value to haystack in the end.

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

### touch
```php
touch(int|string ...$keys): array
```
Returns only scalar values in the haystack as string.
Pass `true` in `$associative` to represent in indexed by its keys.

  * `::touch(int|string ...$keys): array` Returns list of keys of not real empty values.
  * `::binarySearch(int $needle): int` Binary search method for integer value in haystack. Returns the integer index of value on found or `-1` on not.
* Modifiers
  * `::set(int|string $key, mixed $value): self` Sets `$value` to haystack by `$key`.
  * `::delete(int|string $key): self` Deletes value from haystack by `$key`.
* Predicates
  * `::hasKeys(int|string ...$keys): bool` Defines if all provided keys exists.
  * `::hasAnyKey(int|string ...$keys): bool` Defines if the haystack has any value (even nullable) indexed by keys provided.
  * `::hasValues(int|string ...$keys): bool` Defines if all provided values exists in the haystack.
  * `::hasAnyValue(int|string ...$keys): bool` Defines if the haystack has any value (even nullable) indexed by keys provided.
  * `::touchable(int|string $key): bool` Defines if value by `$key` exists and is not empty
  * `::exists(int|string $key): bool` Defines if the given key or index exists in the haystack even nullable.

### Trying represented array
```
   
```




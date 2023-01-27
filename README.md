# FlexArray
 Make your array usage quite easy and fast.

---

## Get started
You have to provide you array to constructor and after that you can do a lot of operations on haystack via class methods.

```
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

// Making Collection.
$collection = new Collection($array);
```

## Usage

### Available methods
* Getters
  * `::get(int|string $key, mixed $default = null): mixed` Returns value from haystack by `$key` or `$default` (*null* on default) on not set.
  * `::all(): array` Returns haystack as array
  * `::allBut(int|string ...$keys): array` Returns list of haystack values but provided in `$keys`. 
  * `::implodeAll(string $separator, bool $associative = false): string` Returns array values imploded to string recursively. Pass `true` in `$associative` to represent in indexed by its keys.
  * `::touch(int|string ...$keys): array` Returns list of keys of not real empty values.
  * `::has(int|string ...$keys): array`  Returns list of keys of set values even nullable.
  * `::binarySearch(int $needle): int` Binary search method for integer value in haystack. Returns the integer index of value on found or `-1` on not.
  * `::createBy(int|string $key): mixed` Creates and returns inner collection (`new static()`) by `$key` if indexed value in the haystack is array. Otherwise, collection with empty haystack returns. Now, inner array is available to processed with all described methods.
* Modifiers
  * `::set(int|string $key, mixed $value): self` Sets `$value` to haystack by `$key`.
  * `::delete(int|string $key): self` Deletes value from haystack by `$key`.
* Predicates
  * `::touchable(int|string $key): bool` Defines if value by `$key` exists and is not empty
  * `::exists(int|string $key): bool` Defines if the given key or index exists in the haystack even nullable.

### Trying represented array
```
   
```




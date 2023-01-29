<?php

namespace sitnikovik\FlexArray;

use Exception;
use RuntimeException;

class FlexArray
{
    /**
     * Array to be processed.
     *
     * @var array
     */
    protected $haystack;

    /**
     * @param array $haystack
     */
    public function __construct(array $haystack)
    {
        $this->haystack = $haystack;
    }

    /**
     * ############################################# GETTERS ####################################################
     */

    /**
     * Returns value by `$key`.
     *
     * If value not exists the `$default` returns.
     *
     * @param string|int $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return isset($this->haystack[$key]) ? $this->haystack[$key] : $default;
    }

    /**
     * Returns the haystack.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->haystack;
    }

    /**
     * Return keys of the haystack.
     *
     * @return int[]|string[]
     */
    public function getKeys()
    {
        return array_keys($this->getAll());
    }

    /**
     * Returns all haystack values but declared in `$keys`
     *
     * @param int|string ...$keys
     * @return array
     */
    public function getAllBut(...$keys)
    {
        $haystack = $this->haystack;
        foreach ($keys as $arg) {
            if (isset($haystack[$arg])) {
                unset($haystack[$arg]);
            }
        }

        return $haystack;
    }

    /**
     * Returns list of integer values indexed by its keys.
     *
     * @return array
     */
    public function getAllIntegers()
    {
        $filtered = [];
        foreach ($this->getAll() as $key => $value) {
            if (is_integer($value)) {
                $filtered[$key] = $value;
            }
        }

        return $filtered;
    }

    /**
     * Returns list of string values indexed by its keys.
     *
     * @return array
     */
    public function getAllStrings()
    {
        $filtered = [];
        foreach ($this->getAll() as $key => $value) {
            if (is_string($value)) {
                $filtered[$key] = $value;
            }
        }

        return $filtered;
    }

    /**
     * Returns list of boolean values indexed by its keys.
     *
     * @return array
     */
    public function getAllBooleans()
    {
        $filtered = [];
        foreach ($this->getAll() as $key => $value) {
            if (is_bool($value)) {
                $filtered[$key] = $value;
            }
        }

        return $filtered;
    }

    /**
     * Returns the haystack of not real empty values.
     *
     * @return array
     */
    public function getAllCleaned()
    {
        $isEmpty = [];
        foreach ($this->getAll() as $key => $value) {
            if (!$this->isEmpty($key)) {
                $isEmpty[$key] = $value;
            }
        }

        return $isEmpty;
    }

    /**
     * Returns the first element.
     *
     * @return mixed
     */
    public function getFirst()
    {
        return $this->haystack[$this->getFirstKey()];
    }

    /**
     * Returns first key of the haystack or null on empty haystack.
     *
     * @return int|string|null
     */
    public function getFirstKey()
    {
        foreach ($this->haystack as $key => $value) {
            return $key;
        }

        return null;
    }

    /**
     * Returns the last element.
     *
     * @return mixed
     */
    public function getLast()
    {
        return $this->haystack[$this->getLastKey()];
    }

    /**
     * Returns last key of the haystack.
     *
     * @return int|string|null
     */
    public function getLastKey()
    {
        $count = $this->count();
        $i = 1;

        foreach ($this->haystack as $key => $value) {
            if ($i === $count) {
                return $key;
            }
            $i++;
        }

        return null;
    }

    /**
     * Returns value by index.
     *
     * Pass negative number for reverse search.
     *
     * @param $index
     * @return mixed|null
     */
    public function getByIndex($index)
    {
        if (!$this->inCount($index)) {
            return null;
        }

        $i = 0;
        $haystack = ($index >= 0) ? $this->getAll() : array_reverse($this->getAll());

        foreach ($haystack as $value) {
            if ($i === $index) {
                return $value;
            }
            $i = ($index >= 0) ? $i + 1 : $i - 1;
        }

        return null;
    }

    /**
     * Returns values up to `$index`.
     *
     * @param int $index
     * @return array
     */
    public function getUpTo($index)
    {
        $i = 0;
        $haystack = ($index >= 0) ? $this->getAll() : array_reverse($this->getAll());
        $values = [];

        foreach ($haystack as $key => $value) {
            $condition = ($index >= 0) ? ($i <= $index) : ($i >= $index);
            if ($condition) {
                $values[$key] = $value;
                $i = ($index >= 0) ? $i + 1 : $i - 1;
            } else {
                break;
            }
        }

        return $values;
    }

    /**
     * Represents the haystack and all its values (only if it is not iterable in string).
     *
     * Pass `true` in `$associative` to represent in indexed by its keys.
     *
     * @param string $separator
     * @param bool $associative
     * @return string
     */
    public function implodeAll($separator, $associative = false)
    {
        $result = [];
        foreach ($this->haystack as $key => $value) {
            $value = (is_object($value))
                ? (array)$value
                : $value;

            $result[] = (!is_array($value))
                ? (($associative) ? sprintf('%s: %s', $key, $value) : $value)
                : self::join($separator, $value, $associative);
        }

        return implode($separator, $result);
    }

    /**
     * Returns only scalar values in the haystack as string.
     *
     * Pass `true` in `$associative` to represent in indexed by its keys.
     *
     * @param string $separator
     * @param bool $associative
     * @return string
     */
    public function implode($separator, $associative = false)
    {
        $strings = [];
        foreach ($this->haystack as $key => $value) {
            if (is_scalar($value)) {
                $strings[] = ($associative)
                    ? sprintf('%s: %s', $key, $value)
                    : $value;
            }
        }

        return implode($separator, $strings);
    }

    /**
     * Returns haystack keys as string.
     *
     * @param string $separator
     * @return string
     */
    public function implodeKeys($separator)
    {
        return implode($separator, $this->getKeys());
    }

    /**
     * Returns the haystack length.
     *
     * @return int
     */
    public function count()
    {
        return count($this->haystack);
    }

    /**
     * Returns key of value in the haystack or null on found.
     *
     * @param mixed $needle
     * @return int|string|null
     */
    public function keyOf($needle)
    {
        foreach ($this->haystack as $key => $value) {
            if ($value === $needle) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Returns list of keys for haystack values.
     *
     * @param mixed ...$needles
     * @return array
     */
    public function keysOf(...$needles)
    {
        $keys = [];
        foreach ($this->haystack as $key => $value) {
            if (in_array($value, $needles)) {
                $keys[] = $key;
            }
        }

        return $keys;
    }

    /**
     * Returns integer index of value.
     *
     * @param mixed $needle
     * @return int|null
     */
    public function indexOf($needle)
    {
        $i = 0;
        foreach ($this->haystack as $value) {
            if ($value === $needle) {
                return $i;
            }
            $i++;
        }

        return null;
    }

    /**
     * Returns list of integer indexes of provided values.
     *
     * @param mixed ...$needles
     * @return array
     */
    public function indexesOf(...$needles)
    {
        $i = 0;
        $indexes = [];
        foreach ($this->haystack as $value) {
            if (in_array($value, $needles)) {
                $indexes[] = $i;
            }
            $i++;
        }

        return $indexes;
    }

    /**
     * Return integer index of key.
     *
     * @param int|string $needle
     * @return int|null
     */
    public function indexOfKey($needle)
    {
        $i = 0;
        foreach ($this->haystack as $key => $value) {
            if ($key === $needle) {
                return $i;
            }
            $i++;
        }

        return null;
    }

    /**
     * Returns key of integer index in the haystack or `null` on not found.
     *
     * @param int $index
     * @return int|string|null
     */
    public function getKeyOfIndex($index)
    {
        if (!$this->inCount($index)) {
            return null;
        }

        $haystack = ($index < 0) ? array_reverse($this->getAll()) : $this->getAll();
        $i = 0;

        foreach ($haystack as $key => $value) {
            if ($i === $index) {
                return $key;
            }
            $i = ($index < 0) ? $i - 1 : $i + 1;
        }

        return null;
    }

    /**
     * Binary search method for integer value in haystack.
     *
     * Sorts the haystack due the process.
     *
     * Returns the integer index of value on found or null on not.
     *
     * | Note that it works only with integer values.
     *
     * @param int $needle
     * @return int|null
     */
    public function binarySearch($needle)
    {
        if (empty($this->haystack)) {
            return null;
        }

        $haystack = $this->haystack;
        sort($haystack);

        $len = count($this->haystack);
        $lower = 0;
        $high = $len - 1;
        while ($lower <= $high) {
            $middle = intval(($lower + $high) / 2);
            if ($haystack[$middle] > $needle) {
                $high = $middle - 1;
            } else if ($haystack[$middle] < $needle) {
                $lower = $middle + 1;
            } else {
                return $middle;
            }
        }

        return null;
    }

    /**
     * Implodes `$haystack`.
     *
     * Pass `true` in `$associative` to represent in indexed by its keys.
     *
     * @param $separator
     * @param $haystack
     * @param bool $associative
     * @return string
     */
    private static function join($separator, $haystack, $associative = false)
    {
        $string = [];
        foreach ($haystack as $key => $value) {
            if (!is_scalar($value) && !is_array($value)) {
                continue;
            }
            $string[] = (is_scalar($value))
                ? (($associative) ? sprintf('%s: %s', $key, $value) : $value)
                : self::join($separator, $value, $associative);
        }

        return implode($separator, $string);
    }

    /**
     * Represents haystack in JSON string content.
     *
     * @return string
     * @throws Exception
     */
    public function toJson()
    {
        $haystack = $this->getAll();

        $json = json_encode($haystack);
        if ($json === false) {
            throw new RuntimeException('JSON encoding failed');
        }

        return $json;
    }

    /**
     * Returns list of keys of not real empty values.
     *
     * @param int|string ...$keys
     * @return array
     */
    public function touch(...$keys)
    {
        $filtered = [];

        foreach ($keys as $key) {
            if (!$this->isEmpty($key)) {
                $filtered[$key] = $this->get($key);
            }
        }

        return $filtered;
    }

    /**
     * Returns list of found values associated with found keys in haystack.
     *
     * @param mixed ...$values
     * @return array
     */
    public function findValues(...$values)
    {
        $filtered = [];
        foreach ($values as $value) {
            foreach ($this->haystack as $key => $_value) {
                if ($value === $_value) {
                    $filtered[$key] = $_value;
                }
            }
        }

        return array_unique($filtered);
    }

    /**
     * ############################################# SETTERS ####################################################
     */

    /**
     * Sets value by `$key`.
     *
     * @param string|int $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->haystack[$key] = $value;

        return $this;
    }

    /**
     * Adds value to haystack to the top of haystack.
     *
     * @param mixed $value
     * @return $this
     */
    public function prepend($value)
    {
        array_unshift($this->haystack, $value);

        return $this;
    }

    /**
     * Adds value to haystack in the end.
     *
     * @param mixed $value
     * @return $this
     */
    public function append($value)
    {
        $this->haystack[] = $value;

        return $this;
    }

    /**
     * Deletes value by `$key`.
     *
     * @param int|string $key
     * @return $this
     */
    public function delete($key)
    {
        unset($this->haystack[$key]);

        return $this;
    }

    /**
     * Remove haystack elements by values if exists.
     *
     * @param mixed ...$values
     * @return $this
     */
    public function deleteOnFound(...$values)
    {
        $haystack = $this->getAll();

        foreach ($values as $needle) {
            foreach ($haystack as $key => $value) {
                if ($needle === $value) {
                    $this->delete($key);
                }
            }
        }

        return $this;
    }

    /**
     * Deletes the first element.
     *
     * @return $this
     */
    public function deleteFirst()
    {
        $this->delete($this->getFirstKey());

        return $this;
    }

    /**
     * Deletes the last element.
     *
     * @return $this
     */
    public function deleteLast()
    {
        $this->delete($this->getLastKey());

        return $this;
    }

    /**
     * Deletes element by index.
     *
     * @param int $index
     * @return $this
     */
    public function deleteByIndex($index)
    {
        if (!$this->inCount($index)) {
            return $this;
        }

        $i = 0;
        $haystack = ($index >= 0) ? $this->getAll() : array_reverse($this->getAll());

        foreach ($haystack as $key => $value) {
            if ($i === $index) {
                unset($this->haystack[$key]);
                break;
            }
            $i = ($index >= 0) ? $i + 1 : $i - 1;
        }

        return $this;
    }

    /**
     * Delete all values and sets empty array to haystack.
     *
     * @return $this
     */
    public function deleteAll()
    {
        $this->haystack = [];

        return $this;
    }

    /**
     * ############################################ MODIFIERS ###################################################
     */

    /**
     * Flips the haystack.
     *
     * Note that it works on integer or string values. Otherwise, it will be slipped and warning be thrown
     * @return $this
     */
    public function flip()
    {
        $this->haystack = array_flip($this->haystack);

        return $this;
    }

    /**
     * Merges the elements of one or more arrays together.
     *
     * @param array $arrays
     * @return $this
     */
    public function merge(...$arrays)
    {
        $this->haystack = array_merge($this->getAll(), ...$arrays);

        return $this;
    }

    /**
     * Removes duplicate values from the haystack.
     *
     * Note that it works with scalar values and PHP warning will be thrown if not.
     *
     * @param int $flags
     * @return $this
     */
    public function unique($flags = SORT_STRING)
    {
        $this->haystack = array_unique($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort haystack.
     *
     * @param $flags
     * @return $this
     */
    public function sort($flags = SORT_REGULAR)
    {
        sort($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort haystack in reverse order.
     *
     * @param $flags
     * @return $this
     */
    public function rsort($flags = SORT_REGULAR)
    {
        rsort($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort the haystack by keys.
     *
     * @param $flags
     * @return $this
     */
    public function ksort($flags = SORT_REGULAR)
    {
        ksort($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort the haystack by keys in reverse order.
     *
     * @param $flags
     * @return $this
     */
    public function krsort($flags = SORT_REGULAR)
    {
        krsort($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort an array and maintain index association.
     *
     * @param $flags
     * @return $this
     */
    public function asort($flags = SORT_REGULAR)
    {
        asort($this->haystack, $flags);

        return $this;
    }

    /**
     * Sort an array and maintain index association in reverse order.
     *
     * @param $flags
     * @return $this
     */
    public function arsort($flags = SORT_REGULAR)
    {
        arsort($this->haystack, $flags);

        return $this;
    }

    /**
     * Cleans real empty values in the haystack.
     *
     * @return $this
     */
    public function clean()
    {
        foreach ($this->getAll() as $key => $value) {
            if ($this->isEmpty($key)) {
                $this->delete($key);
            }
        }

        return $this;
    }

    /**
     * ############################################ FACTORIES ###################################################
     */

    /**
     * Creates collection by `key` if indexed value in the haystack is array.
     *
     * Otherwise, collection with empty haystack returns.
     *
     * @param int|string $key
     * @return $this
     */
    public function createBy($key)
    {
        $value = (isset($this->haystack[$key]) && is_array($this->haystack[$key]))
            ? $this->haystack[$key]
            : [];

        return new static($value);
    }

    /**
     * Creates class object by first element.
     *
     * @return $this
     */
    public function createByFirst()
    {
        $value = $this->getFirst();

        return new static(self::getConstructArgument($value));
    }

    /**
     * Creates class object by last element.
     *
     * @return $this
     */
    public function createByLast()
    {
        $value = $this->getLast();

        return new static(self::getConstructArgument($value));
    }

    /**
     * Creates class object by element available by `$index`.
     *
     * @param int $index
     * @return $this
     */
    public function createByIndex($index)
    {
        $value = $this->getByIndex($index);

        return new static(self::getConstructArgument($value));
    }

    /**
     * Returns tha value available for `__construct()`.
     *
     * @param mixed $value
     * @return array
     */
    private function getConstructArgument($value)
    {
        return (empty($value) || !is_array($value)) ? [] : $value;
    }

    /**
     * ############################################ PREDICATES ##################################################
     */

    /**
     * Defines if value by `$key` exists and is not empty
     *
     * @param int|string $key
     * @return bool
     */
    public function isEmpty($key)
    {
        if (!isset($this->haystack[$key])) {
            return true;
        }

        $value = $this->haystack[$key];

        if (!is_int($value)) {
            return (is_string($value))
                ? empty($value) || empty(trim($value))
                : empty($value);
        }

        return false;
    }

    /**
     * Defines if the given key or index exists in the haystack even nullable.
     *
     * @param int|string $key
     * @return bool
     */
    public function keyExists($key)
    {
        return array_key_exists($key, $this->haystack);
    }

    /**
     * Defines if all provided keys exists.
     *
     * @param int|string ...$keys
     * @return bool
     */
    public function hasKeys(...$keys)
    {
        foreach ($keys as $key) {
            if (!$this->keyExists($key)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Defines if the haystack has any value (even nullable) indexed by keys provided.
     *
     * @param int|string ...$keys
     * @return bool
     */
    public function hasAnyKey(...$keys)
    {
        foreach ($keys as $key) {
            if ($this->keyExists($key)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Defines if all provided values exists in the haystack.
     *
     * @param mixed ...$values
     * @return bool
     */
    public function hasValues(...$values)
    {
        foreach ($values as $value) {
            if (!in_array($value, $this->haystack)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Defines if the haystack has any value provided.
     *
     * @param mixed ...$values
     * @return bool
     */
    public function hasAnyValue(...$values)
    {
        foreach ($this->haystack as $value) {
            if (in_array($value, $values)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Defines if the haystack length in provided value.
     *
     * @param $count
     * @return bool
     */
    public function inCount($count)
    {
        return abs($count) <= $this->count();
    }

    /**
     * Asserts if value identically equals the value in the haystack by key.
     *
     * @param int|string $key
     * @param mixed $value
     * @return bool
     */
    public function assertEqualsByKey($key, $value)
    {
        return $this->get($key) === $value;
    }

    /**
     * Asserts if any value identically equals the value in the haystack by key.
     *
     * @param int|string $key
     * @param mixed ...$values
     * @return bool
     */
    public function assertAnyEqualsByKey($key, ...$values)
    {
        return in_array($this->get($key), $values, true);
    }
}

<?php

namespace Benb0nes\FlexArray;

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
     * Represents the haystack and all its values (only if it is not iterable in string).
     *
     * Pass `true` in `$associative` to represent in indexed by its keys.
     *
     * @param string $separator
     * @param bool $associative
     * @return string
     */
    public function implodeAll($separator, $associative)
    {
        $result = [];
        foreach ($this->haystack as $key => $value) {
            $value = (is_object($value))
                ? (array)$value
                : $value;

            $result[] = (!is_array($value))
                ? (($associative) ? sprintf('%s: %s', $key, $value) : $value)
                : $this->implode($separator, $value, $associative);
        }

        return implode($separator, $result);
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
    private static function implode($separator, $haystack, $associative = false)
    {
        $string = [];
        foreach ($haystack as $key => $value) {
            $string[] = (!is_array($value))
                ? (($associative) ? sprintf('%s: %s', $key, $value) : $value)
                : self::implode($separator, $value, $associative);
        }

        return implode($separator, $string);
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
     * Returns the haystack length.
     *
     * @return int
     */
    public function count()
    {
        return count($this->haystack);
    }

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
     * Returns list of keys of not real empty values.
     *
     * @param int|string ...$keys
     * @return array
     */
    public function touch(...$keys)
    {
        $filtered = array_filter($keys, function ($key) {
            return $this->isEmpty($key);
        }, ARRAY_FILTER_USE_KEY);

        return array_values(array_unique($filtered));
    }

    /**
     * Cleans real empty values in the haystack.
     *
     * @return $this
     */
    public function clean()
    {
        foreach ($this->getAll() as $key => $value) {
            if (!$this->isEmpty($key)) {
                $this->delete($key);
            }
        }

        return $this;
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
            if ($this->touch($value)) {
                $isEmpty[] = $value;
            }
        }

        return $isEmpty;
    }

    /**
     * Defines if value by `$key` exists and is not empty
     *
     * @param int|string $key
     * @return bool
     */
    public function isEmpty($key)
    {
        if (!isset($this->haystack[$key])) {
            return false;
        }

        $value = $this->haystack[$key];

        if (!is_int($value)) {
            return (is_string($value))
                ? !empty($value) && !empty(trim($value))
                : !empty($value);
        }

        return true;
    }

    /**
     * Returns list of keys of set values even nullable
     *
     * @param int|string ...$keys
     * @return array
     */
    public function findBy(...$keys)
    {
        $filtered = array_filter($keys, function ($key) {
            return $this->keyExists($key);
        }, ARRAY_FILTER_USE_KEY);

        return array_values(array_unique($filtered));
    }

    /**
     * Returns list of found values in haystack.
     *
     * @param mixed ...$values
     * @return array
     */
    public function find(...$values)
    {
        $filtered = [];
        foreach ($values as $value) {
            foreach ($this->haystack as $_value) {
                if ($value === $_value) {
                    $filtered[] = $_value;
                }
            }
        }

        return array_unique($filtered);
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
     * Returns key of value in the haystack or null on found.
     *
     * @param $needle
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
     * Binary search method for integer value in haystack.
     *
     * Sorts the haystack due the process.
     *
     * Returns the integer index of value on found or `-1` on not.
     *
     * @param int $needle
     * @return int
     */
    public function binarySearch($needle)
    {
        if (empty($this->haystack)) {
            return -1;
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

        return -1;
    }
}
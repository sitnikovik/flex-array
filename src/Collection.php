<?php

namespace Sitnikovik;

class Collection
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
    public function all()
    {
        return $this->haystack;
    }

    /**
     * Returns all haystack values but declared in `$keys`
     *
     * @param int|string ...$keys
     * @return array
     */
    public function allBut(...$keys)
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
     * Returns list of keys of not real empty values.
     *
     * @param int|string ...$keys
     * @return array
     */
    public function touch(...$keys)
    {
        $filtered = array_filter($keys, function ($key) {
            return $this->touchable($key);
        });

        return array_values(array_unique($filtered));
    }

    /**
     * Defines if value by `$key` exists and is not empty
     *
     * @param int|string $key
     * @return bool
     */
    public function touchable($key)
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
     * Defines if collection has any value by any provided key.
     *
     * @param int|string ...$keys
     * @return array
     */
    public function has(...$keys)
    {
        $filtered = array_filter($keys, function ($key) {
            return $this->exists($key);
        });

        return array_values(array_unique($filtered));
    }

    /**
     * Defines if the given key or index exists in the haystack.
     *
     * @param int|string $key
     * @return bool
     */
    public function exists($key)
    {
        return array_key_exists($key, $this->haystack);
    }

    /**
     * Binary search method for integer value in haystack.
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
        $len = count($this->haystack);
        $lower = 0;
        $high = $len - 1;
        while ($lower <= $high) {
            $middle = intval(($lower + $high) / 2);
            if ($this->haystack[$middle] > $needle) {
                $high = $middle - 1;
            } else if ($this->haystack[$middle] < $needle) {
                $lower = $middle + 1;
            } else {
                return $middle;
            }
        }

        return -1;
    }
}
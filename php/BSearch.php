<?php

namespace App\Backend;

class BSearch
{
    private $last;
    private $needle;
    private $key;

    public function __construct(array $haystack, $needle)
    {
        // haystack must be sorted array
        // in this structure we can not guarantee this
        asort($haystack);

        if (!is_numeric($needle)) {
            throw new \RuntimeException('Needle should be numeric');
        }

        $this->needle = $needle;
        $this->last = $this->last($haystack);
        $this->key = $this->resolve($haystack);
    }

    /**
     * @return bool|int|string
     */
    public function getKey()
    {
        return $this->key;
    }

    protected function resolve(array $input)
    {
        if (count($input) === 1) {
            $key = key($input);
            if ($input[$key] >= $this->needle) {
                return $key;
            }

            return $this->last;
        }

        $limit = count($input);
        if (!$limit) {
            return false;
        }

        $half1 = array_slice($input, 0, (int)round($limit / 2), true);
        $half2 = array_slice($input, (int)round($limit / 2), null, true);
        unset($input);

        $center = $this->firstIn($half2);
        $centerValue = current($center);
        if (false === $center) {
            throw new \RuntimeException('Half1 can not be empty');
        }

        $behindCenterValue = $this->lastIn($half1);
        if (false === $behindCenterValue) {
            throw new \RuntimeException('Half2 can not be empty');
        }

        if ($centerValue === $behindCenterValue) {
            return $this->resolve($half1);
        }

        if ($behindCenterValue < $this->needle) {
            return $this->resolve($half2);
        }

        if ($this->needle < $centerValue) {
            return $this->resolve($half1);
        }

        if ($this->needle > $centerValue) {
            return $this->resolve($half2);
        }

        if ($centerValue === $this->needle) {
            return key($center);
        }

        return false;
    }

    private function firstIn(array $array)
    {
        if (count($array) > 0) {
            $key = key($array);

            return [$key => $array[$key]];
        }

        return false;
    }

    private function lastIn(array $array)
    {
        if (count($array) > 0) {
            return array_pop($array);
        }

        return false;
    }

    private function last(array $input)
    {
        $key = array_keys($input);

        return (!empty($key)) ? array_pop($key) : false;
    }
}
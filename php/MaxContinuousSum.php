<?php

namespace App\Backend;

class MaxContinuousSum
{
    private $sum = 0;

    public function __construct(array $input)
    {
        $this->resolve($input);
    }

    /**
     * @return int
     */
    public function getSum()
    {
        return $this->sum;
    }

    protected function resolve(array $input)
    {
        $collection = 0;
        foreach ($input as $value) {
            $collection += $value;

            if ($collection <= 0) {
                $collection = 0;

                continue;
            }

            if ($collection > $this->sum) {
                $this->sum = $collection;
            }
        }
    }
}
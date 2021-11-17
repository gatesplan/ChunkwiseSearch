<?php

namespace App\LogarithmSearch;

use Illuminate\Support\Collection;
use \Exception;

/**
 * LogarithmSearch 클래스는 Laravel Collection의 Wrapper 클래스로, Collection의 모든 기능과 함께 LogarithmSearch에서 지원하는 검색 기능을 사용할 수 있도록 합니다.
 */
class LogarithmSearch extends Collection
{
    private $test;

    public function setTestFunc($callback)
    {
        if (!is_callable($callback)) {
            throw new Exception('First argument of LogarithmSearch::logarithmSearch() must be a callable.');
        }

        $this->test = $callback;
    }

    public function logSearch($testFunc = null): int
    {
        $this->setTestFunc($testFunc ?? $this->test);

        return $this->logarithmSearch(0, 0, false);
    }

    private function logarithmSearch(int $key, int $diff, bool $shrink): int
    {
        if (($testWas = $this->test($this->get($key))) || ($diff === 1)) {
            if ($this->isEnd($key, $diff, $testWas, $shrink)) {
                return ($diff === 1)? $key : $key+1;
            }
        }

        // otherwise prepare next test and reculsive the test.
        $next = $this->prepareNextTest($key, $diff, $shrink, $testWas);
        return $this->logarithmSearch($next['key'], $next['diff'], $next['shrink']);
    }

    private function isEnd(int $key, int $diff, bool $testWas, bool $shrink): bool
    {
        return ($key === 0 && $testWas) || ($diff === 1 && $shrink);
    }

    private function test($testTarget): bool
    {
        return ($this->test)($testTarget);
    }

    private function getDiffKey(int $diff, bool $shrink): int
    {
        return  ($diff === 0)? 1 : (($shrink)? $diff/2 : $diff*2);
    }

    private function prepareNextTest(int $key, int $diff, bool $shrink, bool $testWas): array
    {
        $newShrink = $shrink || $testWas;
        $newDiff = $this->getDiffKey($diff, $newShrink);
        $newKey = ($testWas) ? $key - $newDiff : $key + $newDiff;

        // when $newKey exceeds maxKey..
        while (($this->count() - 1) < $newKey) {
            $newShrink = true;
            $newDiff = $this->getDiffKey($newDiff, $newShrink);
            $newKey -= $newDiff;
        }

        return ['key' => $newKey, 'diff' => $newDiff, 'shrink' => $newShrink];
    }
}

<?php

namespace App\Pagination;

class PagePagination
{
    private $count;
    private $page;
    private $offset;
    private $windowStart;
    private $windowEnd;

    public function __construct($count, $page = 1, $offset = 2)
    {
        $this->count = $count;

        $page = intval($page);
        $this->page = $page < 1 ? 1 : $page;

        $offset = intval($offset);
        $this->offset = $offset < 1 ? 1 : $offset;

        $this->calcWindowStartEnd();

        return $this;
    }

    public function isFirst()
    {
        return $this->page == 1;
    }

    public function isLast()
    {
        return $this->page == $this->count;
    }

    public function isCurrent($page)
    {
        return $this->page == $page;
    }

    public function getLast()
    {
        return $this->count;
    }

    public function getPages()
    {
        for ($page = $this->windowStart; $page <= $this->windowEnd; $page++) {
            yield $page;
        }
    }

    public function needPrefixDots()
    {
        return $this->windowStart > 1;
    }

    public function needSuffixDots()
    {
        return $this->windowEnd < $this->count;
    }

    private function calcWindowStartEnd()
    {
        $start = $this->page - $this->offset;
        $end = $this->page + $this->offset;

        if ($start < 1) {
            $start = 1;
        }

        if ($end > $this->count) {
            $end = $this->count;
        }

        $this->windowStart = $start;
        $this->windowEnd = $end;
    }
}

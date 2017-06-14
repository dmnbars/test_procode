<?php

namespace App\Pagination;

/**
 * Класс для простой пагинации по страницам
 * @package App\Pagination
 */
class PagePagination
{
    /**
     * @var int $count
     */
    private $count;

    /**
     * @var int $page
     */
    private $page;

    /**
     * @var int $offset
     */
    private $offset;

    /**
     * @var int $windowStart
     */
    private $windowStart;

    /**
     * @var int $windowEnd
     */
    private $windowEnd;

    /**
     * @param $count - всего страниц
     * @param int $page - текущая страница
     * @param int $offset - сколько выводить страниц слева/справа
     */
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

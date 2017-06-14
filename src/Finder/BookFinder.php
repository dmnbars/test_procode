<?php

namespace App\Finder;

class BookFinder extends AbstractFinder
{
    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return 'books';
    }

    /**
     * @param $id
     * @return int
     */
    public function getPageCountByBook($id)
    {
        // Для упрощения текущей реализации будем считать, что страницы идут от 1 до последней без пропусков.
        $sql = <<<SQL
SELECT COUNT(`pages`.`id`) as cnt FROM `{$this->getTableName()}`
LEFT JOIN `chapters`
ON `{$this->getTableName()}`.id = `chapters`.book_id
LEFT JOIN `pages`
ON `chapters`.id = `pages`.chapter_id
WHERE `books`.id = ?
SQL;
        $data = $this->db->select($sql, [$id]);

        return isset($data[0]['cnt']) ? $data[0]['cnt'] : 0;
    }

    public function findAllByLang($langCode)
    {
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE `lang_id` = ?";

        return $this->db->select($sql, [$langCode]);
    }
}

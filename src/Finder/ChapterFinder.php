<?php

namespace App\Finder;

class ChapterFinder extends AbstractFinder
{
    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return 'chapters';
    }

    /**
     * Метод возвращает массив со всеми главами книги отсортированными по возрастанию параметра sort
     * @param $id
     *
     * @return array
     */
    public function findAllByBookId($id)
    {
        $sql = <<<SQL
SELECT 
  `{$this->getTableName()}`.id as id,
  `{$this->getTableName()}`.name as `name`,
  MIN(`pages`.number) as page 
FROM `{$this->getTableName()}`
LEFT JOIN `pages`
ON `{$this->getTableName()}`.id = `pages`.chapter_id
WHERE `{$this->getTableName()}`.book_id = ? 
GROUP BY id, `name`
ORDER BY sort ASC
SQL;

        return $this->db->select($sql, [$id]);
    }
}

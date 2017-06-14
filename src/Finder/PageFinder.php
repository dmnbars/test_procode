<?php

namespace App\Finder;

class PageFinder extends AbstractFinder
{
    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return 'pages';
    }

    public function findOneByNumber($number)
    {
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE `number` = ? LIMIT 1";

        $data = $this->db->select($sql, [$number]);

        if (!isset($data[0])) {
            return [];
        }

        return $data[0];
    }
}

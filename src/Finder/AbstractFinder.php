<?php

namespace App\Finder;

use App\DataBase;

abstract class AbstractFinder implements FinderInterface
{
    /**
     * @var DataBase $db
     */
    protected $db;

    public function __construct(DataBase $db)
    {
        $this->db = $db;
    }

    /**
     * {@inheritdoc}
     */
    public function findOneById($id)
    {
        $sql = "SELECT * FROM `{$this->getTableName()}` WHERE `id` = ? LIMIT 1";

        $data = $this->db->select($sql, [$id]);

        if (!isset($data[0])) {
            return [];
        }

        return $data[0];
    }

    /**
     * {@inheritdoc}
     */
    public function findAll()
    {
        $sql = "SELECT * FROM `{$this->getTableName()}`";

        return $this->db->select($sql);
    }
}

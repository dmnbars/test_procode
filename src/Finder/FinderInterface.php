<?php

namespace App\Finder;

use App\DataBase;

interface FinderInterface
{
    public function __construct(DataBase $db);

    /**
     * @return string
     */
    public function getTableName();

    /**
     * @param int $id
     *
     * @return array
     */
    public function findOneById($id);

    /**
     * @return array
     */
    public function findAll();
}

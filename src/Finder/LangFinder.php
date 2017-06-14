<?php

namespace App\Finder;

class LangFinder extends AbstractFinder
{
    /**
     * {@inheritdoc}
     */
    public function getTableName()
    {
        return 'languages';
    }
}

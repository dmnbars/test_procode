<?php
namespace App;

class Template
{
    public static function render($filePath, array $params = [])
    {
        $templatePath = 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $filePath . '.phtml';

        extract($params);
        ob_start();
        include $templatePath;

        return ob_get_clean();
    }
}

<?php

require_once __DIR__ . '/vendor/autoload.php';

use Littlesqx\Helper\Func;

$gen = Func::traverseFilepath('../PHP-Interview');

foreach ($gen as $path) {
    if ('md' === pathinfo($path, PATHINFO_EXTENSION)) {
        $content = Func::readFile($path);
        $fixedContent = Func::fixChineseTyping($content);
        Func::writeFile($path, $fixedContent);
    }
}
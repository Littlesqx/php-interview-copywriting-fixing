<?php

/*
 * This file is part of the php-interview-copywriting-fixing.
 *
 * (c) littlesqx <littlesqx@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Littlesqx\Helper;

use Jxlwqq\ChineseTypesetting\ChineseTypesetting;

class Func
{
    /**
     * 读取文件
     *
     * @param $filepath
     *
     * @return false|string
     */
    public static function readFile($filepath)
    {
        if (!file_exists($filepath)) {
            throw new \InvalidArgumentException("{$filepath} is not exist.");
        }
        return file_get_contents($filepath);
    }

    /**
     * 写出文件
     *
     * @param $filepath
     * @param $content
     *
     * @return bool|int
     */
    public static function writeFile($filepath, $content)
    {
        return file_put_contents($filepath, $content);
    }

    /**
     * 遍历文件夹下的所有文件
     *
     * @param $root
     *
     * @return \Generator
     */
    public static function traverseFilepath($root)
    {
        $dir = new \DirectoryIterator($root);
        foreach ($dir as $path) {
            if (!$path->isDot()) {
                $file = $path->getPath() . '/' . $path->getFilename();
                if ($path->isDir()) {
                    yield from self::traverseFilepath($file);
                } else {
                    yield $path->getRealPath();
                }
            }
        }
    }

    /**
     * 修复中文排版格式
     *
     * @param $origin
     *
     * @return string|string[]|null
     */
    public static function fixChineseTyping($origin)
    {
        $chineseTypesetting = new ChineseTypesetting();
        $fixed = $chineseTypesetting->insertSpace($origin);
        $fixed = $chineseTypesetting->removeSpace($fixed);
        $fixed = $chineseTypesetting->full2Half($fixed);
        $fixed = $chineseTypesetting->fixPunctuation($fixed);
        $fixed = $chineseTypesetting->properNoun($fixed);
        return $fixed;
    }
}


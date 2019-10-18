<?php
declare(strict_types=1);
namespace Ydin\File;

/**
 * Class FileFinder
 *
 * @package Ydin\File
 */
class FileFinder
{
    /**
     * 從該路徑下, 取得所有的 特定格式檔案
     *
     * example:
     *      $files = FileFinder::findByExtension('resources/import', 'json');
     *      dump($files);
     *
     * @param string $path
     * @param string $extendName
     * @return array
     */
    public static function findByExtension(string $path, string $extension)
    {
        $path = rtrim($path, "/");
        $all = self::globRecursive("{$path}/*.{$extension}");
        $files = [];
        foreach ($all as $node) {
            if (is_file($node)) {
                $files[] = $node;
            }
        }
        return $files;
    }

    // ============================================================
    //  private
    // ============================================================

    /**
     * @param $pattern
     * @param int $flags
     * @return array
     */
    protected static function globRecursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);

        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR) as $dir) {
            $files = array_merge(
                $files,
                self::globRecursive($dir.'/'.basename($pattern), $flags)
            );
        }

        return $files;
    }

}

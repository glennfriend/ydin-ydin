<?php
namespace Cor\Ydin\File;

/**
 * File Mime
 *
 * @version     1.0.0
 * @package     Cor\Ydin\File\Mime
 */
class Mime
{

    /**
     *  get mime by file
     */
    public static function getByFile($file)
    {
        return finfo_file(
            finfo_open(FILEINFO_MIME_TYPE), $file
        );
    }


    /**
     *  代入 mime 找 extend name
     *
     *  @param string mime
     *  @return string or null
     */
    public static function getExtendByMime($mime)
    {
        foreach ( self::getExtendGroup() as $name => $extends ) {
            if ( in_array( $mime, $extends ) ) {
                return $name;
            }
        }
        return null;
    }

    /**
     *  取得 所有對應的 副檔名 & mime
     *
     *  @return all mime group
     */
    public static function getExtendGroup()
    {
        return array(
            'csv' => array(
                'text/csv',
                'text/comma-separated-values',
                'application/csv-tab-delimited-table',
                'application/vnd.ms-excel',
                'application/octet-stream',
            ),
            'gif' => array(
                'image/gif',
            ),
            'jpg' => array(
                'image/jpeg',
                'image/pjpeg',
            ),
            'png' => array(
                'image/png',
            ),
            'tif' => array(
                'image/tiff',
                'image/x-tiff',
            ),
            'bmp' => array(
                'image/bmp',
                'image/x-windows-bmp',
            ),
            'ico' => array(
                'image/vnd.microsoft.icon',
            ),
            'psd' => array(
                'image/vnd.adobe.photoshop',
            ),

            'php' => array(
                'text/x-php',
            ),
        );
    }

    /**
     *  常用格式分類
     *
     *  @param $category
     *  @return mimes array or empty array
     */
    public static function getByExtendName($name)
    {
        $group = self::getExtendGroup();
        if ( !isset($group[$name]) ) {
            return array();
        }
        return $group[$name];
    }

    

}


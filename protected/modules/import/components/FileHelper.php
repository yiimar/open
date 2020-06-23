<?php


namespace app\modules\import\components;

use Yii;

/**
 * FileHelper
 *
 * @author yiimar
 */
class FileHelper
{
    /**
     * Получение массива имен файлов по алиасу
     *
     * @param type $alias
     * @return type array of string (file names)
     * @throws \Exception
     *
     * @author yiimar
     */
    public static function showDir($alias)
    {
        $path = Yii::getAlias($alias);
        if (!is_dir($path))
            throw new \Exception(404,'The requested page does not exist.');
        $dir = [];
        if ($cat = scandir($path)) {
            foreach ($cat as $k => $v) {
                if ($v != "." && $v != "..") {
                    $dir[] = $v;
                }
            }
        }
        return $dir;
    }
}
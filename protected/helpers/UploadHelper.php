<?php


namespace app\helpers;


class UploadHelper
{
    /**
     * Функция получения 1-го символа строки
     * @param type $str string
     * @return type string
     */
    public static function firstLetter($str)
    {
        $length = (strlen(mb_convert_encoding($str,"CP1251","UTF-8")) < strlen($str))
            ? 2
            : 1;

        return mb_substr($str, 0, $length);
    }

    public static function sumWithSighn($summa)
    {
        if (UploadHelper::firstLetter(ltrim($summa)) === '-') {
            $res['debkred'] = false;
            $res['summa'] = substr($summa, 1);
        } else {
            $res['debkred'] = true;
            $res['summa'] = $summa;
        }
        return $res;
    }
}
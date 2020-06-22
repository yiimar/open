<?php

/**
 * global.php file.
 * Global shorthand functions for commonly used Yii methods.
 *
 * @author yiimar       use source of Christoffer Niska <christoffer.niska@gmail.com>
 *
 * @copyright Copyright &copy; Christoffer Niska 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

defined('DS')       or define('DS',       DIRECTORY_SEPARATOR);
defined('UNIX_DAY') or define('UNIX_DAY', 86400);

/**
 * Returns the application instance.
 * @return WebApplication
 */
function app()
{
    return Yii::app();
}

/**
 * Returns the application parameter with the given name.
 * @param $name
 * @return mixed
 */
function param($name)
{
    return isset(Yii::app()->params[$name]) ? Yii::app()->params[$name] : null;
}

function basePath()
{
    return Yii::app()->basePath;
}

function getUrl() {
    $url  = @( $_SERVER["HTTPS"] != 'on' ) ? 'http://'.$_SERVER["SERVER_NAME"] :  'https://'.$_SERVER["SERVER_NAME"];
    $url .= ( $_SERVER["SERVER_PORT"] != 80 ) ? ":".$_SERVER["SERVER_PORT"] : "";
    $url .= $_SERVER["REQUEST_URI"];
    return $url;
}

/**
 * Get CSS- URL for actual theme
 */
function cssUrl()
{
    return basePath() . DS . '..' . '/css/';
}

/**
 * Get CSS- URL for actual theme
 */
function jsUrl()
{
    return basePath() . DS . '..' . '/js/';
}

/**
 * Get Images- URL for actual theme
 */
function imgUrl()
{
    return basePath() . DS . '..' . '/img/';
}

/**
 * Get CSS- URL for actual theme
 */
function fontUrl()
{
    return basePath() . DS . '..' . '/fonts/';
}

/**
 * Returns the client script instance.
 * @return CClientScript
 */
function clientScript()
{
    return Yii::app()->getClientScript();
}

/**
 * Returns the main database connection.
 * @return CDbConnection
 */
function db()
{
    return Yii::app()->getDb();
}

/**
 * Returns the formatter instance.
 * @return Formatter
 */
function format()
{
    return Yii::app()->getComponent('format');
}

/**
 * Получение префикса для пути к вьюшке:  ''- для русской лакали, 'en/'- для английской
 * @return type string
 */
function getLocalPrefix()
{
    return (Yii::app()->language === 'en') ?'en/' :'';
}

/**
 * Returns the date formatter instance.
 * @return CDateFormatter
 */
function dateFormatter()
{
    return Yii::app()->getDateFormatter();
}

function dateDiff($date1, $date2)
{
    return (int) (strtotime($date2)-strtotime($date1))/UNIX_DAY;
}
function checkDateTimeFormat($datetime)
{
    return !empty($datetime) && preg_match('@^\d{2}\.\d{2}\.\d{4} \d{2}:\d{2}:\d{2}$@', $datetime);
}
function checkDateFormat($datetime)
{
    return !empty($datetime) && preg_match('@^\d{2}\.\d{2}\.\d{4}$@', $datetime);
}

/**
 * Returns the date formatter instance.
 * @return CDateFormatter
 */
function numberFormatter()
{
    return Yii::app()->getNumberFormatter();
}

/**
 * Returns the request instance.
 * @return CHttpRequest
 */
function request()
{
    return Yii::app()->getRequest();
}

/**
 * Returns the session instance.
 * @return CHttpSession
 */
function session()
{
    return Yii::app()->getSession();
}

/**
 * Returns the web user instance for the logged in user.
 * @return CWebUser
 */
function user()
{
    return Yii::app()->getUser();
}

function setState($tag, $value)
{
    return Yii::app()->user->setState($tag, $value);
}

function getState($tag, $default=null)
{
    return Yii::app()->user->getState($tag, $default);
}

function hasState($value)
{
    return Yii::app()->user->hasState($value);
}

function hasFlash($tag)
{
    return Yii::app()->user->hasFlash($tag);
}

function setFlash($tag, $value)
{
    return Yii::app()->user->setFlash($tag, $value);
}

function getFlash($tag)
{
    return Yii::app()->user->getFlash($tag);
}

/**
 * Return the web user is guest flag
 * @return boolean
 */
function isGuest()
{
    return (Yii::app()->user->isGuest);
}

/**
 * isGuest() для роли гостя возвращает NULL!, а должен- 'guest'. Фиксим...
 * @return string of role name
 */
function activeUserRole()
{
    if (isGuest())      return 'guest';
    else                return user()->role;
}

/**
 * Translates the given string using Yii::t().
 * @param $category
 * @param $message
 * @param array $params
 * @param string $source
 * @param string $language
 * @return string
 */
function t($category, $message, $params = array(), $source = null, $language = null)
{
    return Yii::t($category, $message, $params, $source, $language);
}

/**
 * Returns the base URL for the given URL.
 * @param string $url
 * @return string
 */
function baseUrl($url = '')
{
    static $baseUrl;
    if (!isset($baseUrl)) {
        $baseUrl = Yii::app()->request->baseUrl;
    }
    return $baseUrl . '/' . ltrim($url, '/');
}

/**
 * Registers the given CSS file.
 * @param $url
 * @param string $media
 */
function css($url, $media = '')
{
    Yii::app()->clientScript->registerCssFile(baseUrl($url), $media);
}

/**
 * Registers the given JavaScript file.
 * @param $url
 * @param null $position
 */
function js($url, $position = null)
{
    Yii::app()->clientScript->registerScriptFile(baseUrl($url), $position);
}

/**
 * Escapes the given string using CHtml::encode().
 * @param $text
 * @return string
 */
function e($text)
{
    return CHtml::encode($text);
}

/**
 * Returns the escaped value of a model attribute.
 * @param $model
 * @param $attribute
 * @param null $defaultValue
 * @return string
 */
function v($model, $attribute, $defaultValue = null)
{
    return CHtml::encode(CHtml::value($model, $attribute, $defaultValue));
}

/**
 * Purifies the given HTML.
 * @param $text
 * @return string
 */
function purify($text)
{
    static $purifier;
    if (!isset($purifier)) {
        $purifier = new CHtmlPurifier;
    }
    return $purifier->purify($text);
}

/**
 * Returns the given markdown text as purified HTML.
 * @param $text
 * @return string
 */
function markdown($text)
{
    static $parser;
    if (!isset($parser)) {
        $parser = new MarkdownParser;
    }
    return $parser->safeTransform($text);
}

/**
 * Creates an image tag using CHtml::image().
 * @param $src
 * @param string $alt
 * @param array $htmlOptions
 * @return string
 */
function img($src, $alt = '', $htmlOptions = array())
{
    return CHtml::image(baseUrl($src), $alt, $htmlOptions);
}

/**
 * Creates a link to the given url using CHtml::link().
 * @param $text
 * @param string $url
 * @param array $htmlOptions
 * @return string
 */
function l($text, $url = '#', $htmlOptions = array())
{
    return CHtml::link($text, $url, $htmlOptions);
}

/**
 * Creates a relative URL using CUrlManager::createUrl().
 * @param $route
 * @param array $params
 * @param string $ampersand
 * @return mixed
 */
function url($route, $params = array(), $ampersand = '&')
{
    return Yii::app()->urlManager->createUrl($route, $params, $ampersand);
}

/**
 * Encodes the given object using json_encode().
 * @param mixed $value
 * @param integer $options
 * @return string
 */
function jsonEncode($value, $options = 0)
{
    return json_encode($value, $options);
}

/**
 * Decodes the given JSON string using json_decode().
 * @param $string
 * @param boolean $assoc
 * @param integer $depth
 * @param integer $options
 * @return mixed
 */
function jsonDecode($string, $assoc = true, $depth = 512, $options = 0)
{
    return json_decode($string, $assoc, $depth, $options);
}

/**
 * Returns the current time as a MySQL date.
 * @param integer $timestamp the timestamp.
 * @return string the date.
 */
function sqlDate($timestamp = null)
{
    if ($timestamp === null) {
        $timestamp = time();
    }
    return date('Y-m-d', $timestamp);
}

/**
 * Returns the current time as a MySQL date time.
 * @param integer $timestamp the timestamp.
 * @return string the date time.
 */
function sqlDateTime($timestamp = null)
{
    if ($timestamp === null) {
        $timestamp = time();
    }
    return date('Y-m-d H:i:s', $timestamp);
}

/**
 * Функция получения 1-го символа строки
 * @param type $str string
 * @return type string
 */
function firstLetter($str)
{
    $length = (strlen(mb_convert_encoding($str,"CP1251","UTF-8")) < strlen($str))
        ? 2
        : 1;

    return mb_substr($str, 0, $length);
}

// входная дата в формате: yyyy-mm-dd
function weekDayByWord($date)
{
    $day = array('1'=>'понедельник','2'=>'вторник','3'=>'среда','4'=>'четверг','5'=>'пятница','6'=>'суббота','7'=>'воскресенье',);
    $weekDayNumber = date("N",strtotime($date));
    return $day[$weekDayNumber];
}

/**
 * Dumps the given variable using CVarDumper::dumpAsString().
 * @param mixed $var
 * @param int $depth
 * @param bool $highlight
 */
function dump($var, $depth = 10, $highlight = true)
{
    echo CVarDumper::dumpAsString($var, $depth, $highlight);
}

/**
 * @param $parents array
 * @param $searched array
 *
 * @return bool|int|string
 */
function multidimensional_search($parents, $searched)
{
    if (empty($searched) || empty($parents)) {
        return false;
    }

    foreach ($parents as $key => $value) {
        $exists = true;
        foreach ($searched as $skey => $svalue) {
            $exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue);
        }
        if($exists){ return $key; }
    }
    return false;
}

function makeImage64($image, $path = 'wdw-passport')
{
    return (file_exists(DFileHelper::getPath(DFileHelper::WDW_PHOTO_KIND) . '/' . $image))
        ? base64_encode(file_get_contents(request()->baseUrl . "protected/data/$path/$image"))
        : 'no image';
}

function makeScan64($image, $path = 'passport')
{
    return (file_exists(DFileHelper::getPath(DFileHelper::WDW_PHOTO_KIND) . '/' . $image))
        ? base64_encode(file_get_contents(request()->baseUrl . "protected/user_scans/$path/$image"))
        : 'no image';
}

/**
 * Получаем СМС-код:
 * @return string
 */
function getSmsCode($min = 0, $max = 999999, $len = 6)
{
    $num = rand($min, $max);
    if (strlen($num) < $len) {
        for ($i = ($len - strlen($num)); $i > 0; $i--) {
            switch (rand(0, 1)) {
                case 0:
                    $num .= rand(0, 9);
                    break;
                case 1:
                    $num = rand(0, 9) . $num;
                    break;
            }
        }
    }
    return $num;
}

function translateString($text)
{
    return strtr($text, array(
        "а" => "a",
        "б" => "b",
        "в" => "v",
        "г" => "g",
        "д" => "d",
        "е" => "e",
        "ё" => "jo",
        "ж" => "zh",
        "з" => "z",
        "и" => "i",
        "й" => "j",
        "к" => "k",
        "л" => "l",
        "м" => "m",
        "н" => "n",
        "о" => "o",
        "п" => "p",
        "р" => "r",
        "с" => "s",
        "т" => "t",
        "у" => "u",
        "ф" => "f",
        "х" => "h",
        "ц" => "c",
        "ч" => "ch",
        "ш" => "sh",
        "щ" => "shh",
        "ь" => "'",
        "ы" => "y",
        "ъ" => "#",
        "э" => "je",
        "ю" => "ju",
        "я" => "ja",
        "А" => "A",
        "Б" => "B",
        "В" => "V",
        "Г" => "G",
        "Д" => "D",
        "Е" => "E",
        "Ё" => "Jo",
        "Ж" => "Zh",
        "З" => "Z",
        "И" => "I",
        "Й" => "J",
        "К" => "K",
        "Л" => "L",
        "М" => "M",
        "Н" => "N",
        "О" => "O",
        "П" => "P",
        "Р" => "R",
        "С" => "S",
        "Т" => "T",
        "У" => "U",
        "Ф" => "F",
        "Х" => "H",
        "Ц" => "C",
        "Ч" => "Ch",
        "Ш" => "Sh",
        "Щ" => "Shh",
        "Ь" => "''",
        "Ы" => "Y",
        "Ъ" => "##",
        "Э" => "Je",
        "Ю" => "Ju",
        "Я" => "Ja",
    ));
}

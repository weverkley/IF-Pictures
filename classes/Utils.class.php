<?php
/**
 * summary
 */
class Utils extends ExtensionBridge
{
    /**
     * Utils::ClearText($var);
     */
    public static function ClearText($text){
	    $text = preg_replace('/\s+/', '_', $text);
	    $text = preg_replace( '/[`^~\'"]/', null, iconv('UTF-8', 'ASCII//TRANSLIT', $text));
	    $text = strtolower($text);
	    $text = trim($text);
	    return $text;
    }

    public static function createFolder($fulldir){
	    if (!is_dir($fulldir)) mkdir($fulldir, 0755);
	    if (!is_writable($fulldir)) chmod($fulldir, 0755);
	}
}
?>
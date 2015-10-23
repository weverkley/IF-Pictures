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
}
?>
<?php
/**
 * summary
 */
class Utils
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

    public static function birthday($date){
	    $day = substr($date, 0, 2);
	    $month = substr($date, 3, 2);
	    $age = date('Y') - substr($date, -4, 4);
	    $string = null;
	    switch ($month) {
	    	case '01':
	    		$string = $day.' de Janeiro ( '.$age.' anos )';
	    		return $string;
	    		break;
	    	case '02':
	    		$string = $day.' de Fevereiro ( '.$age.' anos )';
	    		return $string;
	    		break;
	    	case '03':
	    		$string = $day.' de Março ( '.$age.' anos )';
	    		return $string;
	    		break;
	    	case '04':
	    		$string = $day.' de Abril ( '.$age.' anos )';
	    		return $string;
	    		break;
	    	case '05':
	    		$string = $day.' de Maio ( '.$age.' anos )';
	    		return $string;
	    		break;
	    	case '06':
	    		$string = $day.' de Junho ( '.$age.' anos )';
	    		return $string;
	    		break;
	    	case '07':
	    		$string = $day.' de Julho ( '.$age.' anos )';
	    		return $string;
	    		return $string;
	    		break;
	    	case '08':
	    		$string = $day.' de Agosto ( '.$age.' anos )';
	    		return $string;
	    		break;
	    	case '09':
	    		$string = $day.' de Setembro ( '.$age.' anos )';
	    		return $string;
	    		break;
	    	case '10':
	    		$string = $day.' de Outubro ( '.$age.' anos )';
	    		return $string;
	    		break;
	    	case '11':
	    		$string = $day.' de Novembro ( '.$age.' anos )';
	    		return $string;
	    		break;
	    	case '12':
	    		$string = $day.' de Dezembro ( '.$age.' anos )';
	    		return $string;
	    		break;
	    }
	}

	public static function getExtension($str){
	    $i = strrpos($str,".");
	    if (!$i) { return ""; } 
	    $l = strlen($str) - $i;
	    $ext = substr($str,$i+1,$l);
	    return $ext;
	}

	public static function imageExists($var){
		if (file_exists('public/upload/large/'.$var)) return true;
		else return false;
	}

	public static function profilePicture($img){
		if(preg_match("/.png/i", $img)){
			return (preg_match("/user_male/i", $img))? PUBLIC_DIR.'/img/panel/user_male.png' : PUBLIC_DIR.'/img/panel/user_female.png';
		} else return PUBLIC_DIR."/php/search.php?id=".$img; 
	}

	public static function profileCover($img){
		if(preg_match("/cover.jpg/i", $img)){
			return PUBLIC_DIR.'/img/panel/cover.png';
		} else return PUBLIC_DIR."/php/search.php?id=".$img; 
	}
}
?>
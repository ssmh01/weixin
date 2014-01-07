<?php

/**
 * This class represent a locale information to support i18n functions for the framework.
 *
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-26
 */
class Locale{
	
	public static $CHINESE = 'zh'; // new Locale("zh");

	public static $SIMPLIFIED_CHINESE = 'zh-CN'; // new Locale("zh", "CN");

	public static $TRADITIONAL_CHINESE = 'zh-TW'; // new Locale("zh", "TW");
	
	public static $ENGLISH = 'en'; // new Locale("en")

	public static $FRENCH = 'fr'; // new Locale("fr");

	public static $GERMAN = 'de'; // new Locale("de");

	public static $ITALIAN = 'it'; // new Locale("it");

	public static $JAPANESE	= 'ja'; // new Locale("ja");

	public static $FRANCE = 'fr-FR'; // new Locale("fr", "FR");

	public static $GERMANY = 'de-DE'; // new Locale("de", "DE");

	public static $ITALY = 'it-IT'; // new Locale("it", "IT");

	public static $JAPAN = 'ja-JP'; // new Locale("ja", "JP");

	public static $UK = 'en-GB'; // new Locale("en", "GB");

	public static $US	= 'en-US'; // new Locale("en", "US");

	public static $CANADA = 'en-CA'; // new Locale("en", "CA");

	/**
	 * The language code.
	 * @type string
	 */
	private $language;

	/**
	 * The country code.
	 * @type string
	 */
	private $country;

	/**
	 * construct a locale.
	 * @param string $language
	 * @param string $country
	 * @param Locale $defaultLocale
	 */
	public function __construct($language='', $country=''){
		$this->setLanguage($language);
		$this->setCountry($country);
	}
	
	/**
	 * use a locale string to create a locale. The string format is
	 * like 'zh-CN' or 'zh' or 'CN', must notice that: the country
	 * code use supper case and language code use lower case.
	 * @param string $localString
	 */
	public static function create($localString){
		if(strlen($localString) == 0) return null;
		$localString = explode('-', $localString);
		if(count($localString) > 1){
			return new Locale($localString[0], $localString[1]);
		}
		$localString = $localString[0];
		if(String::isLower($localString)) return new Locale($localString, null);
		if(String::isUpper($localString)) return new Locale(null, $localString);
		return null;
	}
	
	/**
	 * get the app server default locale
	 * @return Locale
	 */
	public static function getDefault() {
		return self::create(self::$SIMPLIFIED_CHINESE);
	}

	/**
	 * get language code.
	 * @return string
	 */
	public function getLanguage() {
		return $this->language;
	}

	/**
	 * set language code.
	 * @param string $language
	 */
	public function setLanguage($language){
		$this->language = strtolower($language);
	}

	/**
	 * get country code.
	 * @return string
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * set country code
	 * @param string $country
	 */
	public function setCountry($country){
		$this->country = strtoupper($country);
	}

	/**
	 * use string to describle a locale.
	 */
	public function toString() {
		//country code and language code must not empty at one time.
		if (strlen($this->language) == 0 && strlen($this->country) == 0) return '';
		$localeString = '';
		$part = '';
		if(strlen($this->language) != 0) {
			$localeString .= $this->language;
			$part = '-';
		}
		if(strlen($this->country) != 0) {
			$localeString .= $part;
			$localeString .= $this->country;
		}
		return $localeString;
	}

	/**
	 * get all iso countries.
	 * @return array
	 */
	public static function getISOCountries() {
		return array(
			"AD", "AE", "AF", "AG", "AI", "AL", "AM", "AN", "AO", "AQ", "AR", "AS",
			"AT", "AU", "AW", "AZ", "BA", "BB", "BD", "BE", "BF", "BG", "BH", "BI",
			"BJ", "BM", "BN", "BO", "BR", "BS", "BT", "BV", "BW", "BY", "BZ", "CA",
			"CC", "CF", "CG", "CH", "CI", "CK", "CL", "CM", "CN", "CO", "CR", "CU",
			"CV", "CX", "CY", "CZ", "DE", "DJ", "DK", "DM", "DO", "DZ", "EC", "EE",
			"EG", "EH", "ER", "ES", "ET", "FI", "FJ", "FK", "FM", "FO", "FR", "FX",
			"GA", "GB", "GD", "GE", "GF", "GH", "GI", "GL", "GM", "GN", "GP", "GQ",
			"GR", "GS", "GT", "GU", "GW", "GY", "HK", "HM", "HN", "HR", "HT", "HU",
			"ID", "IE", "IL", "IN", "IO", "IQ", "IR", "IS", "IT", "JM", "JO", "JP",
			"KE", "KG", "KH", "KI", "KM", "KN", "KP", "KR", "KW", "KY", "KZ", "LA",
			"LB", "LC", "LI", "LK", "LR", "LS", "LT", "LU", "LV", "LY", "MA", "MC",
			"MD", "MG", "MH", "MK", "ML", "MM", "MN", "MO", "MP", "MQ", "MR", "MS",
			"MT", "MU", "MV", "MW", "MX", "MY", "MZ", "NA", "NC", "NE", "NF", "NG",
			"NI", "NL", "NO", "NP", "NR", "NU", "NZ", "OM", "PA", "PE", "PF", "PG",
			"PH", "PK", "PL", "PM", "PN", "PR", "PT", "PW", "PY", "QA", "RE", "RO",
			"RU", "RW", "SA", "SB", "SC", "SD", "SE", "SG", "SH", "SI", "SJ", "SK",
			"SL", "SM", "SN", "SO", "SR", "ST", "SV", "SY", "SZ", "TC", "TD", "TF",
			"TG", "TH", "TJ", "TK", "TM", "TN", "TO", "TP", "TR", "TT", "TV", "TW",
			"TZ", "UA", "UG", "UM", "US", "UY", "UZ", "VA", "VC", "VE", "VG", "VI",
			"VN", "VU", "WF", "WS", "YE", "YT", "YU", "ZA", "ZM", "ZR", "ZW"
	 	);
	}

	/**
	 * get all iso language.
	 * @return array
	 */
	public static function getISOLanguages() {
		return array(
			"aa", "ab", "af", "am", "ar", "as", "ay", "az", "ba", "be", "bg", "bh",
			"bi", "bn", "bo", "br", "ca", "co", "cs", "cy", "da", "de", "dz", "el",
			"en", "eo", "es", "et", "eu", "fa", "fi", "fj", "fo", "fr", "fy", "ga",
			"gd", "gl", "gn", "gu", "ha", "he", "hi", "hr", "hu", "hy", "ia", "id",
			"ie", "ik", "in", "is", "it", "iu", "iw", "ja", "ji", "jw", "ka", "kk",
			"kl", "km", "kn", "ko", "ks", "ku", "ky", "la", "ln", "lo", "lt", "lv",
			"mg", "mi", "mk", "ml", "mn", "mo", "mr", "ms", "mt", "my", "na", "ne",
			"nl", "no", "oc", "om", "or", "pa", "pl", "ps", "pt", "qu", "rm", "rn",
			"ro", "ru", "rw", "sa", "sd", "sg", "sh", "si", "sk", "sl", "sm", "sn",
			"so", "sq", "sr", "ss", "st", "su", "sv", "sw", "ta", "te", "tg", "th",
			"ti", "tk", "tl", "tn", "to", "tr", "ts", "tt", "tw", "ug", "uk", "ur",
			"uz", "vi", "vo", "wo", "xh", "yi", "yo", "za", "zh", "zu"
			);
	}
}
<?php
/**
 * The constant of mvc framework.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-19
 */
abstract class Constant{

    /**
     * Action目录名
     * @var string
     */
    const ACTION_DIRECTION_NAME = 'actions';

	/**
	 * 模块配置名
	 * @var string
	 */
	const MODULE_CONFIG_FILE_NAME = 'config.php';
	
	/**
	 * 模块公开服务类的类名后缀部分
	 * Enter description here ...
	 * @var unknown_type
	 */
	const MODULE_OPEN_SERVICE_CLASS_NAME_SUFFIX = 'OpenService';
	
	/**
	 * 模型配置后缀名
	 * @var string
	 */
	const MODEL_CONFIG_SUFFIX = '.config.php';
	
	/**
	 * POST FROM中模型数据的前缀
	 * @var string
	 */
	const MODEL_PARAM_PREFIX = 'm_';
	
	/**
	 * 
	 * 框架用到的编译目录名
	 * @var string
	 */
	const COMPILED_DIRECTION_NAME = 'compiled';
	
	/**
	 * 包描述文件名
	 * @var string
	 */
	const PACKET_DESC_FILE_NAME = 'packet.php';
	
	/* Templage Constant*/
	
	/**
	 * The blank character.
	 */
	const BLANK = ' ';
	
	/**
	 * The start flag of php script.
	 */
	const PHP_START_TAG = '<?php';
	
	/**
	 * The end flag of php script.
	 */
	const PHP_END_TAG = '?>';
	
	/**
	 * line separator of php.
	 */
	const PHP_LINE_SEPARATOR = ';';
	
	/**
	 * The default tag self parse
	 */
	const TAG_DEFULT_PARSE = 'defaults';
	
	/**
	 * The value tag self parse
	 */
	const TAG_VALUE_PARSE = 'values';
	
	/**
	 * The literal tag name
	 * @var string
	 */
	const TAG_NAME_LITERAL = 'literal';
	
	/* I18N Constant*/
	
	/**
	 * the var name of base name.
	 */
	const I18N_BASE_NAME_VAR = 'i18n_name';
	
	/**
	 * the var name of locale.
	 */
	const I18N_LOCALE_VAR = 'i18n_locale';
	
	/**
	 * 换行符
	 * @var string
	 */
	const LINE_END_CHAR = "\n";
	
	/**
	 * 键值文件存储目录
	 * @var string
	 */
	const CACHE_FILE_DIRECTORY = "cache";
}
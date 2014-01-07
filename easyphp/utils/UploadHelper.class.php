<?php

/**
 * 上传帮助类
 * @author blueyb.java@gmail.com
 * @since 1.0 - Feb 28, 2012
 */
class UploadHelper {
	
	/**
	 * 上传文件大小限制，如果不大于0表示服务器配置的上传文件大小限制
	 * @var int
	 */
	private $maxFileSize; 
	
	/**
	 * 接受的文件类型
	 * @var string 多个类型用|分隔
	 * @example  setAcceptType("image|audio|video")
	 */
	private $acceptType;
	
	/**
	 * 拒绝的文件类型
	 * @var string
	 * @example  setRefuseType("application|text")
	 */
	private $refuseType;
	
	/**
	 * 接受的文件扩展
	 * @var string 多个扩展名用|分隔
	 * @example  setAcceptExt("jpg|gif|png|mp3|wma")
	 */
	private $acceptExt;
	
	/**
	 * 上传目录
	 * @var string
	 */
	private $uploadDir;
	
	/**
	 * 拒绝的文件扩展
	 * @var string
	 * @example  setRefuseExt("php|asp|aspx|jsp|exe|com")
	 */
	private $refuseExt;
	
	/**
	 * 上传错误码
	 * 0:无错误 
	 * 1:上传失败 
	 * 2:文件已存在(不覆盖模式上传) 
	 * 3:非法的文件类型 
	 * 4:非法的文件扩展名 
	 * 5:文件大小为零或超出限制 
	 * 6:创建目录失败
	 * @var int
	 */
	private $error = 0; 
	

	/**
	 * 创建一个上传器
	 * @param int $maxFileSize	单个文件大小限制
	 * @param string $acceptExt 允许的扩展名
	 * @param string $refuseExt	拒绝的扩展名
	 * @param string $acceptType	允许的类型
	 * @param string $refuseType	拒绝的类型
	 */
	function __construct($maxFileSize = 0, $acceptExt = '', $refuseExt = '', $acceptType = '', $refuseType = '') {
		$maxFileSize = $maxFileSize <= 0 ? ( int ) ini_get ( 'upload_max_filesize' ) * 1048576 : $maxFileSize;
		$this->setMaxFileSize($maxFileSize);
		$this->setAcceptExt ( $acceptExt );
		$this->setRefuseExt ( $refuseExt );
		$this->setAcceptType ( $acceptType );
		$this->setRefuseType ( $refuseType );
	}
	
	/**
	 * 把表单中存在的文件全部上传保存到指定目录，不改文件名.
	 * @param string $uploadDir 保存目录
	 * @param boolean $overwrite 是否覆盖同名文件，默认是覆盖
	 */
	function save($uploadDir = '', $overwrite = true) {
		$this->setUploadDir ( $uploadDir );
		$uploadDir = $this->getUploadDir();
		$i = 0;
		foreach ($_FILES as $file ) {
			$isOk [$i] ['src'] = $file ['name'];
			$isOk [$i] ['dst'] = false;
			if ($this->checkFileSize( $file ) && $this->checkFileType ( $file ) && $this->checkFileExt ( $file )) {
				if ($overwrite || ! file_exists ( $uploadDir . $file ['name'] ))
					if (move_uploaded_file ( $file ['tmp_name'], $uploadDir . $file ['name'] )) {
						$isOk [$i] ['src'] = $file ['name'];
						$isOk [$i] ['dst'] = $file ['name'];
					} else {
						$this->error = 1;
					}
				else {
					$this->error = 2;
				}
			}
			$i ++;
		}
		return $isOk;
	}
	
	/**
	 * 把表单中存在的文件全部上传保存到指定目录，用时间作文件名.
	 * @param string $uploadDir 保存目录
	 * @param boolean $overwrite 是否覆盖同名文件，默认是覆盖
	 */
	function saveWithTimeStampName($uploadDir = '', $overwrite = 1) {
		$this->setUploadDir ( $uploadDir );
		$uploadDir = $this->getUploadDir();
		$i = 0;
		$j = 0;
		foreach ( $_FILES as $file ) {
			$isOk [$j] ['src'] = $file ['name'];
			$isOk [$j] ['dst'] = false;
			if ($this->checkFileSize( $file ) && $this->checkFileType( $file ) && $this->checkFileExt ( $file )) {
				if ($overwrite || ! file_exists ( $uploadDir . $file ['name'] )) {
					if (! $i) {
						list ( $usec ) = explode ( ' ', microtime () );
						$usec = substr ( $usec, 2, 6 );
						$file_name = date ( "ymdHis" ) . $usec;
					}
					$full_file_name = $file_name . "_" . $i . "." . $this->getFileExt ( $file ['name'] );
					if (move_uploaded_file ( $file ['tmp_name'], $uploadDir . $full_file_name )) {
						$isOk [$j] ['src'] = $file ['name'];
						$isOk [$j] ['dst'] = $full_file_name;
					} else {
						$this->error = 1;
					}
					$i ++;
				} else {
					$this->error = 2;
				}
			}
			$j ++;
		}
		return $isOk;
	}
	
	/**
	 * 保存表单中的指定文件到指定目录,不改名
	 * @param string $formFile 文件在$_FILES中的下标
	 * @param string $uploadDir 保存目录
	 * @param boolean $overwrite 是否覆盖同名文件，默认是覆盖
	 */
	function saveFile($formFile, $uploadDir = '', $overwrite = 1) {
		return $this->saveFileAs ( $formFile, $_FILES [$formFile] ['name'], $uploadDir, $overwrite );
	}
	
	/**
	 * 保存表单中的指定文件到指定目录,用时间作文件名.
	 * @param string $formFile 文件在$_FILES中的下标
	 * @param string $uploadDir 保存目录
	 * @param boolean $overwrite 是否覆盖同名文件，默认是覆盖
	 */
	function saveFileWithTimeStampName($formFile, $uploadDir = '', $overwrite = 1) {
		list ( $usec ) = explode ( ' ', microtime () );
		$usec = substr ( $usec, 2, 6 );
		$full_file_name = date ( "ymdHis" ) . "$usec." . $this->getFileExt ( $_FILES [$formFile] ['name'] );
		if ($this->saveFileAs ( $formFile, $full_file_name, $uploadDir, $overwrite ))
			return $full_file_name;
		else
			return false;
	}
	
	/**
	 * 保存表单中的指定文件到指定目录,用指定的文件名.
	 * @param string $formFile 文件在$_FILES中的下标
	 * @param string $fileName 要保存的文件名
	 * @param string $uploadDir 保存目录
	 * @param boolean $overwrite 是否覆盖同名文件，默认是覆盖
	 */
	function saveFileAs($formFile, $fileName, $uploadDir = '', $overwrite = 1) {
		$this->setUploadDir ($uploadDir);
		$uploadDir = $this->getUploadDir();
		$isOk = false;
		$file = $_FILES [$formFile];
		if ($this->checkFileSize($file) && $this->checkFileType($file) && $this->checkFileExt( $file)) {
			if ($overwrite || ! file_exists ( $uploadDir . $fileName )) {
				if (move_uploaded_file ( $file ['tmp_name'], $uploadDir . $fileName ))
					$isOk = true;
				else
					$this->error = 1;
			} else {
				$this->error = 2;
			}
		}
		return $isOk;
	}
	
	
	/**
	 * @return the $maxFileSize
	 */
	public function getMaxFileSize() {
		return $this->maxFileSize;
	}

	/**
	 * @param int $maxFileSize
	 */
	public function setMaxFileSize($maxFileSize) {
		$this->maxFileSize = $maxFileSize;
	}

	/**
	 * @return the $acceptType
	 */
	public function getAcceptType() {
		return $this->acceptType;
	}

	/**
	 * @param string $acceptType
	 */
	public function setAcceptType($acceptType) {
		$this->acceptType = $acceptType;
	}

	/**
	 * @return the $refuseType
	 */
	public function getRefuseType() {
		return $this->refuseType;
	}

	/**
	 * @param string $refuseType
	 */
	public function setRefuseType($refuseType) {
		$this->refuseType = $refuseType;
	}

	/**
	 * @return the $acceptExt
	 */
	public function getAcceptExt() {
		return $this->acceptExt;
	}

	/**
	 * @param string $acceptExt
	 */
	public function setAcceptExt($acceptExt) {
		$this->acceptExt = $acceptExt;
	}

	/**
	 * @return the $refuseExt
	 */
	public function getRefuseExt() {
		return $this->refuseExt;
	}

	/**
	 * @param string $refuseExt
	 */
	public function setRefuseExt($refuseExt) {
		$this->refuseExt = $refuseExt;
	}
	
	/**
	 * @return the $uploadDir
	 */
	public function getUploadDir() {
		return $this->uploadDir;
	}
	
/**
	 * 设置上传目录,格式化并创建上传目录
	 * @param string $uploadDir
	 */
	public function setUploadDir($uploadDir) {
		$uploadDir = preg_replace ( "/[\\\\\/]+/", '/', trim ( $uploadDir ) );
		if (!$uploadDir) return;
		if (substr ( $uploadDir, - 1 ) != '/'){
			$uploadDir .= '/';
		}
		//创建目录
		$arr_dir = explode ( '/', $uploadDir );
		$dir_tmp = '';
		foreach ( $arr_dir as $en ) {
			$dir_tmp .= $en . '/';
			if (! file_exists ( $dir_tmp )) {
				if (! @mkdir ( $dir_tmp )) {
					$this->error = 6;
					return false;
				}
			}
		}
		$this->uploadDir = $uploadDir;
	}

	/**
	 * 获取最后的错误代码
	 * @return int
	 */
	public function getErrorCode() {
		return $this->error;
	}
	
	/**
	 * 获取最后的错误信息
	 * @return string
	 */
	public function getErrorMessage() {
		switch ($this->error) {
			case 0 :
				$errorMessage = "没有错误";
				break;
			case 1 :
				$errorMessage = "上传失败";
				break;
			case 2 :
				$errorMessage = "文件已存在";
				break;
			case 3 :
				$errorMessage = "非法的文件类型";
				break;
			case 4 :
				$errorMessage = "非法的文件扩展名";
				break;
			case 5 :
				$errorMessage = "文件大小为零或超出限制" . ($this->maxFileSize / 1024) . "K";
				break;
			case 6 :
				$errorMessage = "创建目录失败";
				break;
		}
		return "错误" . $this->error . "：{$errorMessage}。";
	}
	
	/**
	 * 获取文件类型
	 * @param string $fileType
	 */
	public function getFileType($fileType) { 
		$i = strrpos ( $fileType, "/" );
		if ($i > 0)
			return substr ( $fileType, 0, $i );
		else
			return "";
	}
	
	/**
	 * 获取文件扩展名
	 * @param string $fileName 文件名
	 * @return string
	 */
	public function getFileExt($fileName) {
		$i = strrpos ( $fileName, "." );
		if ($i > 0)
			return substr ( $fileName, $i + 1 );
		else
			return "";
	}
	
	/**
	 * 获取上传文件域对应文件大小
	 * @param string $fileName　文件在$_FILES中的下标
	 * @return int
	 */
	public function getFileSize($fileName) {
		return $_FILES [$fileName]['size'];
	}
	
	/**
	 * 获取上传表单中全部文件大小
	 * @return int
	 */
	public function getAllFileSize() {
		$i = 0;
		foreach ( $_FILES as $file ) {
			$allFileSizes [$i] = $file ['size'];
			$i ++;
		}
		return $allFileSizes;
	}
	
	/**
	 * 获取上传文件的名称
	 * @param string $formFile 文件在$_FILES中的下标
	 * @return string 
	 */
	public function getFileName($formFile) {
		return $_FILES [$formFile] ['name'];
	}
	
	/**
	 * 获取上传表单中全部文件名
	 * @return array
	 */
	public function getAllFileNames() {
		$i = 0;
		foreach ( $_FILES as $file ) {
			$allFileNames [$i] = $file ['name'];
			$i ++;
		}
		return $allFileNames;
	}
	
	/**
	 * 检查文件类型是否被允许
	 * @param Resource(file) $file
	 */
	protected function checkFileType($file) { //检查文件类型是否被允许
		if ($this->acceptType != "") {
			if (! preg_match ( '/'.$this->acceptType.'/', $this->getFileType ( $file ['type'] ) )) {
				$this->error = 3;
				return false;
			}
		}
		if ($this->refuseType != "") {
			if (preg_match ( '/'.$this->refuseType.'/', $this->getFileType ( $file ['type'] ) )) {
				$this->error = 3;
				return false;
			}
		}
		return true;
	}
	
	/**
	 * 检查文件扩展名是否超出限制
	 * @param Resource(file) $file 
	 */
	protected function checkFileExt($file) {
		if ($this->acceptExt != "") {
			if (! preg_match ( '/'.$this->acceptExt.'/', $this->getFileExt ( $file ['name'] ) )) {
				$this->error = 4;
				return false;
			}
		}
		if ($this->refuseExt != "") {
			if (preg_match ( '/'.$this->refuseExt.'/', $this->getFileExt ( $file ['name'] ) )) {
				$this->error = 4;
				return false;
			}
		}
		return true;
	}
	
	/**
	 * 检查文件大小是否超出限制
	 * @param Resource(file) $file 
	 */
	protected function checkFileSize($file) {
		if ($file ['size'] > 0) {
			if ($this->maxFileSize > 0) {
				if ($file ['size'] > $this->maxFileSize) {
					$this->error = 5;
					return false;
				}
			}
			return true;
		} else {
			$this->error = 5;
			return false;
		}
	}
	
	/**
	 * 创建正则表达式
	 * @param string $str
	 */
	protected function makeRegex($str) { 
		$str = trim ( $str );
		if ($str) {
			$str = preg_replace ( "/\b/", "\b", $str );
			$str = "/" . $str . "/i";
		}
		return $str;
	}
}
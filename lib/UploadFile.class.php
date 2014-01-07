<?php

class UploadFile {

    // 附件类型
    public $type		= array();   
	// 目录层次 最大10层
    public $dirLevel	= 4;
    // 是否为用户模式，在顶层目录上 加上用户ID  dirType：date level：4 可用
    public $userMode	= true;
	// 子目录创建方式 可以使用hash date	
    public $dirType		= 'date';
    // 上传文件保存路径
    public $savePath	= '';
	// 是否自动检查附件
    public $autoCheck	= true;
    // 上传文件命名规则
    // 例如可以是 time uniqid com_create_guid 等
    // 必须是一个无需任何参数的函数名 可以使用自定义函数
    public $saveRule	= 'uniqid';
    // 上传文件Hash规则函数名
    // 例如可以是 md5_file sha1_file 等
    public $hashType	= 'md5_file';

    // 错误信息
    private $error		= '';

    // 上传成功的文件信息
    private $fileInfo ;

    public function __construct($type=array(), $userMode=true) {    	
        $this->type = $type;
        $this->userMode = $userMode;
        $this->savePath = get_config('attach_filepath');
    }

    private function save($file) {
        $filename = $file['savepath'].$file['savename'];
        if(is_file($filename)) {
            // 不覆盖同名文件
            $this->error = '文件已经存在！'.$filename;
            return false;
        }
        if(!move_uploaded_file($file['tmp_name'], $filename)) {
            $this->error = '文件上传保存错误！';
            return false;
        }

        return true;
    }

    /**
     +----------------------------------------------------------
     * 上传所有文件
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $savePath  上传文件保存路径
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function upload($savePath='') {
        //如果不指定保存文件名，则由系统默认
        if(empty($savePath)) $savePath = $this->savePath;
        // 检查上传目录
        if(!is_dir($savePath)) {
            // 检查目录是否编码后的
            if(is_dir(base64_decode($savePath))) {
                $savePath = base64_decode($savePath);
            }else{
                // 尝试创建目录
                if(!$this->makeDir($savePath)){
                    $this->error  =  '上传目录'.$savePath.'不存在';
                    return false;
                }
            }
        }else {
            if(!is_writeable($savePath)) {
                $this->error  =  '上传目录'.$savePath.'不可写';
                return false;
            }
        }

        $fileInfo = array();
        $isUpload = false;

        // 获取上传的文件信息
        // 对$_FILES数组信息处理
        $files = $this->dealFiles($_FILES);
        foreach($files as $file) {
            //过滤无效的上传
            if(!empty($file['name'])) {
                //登记上传文件的扩展信息
                $file['extension']	= $this->getExt($file['name']);
                $file['savepath']	= $savePath;
                $file['savename']	= $this->getSaveName($file);
                $file['title']		= basename($file['name'], '.'.$file['extension']);
                $file['group']		= $this->type[$file['extension']]['group'];                
                $file['hash']		= call_user_func($this->hashType, $file['tmp_name']);                            
                
                // 检查文件重复
                //$repet = $this->checkRepet($file);
                
                // 自动检查附件
                if(!$repet && $this->autoCheck) {
                    if(!$this->check($file)) return false;
                }
                
                //保存上传文件
                if(!$repet && !$this->save($file)) return false;                
                //上传成功后保存文件信息，供其他地方调用
                unset($file['tmp_name'], $file['error']);
                $fileInfo[] = $file;
                $isUpload = true;
            }
        }
        if($isUpload) {
            $this->fileInfo = $fileInfo;
            return true;
        }else {
            $this->error = '没有选择上传文件';
            return false;
        }
    }

    /**
     +----------------------------------------------------------
     * 转换上传文件数组变量为正确的方式
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param array $files  上传的文件变量
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    private function dealFiles($files) {
       $fileArray = array();
       $n = 0;
       foreach ($files as $file){
           if(is_array($file['name'])) {
               $keys = array_keys($file);
               $count = count($file['name']);
               for ($i=0; $i<$count; $i++) {
                   foreach ($keys as $key)
                       $fileArray[$n][$key] = $file[$key][$i];
                   $n++;
               }
           }else{
               $fileArray[$n] = $file;
               $n++;
           }
       }
       return $fileArray;
    }

    /**
     +----------------------------------------------------------
     * 获取错误代码信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param string $errorNo  错误号码
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     */
    protected function error($errorNo) {
         switch($errorNo) {
            case 1:
                $this->error = '上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值';
                break;
            case 2:
                $this->error = '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值';
                break;
            case 3:
                $this->error = '文件只有部分被上传';
                break;
            case 4:
                $this->error = '没有文件被上传';
                break;
            case 6:
                $this->error = '找不到临时文件夹';
                break;
            case 7:
                $this->error = '文件写入失败';
                break;
            default:
                $this->error = '未知上传错误！';
        }
        return ;
    }

    /**
     +----------------------------------------------------------
     * 根据上传文件命名规则取得保存文件名
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $filename 数据
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    private function getSaveName($file) {
        $rule = $this->saveRule;
        if(empty($rule)) {//没有定义命名规则，则保持文件名不变
            $saveName = $file['name'];
        }else {
            if(function_exists($rule)) {
                //使用函数生成一个唯一文件标识号
                $saveName = $rule().".".$file['extension'];
            }else {
                //使用给定的文件名作为标识号
                $saveName = $rule.".".$file['extension'];
            }
        }
        if($this->dirLevel) {
            // 使用子目录保存文件
            $file['savename'] = $saveName;
            $saveName = $this->getSubName($file).$saveName;
        }
        return $saveName;
    }

    /**
     +----------------------------------------------------------
     * 获取子目录的名称
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param array $file  上传的文件信息
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    private function getSubName($file) {
        switch($this->dirType) {
            case 'date':
				$dir = '';
				$timestamp = time();
				switch($this->dirLevel) {
					case 1:
						$dir = date('Y', $timestamp).'/';
						break;
					case 2:
						$dir = date('Y', $timestamp).'/'.date('m', $timestamp).'/';
						break;
					case 3:
						$dir = date('Y', $timestamp).'/'.date('m', $timestamp).'/'.date('d', $timestamp).'/';
						break;
					case 4:						
						$uid = $this->userMode ? intval(HttpSession::get('uid')) : 0;
						$dir = $uid.'/'.date('Y', $timestamp).'/'.date('m', $timestamp).'/'.date('d', $timestamp).'/';
						break;
					default:
						$dir = date('Y-m-d', $timestamp).'/';
				}
                break;
            case 'hash':
            default:
                $name = md5($file['savename']);
				$this->dirLevel = min($this->dirLevel, 10);
                $dir = '';
                for($i=0;$i<$this->dirLevel;$i++) {
                    $dir .= $name{$i}.'/';
                }
                break;
        }
        if(!is_dir($file['savepath'].$dir)) {
            $this->makeDir($file['savepath'].$dir);
        }
        return $dir;
    }

	private function makeDir($path) {
		return mkdir($path, 0755, true);
	}

    /**
     +----------------------------------------------------------
     * 检查上传的文件
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param array $file 文件信息
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function check($file) {
        if($file['error']!== 0) {
            //文件上传失败
            //捕获错误代码
            $this->error($file['error']);
            return false;
        }
        //文件上传成功，进行自定义规则检查
        //检查文件大小        
        if(!$this->checkSize($file['extension'], $file['size'])) {
            $this->error = '上传文件大小不符！';
            return false;
        }

        //检查文件类型
        if(!$this->checkExt($file['extension'])) {
            $this->error ='上传文件类型不允许';
            return false;
        }

        //检查是否合法上传
        if(!$this->checkUpload($file['tmp_name'])) {
            $this->error = '非法上传文件！';
            return false;
        }
        return true;
    }

    
    private function checkRepet(&$file) {    	
    	$Attach = MD('ExtendAttach');
    	$Attach = $Attach->gets("hash='$file[hash]'");
    	
    	if(empty($Attach)) {
    		return false;
    	} else {
    		$Attach = array_shift($Attach);
    		$file['name']		= $Attach['filename'].'.'.$Attach['ext'];
    		$file['savename']	= $Attach['filepath'];
    		$file['attach_id']	= $Attach['attach_id'];
    		return true;
    	}    	
    }
    
    /**
     +----------------------------------------------------------
     * 检查上传的文件后缀是否合法
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $ext 后缀名
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function checkExt($ext) {
        if(!empty($this->type))
			return in_array(strtolower($ext), array_keys($this->type));
        return true;
    }

    /**
     +----------------------------------------------------------
     * 检查文件大小是否合法
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param integer $size 数据
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function checkSize($ext, $size) {
        return empty($this->type[$ext]['maxsize']) || ($this->type[$ext]['maxsize'] > $size);
    }

    /**
     +----------------------------------------------------------
     * 检查文件是否非法提交
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $filename 文件名
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function checkUpload($filename) {
        return is_uploaded_file($filename);
    }

    /**
     +----------------------------------------------------------
     * 取得上传文件的后缀
     +----------------------------------------------------------
     * @access private
     +----------------------------------------------------------
     * @param string $filename 文件名
     +----------------------------------------------------------
     * @return boolean
     +----------------------------------------------------------
     */
    private function getExt($filename) {
        $pathinfo = pathinfo($filename);
        return $pathinfo['extension'];
    }

    /**
     +----------------------------------------------------------
     * 取得上传文件的信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return array
     +----------------------------------------------------------
     */
    public function getFileInfo() {
        return $this->fileInfo;
    }

    /**
     +----------------------------------------------------------
     * 取得最后一次错误信息
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */
    public function getErrorMsg() {
        return $this->error;
    }

}
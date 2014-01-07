<?php

/**
 * EasyPHP框架的类依赖处理机制,在各个类文件中引入自己需要的类文件,Packet类就是为这个处理机制
 * 提供功能支持.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-06-12
 */
Class EasyPacket{
	
	/**
	 *	API包路径
	 * @var string
	 */
	private $packetRoot;
	
	/**
	 * 其它需要被编译的API目录
	 * @var array/string
	 */
	private $contains;
	
	/**
	 * 整个API包结构
	 * @var array
	 */
	private $packets;
	
	/**
	 * 编译文件存放路径
	 * @var string
	 */
	private $compilePath;
	
	/**
	 * 包描述文件的名称
	 * @var string
	 */
	private $packetDescFileName;
	
	/**
	 * 构造一个包
	 * @param string $packetRoot
	 */
	public function __construct($packetRoot){
		$this->packetRoot = $packetRoot;
		$this->contains = array();
	}
	
	/**
	 * 设置API包路径
	 * @param string $packetRoot
	 * @return this instance
	 */
	public function setPacketRoot($packetRoot){
		$this->packetRoot = $packetRoot;
		return $this;
	}
	
	/**
	 * 获取包根目录
	 */
	public function getPacketRoot(){
		return $this->packetRoot;
	}
	
	/**
	 * 包含一个外部目录
	 * @return this
	 */
	public function contain($packet){
		$this->contains[] = $packet;
		return $this;
	}
	
	/**
	 * @return the $compilePath
	 */
	public function getCompilePath() {
		return $this->compilePath;
	}

	/**
	 * @param string $compilePath
	 * @return this
	 */
	public function setCompilePath($compilePath) {
		$this->compilePath = $compilePath;
		return $this;
	}

	/**
	 * @return the $packetDescFileName
	 */
	public function getPacketDescFileName($packet) {
		return $this->compilePath . 'packets' . DIRECTORY_SEPARATOR . md5($packet) . '.php';
	}

	/**
	 * @param string $packetDescFileName
	 * @return this
	 */
	public function setPacketDescFileName($packetDescFileName) {
		$this->packetDescFileName = $packetDescFileName;
		return $this;
	}

	/**
	 * 解析并编译包
	 * @param boolean $force 是否强制编译
	 * @return this
	 */
	public function complie($force){
		if(!file_exists($this->getCompilePath())){
			die("EasyPHP框架配置的编译目录{$this->getCompilePath()}不存在");
		}
		//编译EASYPHP
		$compiledPacketFile = $this->getCompiledPacketFile($this->packetRoot);
		if($force || !file_exists($compiledPacketFile)){
			$this->compliePacket($this->packetRoot);
		}
		$this->packets = include($compiledPacketFile);

		//编译包含的目录
		if($this->contains){
			foreach($this->contains as $packet){
				$compiledPacketFile = $this->getCompiledPacketFile($packet);
				if($force || !file_exists($compiledPacketFile)){
					$this->compliePacket($packet);
				}
				$packets = include($compiledPacketFile);
				if($packets){
					$this->packets = array_merge($this->packets, $packets); //@tag 这里会覆盖掉easyphp中的某些包(如.*下的包)
				}
			}
		}
		
		return $this;
	}
	
	/**
	 * 设置自己为autoload处理函数
	 * @return this
	 */
	public function asAutoLoad(){
		spl_autoload_register(array($this, 'import'));
		return $this;
	}
	
	/**
	 * 注销自己作为autoload处理函数的资格
	 * @return this
	 */
	public function unAsAutoLoader(){
		spl_autoload_unregister(array($this, 'import'));
		return $this;
	}
	
	/**
	 * 引入包或API文件
	 * @param string $path
	 * 	API包路径,格式为"action.matcher.ActionMatcher"或"action.matcher.*"
	 *  当以*符号结尾时会引入整个目录的脚本文件,但不包含子目录.
	 */
	public function import($path){
		$scripts = $this->packets[$path];
		if(is_string($scripts)){
			return require($scripts);
		}else{
			foreach($scripts as $script){
				require($scripts);
			}
		}
	}
	
	/**
	 * 是否存在指定类名的类文件
	 * @param string $class 类文件
	 */
	public function classExists($class){
		return isset($this->packets[$class]);
	}
	
	/**
	 * 编译API包
	 */
	private function compliePacket($packet){
		$this->createPacketDesc($packet);
		$compiledPacketFile = $this->getCompiledPacketFile($packet);
		$packets = $this->__compliePacket($packet, '');
		$packetContent =   "<?php\r\n\r\nreturn " . var_export($packets, true) . ";\r\n\r\n";
		file_put_contents($compiledPacketFile, $packetContent, LOCK_EX);
	}
	
	/**
	 * 编译API包
	 * @param string $context 当前包的上下文，相对于packet root.
	 */
	private function __compliePacket($packet, $context){
		$contextDir = $packet . str_replace('.', DIRECTORY_SEPARATOR, $context) . DIRECTORY_SEPARATOR;
		$packetDesc = $this->createPacketDesc($contextDir);	//一个目录的包结构数据
		if(!$packetDesc){
			return null;
		}
		$packetDescs = array();	//保存所有的包结构数据
		if($packetDesc['scripts']){
			//构造脚本包路径
			$dirScripts = array();	//包里的所有脚本
			foreach($packetDesc['scripts'] as $name=>$script){
				if($context){
					$packetDescs["{$context}.{$name}"] = $contextDir . $script;
				}
				$packetDescs[$name] = $contextDir . $script;
				$dirScripts[] =  $contextDir . $script;
			}
			//构造目录包路径
			if(empty($context)){
				$packetDescs['.*'] = $dirScripts;
			}else{
				$packetDescs["{$context}.*"] = $dirScripts;
			}
		}
		if($packetDesc['packets']){
			foreach($packetDesc['packets'] as $name){
				if(empty($context)){
					$subContext = $name;
				}else{
					$subContext = $context . '.' . $name;
				}
				
				$subPackets = $this->__compliePacket($packet, $subContext);
				if($subPackets){
					$packetDescs = array_merge($packetDescs, $subPackets);
					unset($subPackets);
				}
			}
		}
		return $packetDescs;
	}
	
	/**
	 * 为包生成包描述文件
	 * @param string $packet 要解析的包根目录
	 * @return array/null;
	 */
	public function createPacketDesc($packet){
		include_once(dirname(__FILE__) . '/utils/FileUtil.class.php');
		include_once(dirname(__FILE__) . '/utils/String.class.php');
		$fileList = FileUtil::listDir($packet);
		$scripts = array();
		$packets = array();
		foreach($fileList as $file){
			$basename = basename($file);
			if(is_dir($file)){
				if($basename[0] != '.'){
					//过滤以.开头的目录，比如.svn
					$packets[$basename] = $basename;
				}
			}elseif(String::endWith($file, '.class.php')){
				//是类文件
				$scripts[basename($file, '.class.php')] = basename($file);
			}
		}
		if($scripts || $packets){
			$packetContent = array('scripts'=>$scripts, 'packets'=>$packets);
			return $packetContent;
		}
		return null;
	}
	
	/**
	 * 获取编译后的包描述文件
	 * @param string $packetRoot
	 */
	private function getCompiledPacketFile($packet){
		$compiledPacketFile = pathinfo($packet, PATHINFO_BASENAME)  . '.php';
		$compiledPacketFile = $this->getCompilePath() . $compiledPacketFile;
		return $compiledPacketFile;
	}
}
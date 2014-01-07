<?php
/**
 * 从数据库生成模型类的工具类
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-03-02
 */
class ModelClassBuilder{
	
	/**
	 * 数据库操作类,实现query()接口
	 * 
	 * @var DB
	 */
	private $db;
	
	/**
	 * 存储类文件输出路径
	 * 
	 * @var string
	 */
	private $outPutDir;
	
	/**
	 * 类文件的后缀名，默认后缀为class.php
	 * 
	 * @var string
	 */
	private $fileSuffix;
	
	/**
	 * 类注释
	 * 
	 * @var string
	 */
	private $noteClass;
	
	/**
	 * 变量注释
	 * 
	 * @var string
	 */
	private $noteVar;
	
	/**
	 * get方法注释
	 * 
	 * @var string
	 */
	private $noteGetMethod;
	
	/**
	 * set方法注释
	 * 
	 * @var string
	 */
	private $noteSetMethod;
	
	private $theDataTemp;
	private $theGetMethodTemp;
	private $theSetMethodTemp;
	private $placeholderClass;
	private $placeholderDataName;
	private $placeholderParam;
	private $placeholderDescription;
	private $theClass;
	private $shitf;
	private $tab;
	
	/**
	 *
	 *
	 * 构造方法
	 * 
	 * @param $db 当前数据库,实现query()接口，返回结果集        	
	 * @param String $outPutDir
	 *        	(可选参数)存储类文件输出路径,默认为当前目录下
	 * @param String $fileSuffix
	 *        	(可选参数)类文件的后缀名，默认后缀为class.php
	 */
	public function __construct($db, $outPutDir = null, $fileSuffix = null){
		$this->db = $db;
		if($outPutDir != null){
			$this->outPutDir = $outPutDir;
		}else{
			$this->outPutDir = "";
		}
		
		if($fileSuffix != null){
			$this->fileSuffix = $fileSuffix;
		}else{
			$this->fileSuffix = "class.php";
		}
		$this->head = ' * ';
		$this->tab = "\t";
		$this->shitf = "\r\n";
		$this->start = '/**' . $this->shitf;
		$this->end = ' */' . $this->shitf;
		$this->blank = ' * ' . $this->shitf;
		$this->placeholderType = '&unknown_type';
		$this->placeholderClass = '&classname';
		$this->placeholderDataName = '&dataname';
		$this->placeholderParam = '&value';
		$this->placeholderDescription = 'Enter description here ...';
		
		$this->noteClass = $this->start;
		$this->noteClass .= $this->head . '@author blueyb.java@gmail.com' . $this->shitf;
		$this->noteClass .= $this->head . '@since 1.0 ' . date('Y-m-d') . $this->shitf;
		$this->noteClass .= $this->blank;
		$this->noteClass .= $this->end;
		
		
		$this->noteVar = $this->tab . $this->start;
		$this->noteVar .= $this->tab . $this->head . $this->placeholderDescription . ' ' . $this->shitf;
		$this->noteVar .= $this->tab . $this->head . "@var {$this->placeholderType} " . $this->shitf;
		$this->noteVar .= $this->tab . $this->end;
		
		
		$this->noteGetMethod = $this->tab . $this->start;
		$this->noteGetMethod .= $this->tab . $this->blank;
		$this->noteGetMethod .= $this->tab . $this->head  . "@return {$this->placeholderType} " . $this->shitf;
		$this->noteGetMethod .= $this->tab . $this->end;
		

		$this->noteSetMethod = $this->tab . $this->start;
		$this->noteSetMethod .= $this->tab . $this->blank;
		$this->noteSetMethod .= $this->tab . $this->head  . "@param {$this->placeholderType} ${$this->placeholderParam} " . $this->shitf;
		$this->noteSetMethod .= $this->tab . $this->end;
		
		$this->theDataTemp = $this->shitf . $this->noteVar . $this->tab . 'private $&value;' . $this->shitf;
		
		$this->theClass = '<?php' . $this->shitf . $this->noteClass . $this->note . 'class &classname{';
		
		$this->theGetMethodTemp = $this->shitf . $this->noteGetMethod . $this->tab . 'public function get&dataname(){ ' . $this->shitf . $this->tab . $this->tab . 'return $this->&value;' . $this->shitf . $this->tab . '}' . $this->shitf;
		
		$this->theSetMethodTemp = $this->shitf . $this->noteSetMethod . $this->tab . 'public function set&dataname($&value){ ' . $this->shitf . $this->tab . $this->tab . '$this->&value = $&value; ' . $this->shitf . $this->tab . '}' . $this->shitf;
	}
	
	/**
	 *
	 *
	 * 将当前数据库中，指定的一个表生成指定类.
	 * 
	 * @param String $tableName
	 *        	要进行处理的表名
	 * @param $className [可选参数]输出的时候，生成类名与文件名，默认情况为表名        	
	 */
	public function createClassByTable($tableName, $className = null){
		$thsClass = $this->theClass;
		if($className == null){
			$fileName = $tableName;
		}else{
			$fileName = $className;
		}
		$thsClass = $this->strReplace($fileName, $thsClass, $this->placeholderClass);
		$thsClass .= $this->createDataAndMethod($tableName);
		$this->saveClass($this->setFileName($tableName) . '.' . $this->fileSuffix, $thsClass);
	}
	
	/**
	 *
	 *
	 * 将当前数据库中的所有表，生成类文件，类文件的名字、类名与表名相同
	 * 
	 * @param $fileSuffix [可选参数]输出文件的后缀名        	
	 * @param $outPutDir [可选参数]输出文件的路径        	
	 */
	public function createClassAll($fileSuffix = null, $outPutDir = null){
		if($fileSuffix != null){
			$this->setFileSuffix($fileSuffix);
		}
		
		if($outPutDir != null){
			$this->setOutOutDir($outPutDir);
		}
		$sql = "show tables";
		$result = $this->db->query($sql);
		for(; $array = mysql_fetch_array($result);){
			$thsClass = $this->theClass;
			$tableName = $array[0];
			$theClass = $this->strReplace($this->setClassName($tableName), $thsClass, $this->placeholderClass);
			$theClass .= $this->createDataAndMethod($tableName);
			$this->saveClass($this->setFileName($tableName) . '.' . $this->fileSuffix, $theClass);
		}
	}
	
	/**
	 * 数据预处理,将不是分界的逗号替换为*&
	 * 
	 * @param string $data        	
	 * @return string
	 */
	private function preprocessing($data){
		for($start = strpos($data, '('); $start; $start = strpos($data, '(', $start)){
			$start++;
			$isReplace = strpos($data, ')', $start);
			for($preStart = strpos($data, ',', $start), $i = 0; $preStart; $preStart = strpos($data, ',', $preStart + 1)){
				$i++;
				if($isReplace > $preStart){
					$data = substr_replace($data, "*&", $preStart, 1);
				}
			}
		}
		
		for($start = strpos($data, 'COMMENT'); $start; $start = strpos($data, 'COMMENT', $start)){
			$start++;
			$isReplace = strpos($data, '`', $start) - 4;
			for($preStart = strpos($data, ',', $start), $i = 0; $preStart; $preStart = strpos($data, ',', $preStart + 1)){
				$i++;
				if($isReplace > $preStart){
					$data = substr_replace($data, "*&", $preStart, 1);
				}
			}
		}
		return $data;
	}
	
	/**
	 * 将被替换的(,)还原
	 * 
	 * @param string $string        	
	 * @return string
	 */
	private function backupString($string){
		return str_replace('*&', ',', $string);
	}
	
	/**
	 *
	 *
	 * 将数据库的中的注释读取出来
	 * 
	 * @param string $tableName        	
	 *
	 */
	private function setNote($tableName){
		$sql = "show create table " . $tableName;
		$result = $this->db->query($sql);
		$array = mysql_fetch_row($result);
		$start = strpos($array[1], '(');
		$end = strrpos($array[1], 'PRIMARY KEY');
		$data = substr($array[1], $start + 1, $end - $start - 5);
		$data = $this->preprocessing($data);
		$arrayData = explode(',', $data);
		$arrayTemp = array();
		for($i = 0; $i < count($arrayData); $i++){
			$arrayData[$i] = $this->backupString($arrayData[$i]);
			$arrayTemp[] = $this->AnalyseColumn($arrayData[$i]);
		}
		return $arrayTemp;
	}
	
	/**
	 *
	 *
	 * 创建属性，方法
	 * 
	 * @param
	 *        	$tableName
	 */
	private function createDataAndMethod($tableName){
		$theData = null;
		$theGetMethod = null;
		$theSetMethod = null;
		$columnMapName = array();
		$columnMapNameInDb = array();
		
		$sql = "show columns from " . $tableName;
		$columns = $this->db->query($sql);
		
		$arrayData = $this->setNote($tableName);
		
		for($i = 0; $columnNameArray = mysql_fetch_array($columns); $i++){
			$columnNameComment = $arrayData[$i];
			
			if(empty($columnNameArray)) break;
			$columnName = $this->setVarName($columnNameArray[0]);
			$theData .= $this->theDataTemp;
			$theMethod .= $this->theGetMethodTemp . $this->theSetMethodTemp;
			
			// 用于创建Map的缓存数组
			$columnMapName[] = $columnName;
			$columnMapNameInDb[] = $columnNameArray[0];
			$varType = $columnNameArray['Type'];
			$quoteLength = strrpos($varType, '(');
			if($quoteLength){
				$varType = strtolower(substr($varType, 0, $quoteLength));
			}
			$varTypeReplace = $this->placeholderType;
			$varTypeReplace = $this->setVarType($varType);
			
			if(isset($columnNameComment['COMMENT'])){
				$theData = $this->strReplace($columnNameComment['COMMENT'], $theData, $this->placeholderDescription);
			}
			$theData = $this->strReplace($columnName, $theData, $this->placeholderParam);
			$theData = $this->strReplace($varTypeReplace, $theData, $this->placeholderType);
			
			$theMethod = $this->strReplace($columnName, $theMethod, $this->placeholderParam);
			
			
			$theMethod = $this->strReplace($varTypeReplace, $theMethod, $this->placeholderType);
			
			$columnName = ucfirst($columnName);
			
			$theMethod = $this->strReplace($columnName, $theMethod, $this->placeholderDataName);
		
		}
		$theClass .= $this->shitf . $theData . $theMethod . $this->createMap($columnMapName, $columnMapNameInDb) . '}' . $this->shift . '?>';
		return $theClass;
	}
	/**
	 *
	 *
	 * 将数据库中的数据类型转化为程序中的数据类型
	 * 
	 * @param string $varType        	
	 *
	 */
	public function setVarType($varType){
		$varTypeReplace = $this->placeholderType;
		switch($varType){
			case 'int' :
			case 'bigint' :
			case 'smallint' :
			case 'mediumint' :
			case 'tinyint' :
				$varTypeReplace = 'int';
				break;
			case 'char' :
			case 'text' :
			case 'varchar' :
				$varTypeReplace = 'string';
				break;
			case 'float' :
				$varTypeReplace = 'float';
				break;
			case 'double' :
				$varTypeReplace = 'double';
				break;
			case 'enum' :
			default :
				break;
		}
		return $varTypeReplace;
	}
	
	/**
	 * 将数据表中指定列的注释，打包成指定数据类型
	 * 
	 * @param string $column        	
	 */
	private function AnalyseColumn($column){
		$arrayTemp = explode(' ', trim($column));
		$Temp = array();
		for($i = 0; $i < count($arrayTemp); $i++){
			if($arrayTemp[$i] == 'COMMENT'){
				$Temp['COMMENT'] = trim(str_replace("'", ' ', $arrayTemp[$i + 1]));
				break;
			}
		}
		return $Temp;
	}
	
	private function strReplace($columnName, $Temp, $placeholder){
		return str_replace($placeholder, $columnName, $Temp);
	}
	
	/**
	 *
	 *
	 * 保存生成的类
	 * 
	 * @param
	 *        	$filename
	 * @param
	 *        	$classData
	 */
	private function saveClass($filename, $classData){
		if($this->outPutDir != null){
			if(substr($this->outPutDir, -1) != '/' || substr($this->outPutDir, -1) != '\\'){
				$outPutDir = $this->outPutDir . '/';
			}else{
				$outPutDir = $this->outPutDir;
			}
		}else{
			$outPutDir = $this->outPutDir;
		}
		return file_put_contents($outPutDir . $filename, $classData);
	}
	
	/**
	 *
	 *
	 * 创建属性与数据库的映射
	 * 
	 * @param array $columnMapName        	
	 * @param array $columnMapNameInDb        	
	 *
	 */
	public function createMap($columnMapName, $columnMapNameInDb){
		$mapFunction = $this->noteGetMethod . $this->tab . 'public function get&dataname() { ' . $this->shitf . $this->tab . $this->tab . '&definedValue;' . $this->shitf . $this->tab . $this->tab . 'return &value;' . $this->shitf . $this->tab . '}' . $this->shitf;
		$map = '$map = array(';
		for($i = 0; $i < count($columnMapName); $i++){
			if($i != 0){
				$map .= ',';
			}
			$map = $map . $this->shitf;
			$map = $map . $this->tab . $this->tab . $this->tab . $this->tab . $this->tab . '\'' . $columnMapName[$i] . '\'';
			$map = $map . '=>';
			$map = $map . '\'' . $columnMapNameInDb[$i] . '\'';
		}
		$map .= $this->shitf . $this->tab . $this->tab . $this->tab . $this->tab . ')';
		
		$mapFunction = $this->strReplace('Map', $mapFunction, $this->placeholderDataName);
		$mapFunction = $this->strReplace('array', $mapFunction, $this->placeholderType);
		$mapFunction = $this->strReplace('$map', $mapFunction, $this->placeholderParam);
		$mapFunction = $this->strReplace($map, $mapFunction, '&definedValue');
		return $mapFunction;
	}
	
	/**
	 *
	 *
	 * 生成变量名
	 * 
	 * @param String $columnName        	
	 */
	public function setVarName($columnName){
		$arrayTemp = explode('_', $columnName);
		$stringTemp = array_shift($arrayTemp);
		foreach($arrayTemp as $value){
			$stringTemp .= ucfirst($value);
		}
		return $stringTemp;
	}
	
	/**
	 *
	 *
	 * 生成类名
	 * 
	 * @param String $className        	
	 */
	public function setClassName($className){
		$arrayTemp = explode('_', $className);
		array_shift($arrayTemp); // 去掉表名前缀
		foreach($arrayTemp as $value){
			$stringTemp .= ucfirst($value);
		}
		return $stringTemp;
	}
	
	/**
	 *
	 *
	 * 生成文件名
	 * 
	 * @param String $fileName        	
	 */
	public function setFileName($fileName){
		$arrayTemp = explode('_', $fileName);
		array_shift($arrayTemp); // 去掉表名前缀
		foreach($arrayTemp as $value){
			$stringTemp .= ucfirst($value);
		}
		return $stringTemp;
	}
	
	public function setFileSuffix($fileSuffix){
		$this->FileSuffix = $fileSuffix;
	}
	
	public function getFileSuffix(){
		return $this->fileSuffix;
	}
	
	public function setOutOutDir($outPutDir){
		$this->outPutDir = $outPutDir;
	}
	
	public function getOutPutDir(){
		return $this->outPutDir;
	}
	
	public function setDb($db){
		$this->db = $db;
	}
	
	public function getDb(){
		return $this->db;
	}
}

?>
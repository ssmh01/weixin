<?php

/** 
 * @author blueyb
 * 测试模型
 * 
 */
class ModelAction extends Action{
	
	/**
	 * 从数据库创建模型
	 * @param HttpRequest $request
	 */
	public function index(HttpRequest $request){
		$db = R::getDB();
		$classFileDir = WEB_ROOT . 'runtime/models';
		FileUtil::mkDirs($classFileDir);
		$classBuilder = new ModelClassBuilder($db, $classFileDir, 'class.php');
		Debug::println('开始创建模型类文件');
		$classBuilder->createClassAll();
		Debug::println('创建模型类文件完成');
		Debug::println('模型类所在的目录为:' . $classFileDir);
		die();
	}
}

?>
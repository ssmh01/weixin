<?php
/**
 * 配置
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-02
 */
class ConfigAction extends AbstractAdminAction {
    protected $leftMenuParentId = 1;
	
    /**
     * 解析file表单的name
     *
     * @param string $name file表单的name
     */
    private function analyzeFormFileName($name){
        $pos = strpos($name, '_');
        return ($pos === false) ? array() : array('parent'=>substr($name, 0, $pos), 'code'=>substr($name, $pos + 1));
    }

	/**
	 * 模型列表
	 */
	public function index(HttpRequest $request){
		
		$model = empty($dynModelName) ? $this->createModelByAdminAction() : M($dynModelName);
        $modelDao = MD($model);
        $this->setOrders('sort_num desc');
       	$info = $modelDao->gets(null, null, $this->getOrders());
		foreach($info as $key=>$val)
		{
            //单选框、复选框值格式：值,显示值|值,显示值|值,显示值
            if(in_array($val['type'], array('radio', 'checkbox'))){
                $_group = explode('|', $val['options']);
                $_vals = array();
                foreach($_group as $v){
                    $_v = explode(',', $v);
                    !isset($_v[1]) && $_v[1] = $_v[0];
                    $_vals[] = array(
                        'val' => $_v[0],
                        'text' => $_v[1],
                    );
                }
                $info[$key]['options'] = $_vals;
                ($val['type'] == 'checkbox') && $info[$key]['valuearr'] = explode(',', $val['value']);
            }
		}
       	$request->setAttribute('info', $info);

       	//切换卡
       	$DB = R::getDB();
        $result = $DB->getRows("select tab from yyx_config GROUP BY tab order by sort_num desc ");
        
        foreach($result as $key=>$val)
        {
        	$tab_list[($key+1)] = $val['tab'];
        }
		$request->setAttribute('tab_list', $tab_list);
		$request->setAttribute('tab_num',count($tab_list));
		
		$request->setAttribute('action', 'update');
		$request->assign('title', '系统设置');
		$this->setView('config');
	}
	
	/**
	 * 更新
	 */
	public function update(HttpRequest $request)
	{
        $dynModelName = $request->getAttribute('dynModelName');
        $model = empty($dynModelName) ? $this->createModelByAdminAction() : M($dynModelName);
		$modelDao = MD($model);

        $uploads = $_FILES;
        if(!empty($uploads)){
            $uploadService = new UploadService();
            $uploadDir = get_config('upload_common_dir');
            foreach($uploads as $formFileName => $formFileVal){
                if($formFileVal['size']){
                    //获取组名和标识名
                    $flags = $this->analyzeFormFileName($formFileName);
                    $parentCode = $flags['parent'];
                    $code = $flags['code'];

                    $fileName = $formFileName.'.'.UploadUtils::getFileExtName($formFileVal['name']);
                    $uploadInfo = array(
                        'formFile' => $formFileName,
                        'fileName' => $fileName,
                        'uploadDir' => $uploadDir,
                        'isCover' => IUploadService::UPLOAD_FILE_COVER,
                    );
                    $uploadService->save($uploadInfo);
                    $uploaded = $uploadService->getUploaded();
                    $uploaded['success'] && $modelDao->updates(array('value'=>$uploaded['path']), "`tab`='{$parentCode}' AND `code`='{$code}'");
                }
            }
        }

		$configs = $request->getParameter('config');
		foreach($configs as $key=>$val)
		{
			if(is_array($val))
			{
				//将数组形的值转成以","号分隔的值形式
				$val = implode(',',$val);
			}
			$modelDao->update(array('value'=>$val), $key);
		}
		$this->setMessage('op_success');
        $request->redirect($request->getAttribute('index_url'));
	}
}

?>
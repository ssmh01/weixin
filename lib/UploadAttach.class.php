<?php

/**
 *
 * 附件上传类-支持多文件上传
 *
*/
class UploadAttach {

    public static function exec($userMode=true) {
    	$AttachType = cache_get('AttachType');    	

    	include_once EXT_LIB_ROOT.'UploadFile.class.php';
    	$UploadFile = new UploadFile($AttachType, $userMode);

    	if($UploadFile->upload()) {
    		$FileInfo = $UploadFile->getFileInfo();

    		$MD = MD('ExtendAttach');
    		$data['enable'] = 1;
    		$data['add_user'] = 0;
    		$data['add_time'] = $_SERVER['REQUEST_TIME'];
    		foreach($FileInfo as $k=>$v) {
    			if(empty($v['attach_id'])) {
    				$data['filename'] = $v['title'];
    				$data['filepath'] = $v['savename'];
    				$data['ext'] = $v['extension'];
    				$data['group'] = $v['group'];
    				$data['size'] = $v['size'];
    				$data['hash'] = $v['hash'];
    				$FileInfo[$k]['attach_id'] = $MD->add($data);
    			}
    		}
    		if(is_array($FileInfo) && count($FileInfo)==1) {
    			$FileInfo = array_shift($FileInfo);
    		}
			return $FileInfo;
		} else {
			return $UploadFile->getErrorMsg();
		}
    }

    public static function rm($id, $onlyUnlink=false) {
    	$MD = MD('ExtendAttach');
    	foreach (explode(',', $id) as $v) {
    		$data = $MD->get($v);
    		$filename = get_config('attach_filepath').$data['filepath'];
    		unlink($filename);

    		$onlyUnlink || $MD->delete($v);
    	}

    }
}
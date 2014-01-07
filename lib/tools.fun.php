<?php
function get_basename($filename){
	return preg_replace('/^.+[\\\\\\/]/', '', $filename);
}

/**
 * 将列表转为 树型 （栏目树、分类树）
 * 用以创建 下拉选项
 * 
 * @param array $data        	
 * @param string $id        	
 * @param string $pid        	
 * @param string $name        	
 * @param string $spliter        	
 * @return array
 */
function toTree($data, $id = 'id', $pid = 'parent_id', $name = 'name', $spliter = '├─'){
	include_once EXT_LIB_ROOT . 'Tree.class.php';
	$Tree = new Tree();
	foreach($data as $v)
		$Tree->setNode($v[$id], $v[$pid], $v[$name]);
	$data = array();
	$childs = $Tree->getChilds();
	
	$spliter = (array)$spliter;
	$spliter[] = mb_substr($spliter[0], 0, 1, 'UTF-8');
	$spliter[] = mb_substr($spliter[0], 1, 2, 'UTF-8');
	
	foreach($childs as $v){
		$data[$v] = $spliter[1] . $Tree->getLayer($v, $spliter[2]) . $Tree->getValue($v);
	}
	return $data;
}

/**
 * 获取在线IP
 *
 * @param boolean $format
 *        	是否返回格式化
 * @return mixed
 */
function getonlineip($format = false){
	if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')){
		$onlineip = getenv('HTTP_CLIENT_IP');
	}elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')){
		$onlineip = getenv('HTTP_X_FORWARDED_FOR');
	}elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')){
		$onlineip = getenv('REMOTE_ADDR');
	}elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')){
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
	$ip = $onlineipmatches[0]? $onlineipmatches[0] : 'unknown';
	
	if($format){
		$ips = explode('.', $ip);
		for($i = 0; $i < 3; $i++){
			$ips[$i] = intval($ips[$i]);
		}
		return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
	}else{
		return $ip;
	}
}

/**
 * utf8字符处理
 *
 * @access public
 * @param        	
 *
 *
 *
 * @return void
 */
function utf82u2($str){
	$len = strlen($str);
	$start = 0;
	$result = '';
	
	if($len == 0){
		return $result;
	}
	
	while($start < $len){
		$num = ord($str{$start});
		if($num < 127){
			$result .= chr($num) . chr($num >> 8);
			$start += 1;
		}else{
			if($num < 192){
				/* 无效字节 */
				$start++;
			}elseif($num < 224){
				if($start + 1 < $len){
					$num = (ord($str{$start}) & 0x3f) << 6;
					$num += ord($str{$start + 1}) & 0x3f;
					$result .= chr($num & 0xff) . chr($num >> 8);
				}
				$start += 2;
			}elseif($num < 240){
				if($start + 2 < $len){
					$num = (ord($str{$start}) & 0x1f) << 12;
					$num += (ord($str{$start + 1}) & 0x3f) << 6;
					$num += ord($str{$start + 2}) & 0x3f;
					
					$result .= chr($num & 0xff) . chr($num >> 8);
				}
				$start += 3;
			}elseif($num < 248){
				
				if($start + 3 < $len){
					$num = (ord($str{$start}) & 0x0f) << 18;
					$num += (ord($str{$start + 1}) & 0x3f) << 12;
					$num += (ord($str{$start + 2}) & 0x3f) << 6;
					$num += ord($str{$start + 3}) & 0x3f;
					$result .= chr($num & 0xff) . chr($num >> 8) . chr($num >> 16);
				}
				$start += 4;
			}elseif($num < 252){
				if($start + 4 < $len){
					/* 不做处理 */
				}
				$start += 5;
			}else{
				if($start + 5 < $len){
					/* 不做处理 */
				}
				$start += 6;
			}
		}
	
	}
	
	return $result;
}

/**
 * 邮件模板标签替换
 *
 * @param string $string
 *        	内容
 * @param array $params
 *        	替换的内容，键名为要替换标签
 * @return string
 */
function templateTag($string, $params = array()){
	$matchs = null;
	preg_match_all("/\{(.+?)\}/", $string, $matchs);
	$froms = $tos = array();
	foreach($matchs[1] as $match){
		$froms[] = "{{$match}}";
		$tos[] = $params[$match];
	}
	return str_replace($froms, $tos, $string);
}

/**
 * 判断是否开启验证码
 *
 * @param string $code
 *        	标识
 * @return boolean
 */
function isOpenCaptcha($code){
	$opens = CommonServiceFactory::loadConfigService()->get('captcha_open');
	$opens = array_filter(explode(',', $opens));
	return in_array($code, $opens);
}

/**
 * 检测邮箱
 *
 * @param string $email
 *        	邮箱
 * @return boolean
 */
function checkEmail($email){
	$reg = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
	return preg_match($reg, $email) === 1;
}

/**
 * 获取后台菜单
 *
 * @param $id 上前分类id        	
 */
function get_admin_menu($id){
	$list = AdminServiceFactory::getMenuService()->gets($id, 1);
	$menu_list = array();
	foreach($list as $v){
		if($v['parent_id'] == $id){
			$menu_list[$v['id']] = $v;
		}else{
			$menu_list[$v['parent_id']]['sub'][$v['id']] = $v;
		}
	}
	R::getRequest()->setAttribute("menu_list", $menu_list);
	R::getRequest()->setAttribute("top_menu", $id);
}

function getPage(){
	$page = intval(R::getRequest()->getParameter('page'));
	if($page < 1){
		$page = 1;
	}
	return $page;
}

/**
 * 邮件模板标签替换
 *
 * @param string $string
 *        	内容
 * @param array $params
 *        	替换的内容，键名为要替换标签
 * @return string
 */
function emailTemplateTag($string, $params = array()){
	$matchs = null;
	preg_match_all("/\{(.+?)\}/", $string, $matchs);
	$froms = $tos = array();
	foreach($matchs[1] as $match){
		$froms[] = "{{$match}}";
		$tos[] = $params[$match];
	}
	return str_replace($froms, $tos, $string);
}
?>
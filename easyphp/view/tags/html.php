<?php

/**
 * 用于解析命名空间为html的标签
 *
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-03-02
 */
class html extends TagSelfParse{

	public function getName(){
		return __CLASS__;
	}

	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		return $tag->toString();
	}

	/**
	 * 处理select开始标签，支持的参数
	 * name:指定select标签在表单中的名称
	 * title:select选择标题
	 * options:选择项目数组，支持一维数组和二维数组,二维数组需要指定key参数
	 * key:当选择项目为二维数组时需要指定该选项，value的键和text的键用:分隔,如id:name
	 * current:当前的选择项目，支持变量和固定值
	 * id:指定dom元素的id
	 * class:指定dom元素的class
	 * @param Tag $tag
	 */
	public function startSelect($tag){
		$params = $this->parseTagParams($tag);
		if(!$params['title']){
			$params['title'] = '请选择';
		}
		if($params['current']){
			if(!$this->isVariable($params['current'])){
				//当前值是不是变量
				$params['current'] = "'$params[current]'";
			}
		}else{
			$params['current'] = "''";
		}
		$script = "<select name='{$params['name']}' id='{$params['id']}' class='{$params['class']}'>";
		$script .= "<option value=''>" . get_lang($params['title']) . "</option>";
		$script .=  Constant::PHP_START_TAG . Constant::BLANK;
		if($params['key']){
			//options参数是二维数组
			list($valueKey, $textKey) = explode(':', $params['key']);
			$script .=  "foreach({$params['options']} as \$option){";
			$script .=  "echo \"<option value='\$option[$valueKey]' \"" . Constant::PHP_LINE_SEPARATOR;
			$script .=  "if(\$option[$valueKey] == {$params['current']})echo 'selected=selected';";
			$script .=  "echo \">\$option[$textKey]</option>\"".Constant::PHP_LINE_SEPARATOR;
			$script .=  "}";
		}else{
			//options参数是一维数组
			$script .=  "foreach({$params['options']} as \$option){";
			$script .=  "echo \"<option value='\$option' \"" . Constant::PHP_LINE_SEPARATOR;
			$script .=  "if(\$option == {$params['current']})echo 'selected=selected';";
			$script .=  "echo \">\$option</option>\"".Constant::PHP_LINE_SEPARATOR;
			$script .=  "}";
		}
		$script .=  Constant::BLANK . Constant::PHP_END_TAG;
		$script .= "</select>";
		return $script;
	}

	/**
	 * 处理table开始标签
	 * @param Tag $tag
	 */
	public function startTable($tag){
		$body = $tag->getBody();
		//分割参数
		$matchs = array();
		preg_match_all("/(\S+\s*)=([\S\s]*?)(?:(?=\S+\s*=)|$)/", $body, $matchs, PREG_SET_ORDER);
		$params = array();
		foreach($matchs as $match){
			$params[$match[1]] = $match[2];
		}

		//参数处理
		$params['fields'] = str_replace(array('<', '>', '/[\s]+/'), array('{', '}', ''), $params['fields']);
		$params['ops'] = str_replace(array('<', '>', '/[\s]+/'), array('{', '}', ''), $params['ops']);

		$fields = json_decode($params['fields'], true);
		$ops = json_decode($params['ops'], true);

		$id = trim($params['id']);
		$class = trim($params['class']);
		$checkbox = trim($params['checkbox']);	//如果该项存在，那么就用这项的值用作checkbox的name属性
		$checkboxclass = $params['checkboxclass']? trim($params['checkboxclass']):'ids';
		$pk = $params['pk']? trim($params['pk']):'id';
		$datas = $params['datas']? trim($params['datas']):'$items';
		$opwidht = trim($params['opwidht']);	//操作列的宽度
		$imagepath = $params['imagepath']? trim($params['imagepath']):'../images/'; //图片路径

		//显示开始
		$parseStr	= "<!-- EasyPHP表格组件开始 -->\n";
        $parseStr  .= '<table id="'.$id.'" class="'.$class.'" cellpadding="0" cellspacing="0" border="0">' . Constant::LINE_END_CHAR;
        $parseStr  .= '<thead><tr>' . Constant::LINE_END_CHAR;

		$first = 'class="first"';

		//构造指定的字段的标题
        if(!empty($checkbox)) {
        	//如果指定需要显示checkbox列
            $parseStr .='<th width="30" '.$first.'><input type="checkbox" onclick="checkAll(\''.$id.'\',\'' . $checkboxclass . '\')"></th>' . Constant::LINE_END_CHAR;
        	$first = '';
		}
        foreach($fields as $field) {


			$th_align = '';
			if(isset($field['align']))
			{
				$th_align .=" align='{$field['align']}'";
			}

			if(!empty($field['width'])){
				$parseStr .= "\t<th width='{$field['width']}' {$th_align} {$first}>";
			}else{
				$parseStr .= "\t<th {$th_align} {$first}>";
			}
			$first = '';
			if($field['notsort'])
				$parseStr .= get_lang($field['label']) .'</th>'  . Constant::LINE_END_CHAR;
			else{
            	$parseStr .= "<a href=\"javascript:sortBy('{$field['name']}','" . Constant::PHP_START_TAG . " echo \$nextsort;" . Constant::PHP_END_TAG . "')\" title='" . get_lang('click_sort_title') . "'>";
            	$parseStr .= get_lang($field['label']) . Constant::PHP_START_TAG . " if(\$order == '" .  $field['name'] . "') echo \"<img src='{$imagepath}{\$sort}.gif' align='absmiddle'/>\";" . Constant::PHP_END_TAG;
            	$parseStr .= '</a></th>' . Constant::LINE_END_CHAR;
			}
        }

		//如果指定显示操作功能列
        if(!empty($ops))
		{
			if(empty($opwidht))
            	$parseStr .= "\t<th>".get_lang('op_title').'</th>'. Constant::LINE_END_CHAR;
			else
				$parseStr .= "\t<th width='{$opwidht}'>" . get_lang('op_title') .'</th>'. Constant::LINE_END_CHAR;
        }
        $parseStr .= '</tr></thead>'. Constant::LINE_END_CHAR;

        ////构造指定的字段的内容
        $parseStr .= '<tbody>'. Constant::LINE_END_CHAR;

        $first = "class='first'";
        $pkVar = $this->makeVar("\$item[{$pk}]");
		$contentTrString = '';	//一行内容字符串
		if(!empty($checkbox)) {
        	//如果需要显示checkbox 则在每行开头显示checkbox
            $contentTrString .= '<tr>' . Constant::LINE_END_CHAR . "\t\t\t<td {$first}><input type='checkbox' name='{$checkbox}' class='{$checkboxclass}' value='{$pkVar}'></td>". Constant::LINE_END_CHAR;
            $first = '';
        }else{
        	$contentTrString = '<tr>'. Constant::LINE_END_CHAR;
        }
        foreach($fields as $field) {
            //显示定义的列表字段

			$td_attrs = '';
			if(isset($field['align']))
			{
				$td_attrs .=" align='{$field['align']}'";
			}

            $contentTrString   .=  "\t\t\t<td{$td_attrs} {$first}>";
			$first = '';
			$types = array('date', 'url', 'image', 'textmap', 'map');

			$valueVar = $this->makeVar("\$item[{$field[name]}]");
			if($field['type'] && in_array($field['type'], $types)){
				//指定type后将会不解析edit
				switch($field['type']){
					case 'date':
						if(!$field['format']){
							$field['format'] = 'Y-m-d H:i:s';
						}
						$value = "date('{$field['format']}', \"\$item[{$field['name']}]\")";
						$value = $this->makeVar($value);
						$contentTrString .= "<span>{$value}</span>";
						break;
					case 'url':
						$contentTrString .= "<a href='{$valueVar}' target='_blank'><span>{$valueVar}</span></a>";
						break;
					case 'image':
						$contentTrString .= "<img src='{$valueVar}' width='{$field[imageWidth]}' height='{$field[imageHeight]}'/>";
						break;
					case 'textmap':
						$map = explode(',', $field['map']);
						foreach($map as $key=>$value){
							unset($map[$key]);
							$value = explode(':', $value);
							if(count($value) >= 2){
								$map[$value[0]] = $value[1];
							}
						}
						$contentTrString .= "<span>" . Constant::PHP_START_TAG . Constant::LINE_END_CHAR;
						foreach($map as $key=>$value){
							$contentTrString .= "if(\$item[{$field['name']}] == '{$key}') echo '{$value}';" . Constant::LINE_END_CHAR;
						}
						$contentTrString .= Constant::PHP_END_TAG . "</span>";
						break;
					case 'map':
						$showVar = $this->makeVar("\${$field[map]}[\$item[{$field[name]}]][{$field[mapKey]}]");
						$contentTrString .= "{$showVar}";
						break;
					default:
						$contentTrString .= "<span>{$valueVar}</span>";
						break;

				}
			}else{
			 	if($field['edit']){
	            	//可编辑
	              	$contentTrString .= "<span class='pointer' onclick=textEdit(this,'{$pkVar}','{$field[name]}')>{$valueVar}</span>";
	            }elseif($field['toggle']){
	            	//可开关
	            	$contentTrString .= "<span class='pointer' onclick=toggleStatus(this,'{$pkVar}','{$field[name]}')>";
	            	$contentTrString .= "<img src='{$imagepath}status-{$valueVar}.gif' status='{$valueVar}'>";
	            	$contentTrString .= "</span>";
	            }else {
	            	if($field['length']){
	            		$cutValueVar = $this->makeCutVar("\$item[{$field[name]}]", $field['length']);
	            		$contentTrString .= "<span title='{$valueVar}'>{$cutValueVar}</span>";
	            	}else{
	            		$contentTrString .= "<span>{$valueVar}</span>";
	            	}
	            }
			}

            $contentTrString .= '</td>'. Constant::LINE_END_CHAR;
        }
		if(!empty($ops))
		{
			$contentTrString .= "\t\t\t<td align='center'>";
			foreach($ops as $op){
				$target = $op['target']? " target='{$op['target']}'":"";
				if($op['type'] == 'edit'){
					//编辑菜单
					$contentTrString .= "<a {$target} href='" . $this->makeVar("\$act_url") . "edit/?id={$pkVar}'>" . get_lang('edit_common') . "</a>&nbsp;&nbsp;";
				}elseif($op['type'] == 'delete'){
					//删除菜单
					$contentTrString .= "<a {$target} href='" . $this->makeVar("\$act_url") . "del/?id={$pkVar}' onclick='return opConfirm();'>" . get_lang('del_common') . "</a>&nbsp;&nbsp;";
				}elseif($op['type'] == 'detail'){
					//详细菜单
					$contentTrString .= "<a {$target} href='" . $this->makeVar("\$act_url") . "detail/?id={$pkVar}' >" . get_lang('detail') . "</a>&nbsp;&nbsp;";
				}else{
					$confirm = $op['confirm']? " onclick='return opConfirm();'":"";
					//自定义菜单
					if($op['method']){
						$contentTrString .= "<a {$confirm}  {$target} href='" . $this->makeVar("\$site_url") . "/{$op[module]}/{$op[action]}/{$op['method']}/?";
					}else{
						$contentTrString .= "<a {$confirm}  {$target} href='" . $this->makeVar("\$site_url") . "/{$op[module]}/{$op[action]}/?";
					}
					//处理参数
					$ps = explode('&', $op['params']);
					foreach($ps as $p){
						if(strpos($p, ':') === false){
							//参数值从列表中取
							$contentTrString .= "&{$p}=" . $this->makeVar("\$item[{$p}]");
						}else{
							//有:说明指定了参数值
							$pa = explode(':', $p);
							if($pa[1][0] == '%'){
								//如果值的开头是%说明值来自数据源
								$pa[1] = substr($pa[1], 1);
								$contentTrString .= "&{$pa[0]}=" .  $this->makeVar("\$item[{$pa[1]}]");
							}else{
								$contentTrString .= "&{$pa[0]}={$pa[1]}";
							}
						}
					}
					$contentTrString .= "'>" . get_lang($op['label']) . "</a>&nbsp;&nbsp;";
				}
			}
			$contentTrString .= "</td>". Constant::LINE_END_CHAR;
        }
        $contentTrString .= "\t</tr>";

        $parseStr .= Constant::PHP_START_TAG . Constant::LINE_END_CHAR;
        $parseStr .= "foreach({$datas} as \$key=>\$item){". Constant::LINE_END_CHAR;
        $parseStr .=  Constant::PHP_END_TAG . Constant::LINE_END_CHAR;
        $parseStr .=   "\t" .  $contentTrString . Constant::LINE_END_CHAR;
        $parseStr .=  Constant::PHP_START_TAG . Constant::LINE_END_CHAR;
        $parseStr .= "}". Constant::LINE_END_CHAR;
        $parseStr .= Constant::PHP_END_TAG . Constant::LINE_END_CHAR;
        $parseStr	.= '</tbody></table>';
        $parseStr	.= "\n<!-- EasyPHP表格组件结束 -->\n";
        return $parseStr;
	}

	private function makeVar($var){
		return Constant::PHP_START_TAG . " echo {$var} ; " . Constant::PHP_END_TAG;
	}
	
	private function makeCutVar($var, $length){
		return Constant::PHP_START_TAG . " echo mb_substr({$var}, 0, {$length}, 'utf-8') ; " . Constant::PHP_END_TAG;
	}
}
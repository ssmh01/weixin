<?php

/**
 * 网站前台消息提醒Action
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-02-29
 * 
 */
class TipAction extends Action {
	
	public function show(HttpRequest $request){
        $redirect = $request->getAttribute('redirect');
        $time = 3;//默认3秒
        $autoUrl = '';//自动跳转的地址

        //按新的规则
        if(is_array($redirect)){
            list($jump, $prev, $_time) = $redirect['info'];
            isset($_time) && $time = $_time;
            $links = $redirect['links'];

            //如果没设置地址列表且不提示“上一页”，或者，不提示“上一页”且第一个地址没设置链接，则自动跳回上一页，否则按规则执行
            if((!$prev && empty($links)) || (!$prev && !empty($links) && empty($links[0][1]))){
                $autoUrl = $request->getReferer();
                $links = array(array(get_lang('go_prev'), $autoUrl));
                $jump = true;
            }else{//按规则执行
                $prevInfo = $prev ? array(array(get_lang('go_prev'), $request->getReferer())) : array();
                $links = array_merge($prevInfo, $links);
                $jump && $autoUrl = $links[0][1];//自动跳转
            }
        }else{
            $autoUrl = ($redirect == -1) ? $request->getReferer() : $redirect;
            $jump = true;
        }

        $request->setAttribute('jump', $jump);
        $request->setAttribute('autoUrl', $autoUrl);
        $request->setAttribute('links', $links);
        $request->setAttribute('time', $time);
        $request->setAttribute('redirect', $redirect);
        
        $request->setAttribute("title", "消息提醒");

        $this->setView('message');
	}
	
	/**
	 * 显示ajax的消息
	 * @param HttpRequest $request
	 */
	public function ajaxMessage(HttpRequest $request){
		
	}
}

?>
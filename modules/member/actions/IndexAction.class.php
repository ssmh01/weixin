<?php
/**
 * 会员用心首页
 * @author blueyb.java@gmail.com
 */
class IndexAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		
		$this->setView('member_index');
	}
}
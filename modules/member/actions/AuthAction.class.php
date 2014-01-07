<?php
/**
 * 庄家认证
 * @author blueyb.java@gmail.com
 */
class AuthAction extends UserCenterAction{
	public function index(HttpRequest $request){
		$makersAuthDao = MD('MakersAuth');
		$makersAuth = $makersAuthDao->get($this->user->getId());
		if($request->isPost()){
			if($makersAuth['status'] == 1){
				show_message('申请已通过，不能重复申请!');
			}
			$auth = array(
				'id' => $this->user->getId(),
				'title'=>$request->getParameter('title'),
				'summary'=>$request->getParameter('summary'),
				'status'=>0,
				'create_time'=>time()
			);
			if(!$auth['title']){
				show_message('标题不能为空！');
			}
			if(!$auth['summary']){
				show_message('内容不能为空！');
			}
			if($makersAuth){
				//更新
				$success = $makersAuthDao->update($auth, $this->user->getId());
			}else{
				//添加
				$success = $makersAuthDao->add($auth);
			}
			if($success){
				show_message('申请成功');
			}else{
				show_message('申请成功');
			}
		}else{
			$request->setAttribute('makersAuth', $makersAuth);
			$seo = array(
				'title' => '庄家认证',
				'description' => '',
				'keywords' => ''
			);
			$request->assign('seo', $seo);
			$this->setView('auth');
		}
	}
}
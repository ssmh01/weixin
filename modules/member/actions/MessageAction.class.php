<?php
/**
 * 用户私信
 * @author blueyb.java@gmail.com
 */
class MessageAction extends UserCenterAction{
	
	private $modelDao = null;
	
	public function __construct(){
		parent::__construct();
		$this->modelDao = MD('Message');
		$seo = array(
				'title' => '用户私信',
				'description'=>'',
				'keywords'=>'',
		);
		R::getRequest()->assign('seo', $seo);
	}
	
	public function index(HttpRequest $request){
		//获取当前页的通知
		$conditions = array('to_uid'=>$this->user->getId());
		$orders = array('create_time'=>'desc');
		$page = getPage();
		$perpage = 5;
		$items = $this->modelDao->gets($conditions, null, $orders, $page, $perpage);
		$total = $this->modelDao->count($conditions);
		$pages = multi_page($total, $perpage, $page);
		
		//获取发送通知的用户信息
		UserService::usersSet(ArrayUtil::colKeySet($items, 'from_uid'));
		
		$request->setAttribute('items', $items);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
		$this->setView('message');
	}
	
	/**
	 * 发送私信
	 * @param HttpRequest $request
	 */
	public function send(HttpRequest $request){
		if($request->isPost()){
			$name = $request->getParameter('name');
			$userId = $request->getParameter('uid');
			$content = $request->getParameter('content');
			$code = $request->getParameter('code');
			if(!$userId){
				if(!$name){
					show_message("收件人不能为空!");
				}
				$userDao = MD('User');
				$toUser = $userDao->getOne(array('name'=>$name));
				if(!$toUser){
					show_message("收件人不存在，请确认收件人账号名");
				}
				$userId = $toUser['id'];
			}
			if(!$content){
				show_message("内容不能为空!");
			}
			if(!$code){
				show_message("验证码不能为空!");
			}
			$verificationCodeService = MemberServiceFactory::getVerificationCodeService();
			if(!$verificationCodeService->verify($code)){
				show_message('验证码不对!');
			}
			$messageService = MemberServiceFactory::getMessageService();
			if($messageService->message('', $content, $userId, $this->user->getId())){
				AjaxResult::closeAjaxWindow('私信发送成功，正在关闭窗口!');
			}else{
				show_message('私信发送失败!');
			}
		}else{
			$userId = $request->getParameter('uid');
			$repayId = $request->getParameter('repay');
			if($userId){
				$userDao = MD('User');
				$toUser = $userDao->get($userId);
				if(!$toUser){
					show_message('用户不存在');
				}
				$request->setAttribute('toUser', $toUser);
			}
			$request->setAttribute('toUserId', $userId);
			$this->setView('message_send');
		}
	}
	
	/**
	 * 回复私信
	 * @param HttpRequest $request
	 */
	public function reply(HttpRequest $request){
		if($request->isPost()){
			$userId = $request->getParameter('uid');
			$replyId = $request->getParameter('reply');
			$content = $request->getParameter('content');
			$code = $request->getParameter('code');
			if(!$userId){
				show_message("收件人不能为空!");
			}
			if(!$content){
				show_message("内容不能为空!");
			}
			if(!$code){
				show_message("验证码不能为空!");
			}
			$verificationCodeService = MemberServiceFactory::getVerificationCodeService();
			if(!$verificationCodeService->verify($code)){
				show_message('验证码不对!');
			}
			$messageService = MemberServiceFactory::getMessageService();
			if($messageService->message('', $content, $replyId, $this->user->getId(), $replyId)){
				AjaxResult::closeAjaxWindow('私信回复成功，正在关闭窗口!');
			}else{
				show_message('私信回复失败!');
			}
		}else{
			$replyId = $request->getParameter('id');
			if(!$replyId){
				show_message('请选择要回复的私信!');
			}
			$item = $this->modelDao->get($replyId);
			if(!$item){
				show_message('回复的私信不存在!');
			}
			if(!$item['from_uid']){
				show_message('不能回复系统私信!');
			}
			if($item['to_uid'] != $this->user->getId()){
				show_message('非法操作!');
			}
			$userDao = MD('User');
			$fromUser = $userDao->get($item['from_uid']);
			if(!$fromUser){
				show_message('私信用户不存在');
			}
			$request->setAttribute('replyId', $replyId);
			$request->setAttribute('fromUser', $fromUser);
			$this->setView('message_reply');
		}
	}
	
	/**
	 * 标记为已读
	 * @param HttpRequest $request
	 */
	public function read(HttpRequest $request){
		$this->loginCheck(true);
		$id = $request->getParameter('id');
		if(!$id){
			show_message('请先选择要操作的私信!');
		}
		$message = $this->modelDao->get($id);
		if(!$message){
			show_message('你要操作的私信不存在!');
		}
		if($message['to_uid'] != $this->user->getId()){
			show_message('非法操作!');
		}
		$conditions = array('id'=>$id);
		$update = array('new'=>'0');
		if($this->modelDao->updates($update, $conditions)){
			show_message('操作成功!');
		}else{
			show_message('操作失败!');
		}
	}
	
	/**
	 * 删除
	 * @param HttpRequest $request
	 */
	public function delete(HttpRequest $request){
		$this->loginCheck(true);
		$id = $request->getParameter('id');
		if(!$id){
			show_message('请先选择要操作的私信!');
		}
		$message = $this->modelDao->get($id);
		if(!$message){
			show_message('你要操作的私信不存在!');
		}
		if($message['to_uid'] != $this->user->getId()){
			show_message('非法操作!');
		}
		if($this->modelDao->delete($id)){
			show_message('操作成功!');
		}else{
			show_message('操作失败!');
		}
	}
}
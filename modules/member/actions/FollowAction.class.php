<?php
/**
 * 关注
 * @author blueyb.java@gmail.com
 */
class FollowAction extends UserCenterAction{
	
	/**
	 * @var ModelDao
	 */
	private $dao = null;
	
	public function __construct(){
		parent::__construct();
		$this->dao = MD('Follow');
	}
	
	public function index(HttpRequest $request){
		$this->add($request);
	}
	
	/**
	 * 加关注
	 * @param HttpRequest $request
	 */
	public function add(HttpRequest $request){
		$toUid = $request->getParameter('uid');
		if(!$toUid){
			show_message('请选择用户');
		}
		if($toUid == $this->user->getId()){
			show_message('你不能加自己为好友');
		}
		$userService = MemberServiceFactory::getUserService();
		$toUser = $userService->get($toUid);
		if(!$toUser){
			show_message('你关注的用户不存在');
		}
		$follow = new Follow();
		$follow->setFromUid($this->user->getId());
		$follow->setFromUser($this->user);
		$follow->setToUid($toUid);
		$follow->setToUser($toUser);
		$follow->setAddTime($request->getRequestTime());
		$followService = MemberServiceFactory::getFollowService();
		
		if($followService->isFollow($this->user->getId(), $toUid)){
			show_message('你已经关注该用户，不须重复关注!');
		}
		if($followService->add($follow)){
			show_message('关注成功');
		}else{
			show_message('关注失败');
		}
	}
	
	/**
	 * 取消关注
	 * @param HttpRequest $request
	 */
	public function cancel(HttpRequest $request){
		$toUid = $request->getParameter('uid');
		if(!$toUid){
			show_message('请选择要取消关注的用户');
		}
		if($toUid == $this->user->getId()){
			show_message('非法参数');
		}
		$conditions = array('from_uid'=>$this->user->getId(), 'to_uid'=>$toUid);
		$follow = $this->dao->getOne($conditions);
		if(!$follow){
			show_message('你还没有关注该用户！');
		}
		if($this->dao->delete($follow['id'])){
			show_message('取消关注成功');
		}else{
			show_message('取消关注失败');
		}
	}
}
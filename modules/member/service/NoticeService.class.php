<?php

/**
 * 通知服务接口实现
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 4, 2013
 */
class NoticeService extends TransationSupport implements INoticeService{
	
	/**
	 *
	 * @var ModelDao
	 */
	private $dao = null;
	public function __construct(){
		$this->dao = MD('Notice');
	}
	
	/*
	 * @see INoticeService::notice()
	 */
	public function notice($notice, $toUid, $fromUid = 0, $status = 0){
		$notice = array(
				'notice'=>$notice,
				'to_uid'=>$toUid,
				'from_uid'=>$fromUid,
				'new'=>1,
				'create_time'=>time(),
				'status'=>$status
				);
		
		return $this->dao->add($notice);
	}
	/*
	 * @see INoticeService::getNewNoticeCount()
	 */
	public function getNewNoticeCount($userId){
		if(!$userId) return 0;
		$conditions = array(
			'to_uid' => $userId,
			'new' => '1'
		);
		return $this->dao->count($conditions);
	}
	
	/*
	 * @see INoticeService::get()
	 */
	public function get($id){
		if(!$id)return null;
		$this->dao->update(array('new'=>'0'), $id);
		return $this->dao->get($id);
	}
	
	/**
	 * 标签替换
	 * @param string $template	内容
	 * @param array $params	替换的内容，键名为要替换标签
	 * @return string
	 */
	private static function tagReplace($template, $params = array()){
		$matchs = null;
		preg_match_all("/\{(.+?)\}/", $template, $matchs);
		$froms = $tos = array();
		foreach($matchs[1] as $match){
			$froms[] = "{{$match}}";
			$tos[] = $params[$match];
		}
		return str_replace($froms, $tos, $template);
	}
	
	/**
	 * 创建竞猜链接
	 * @param array $guess
	 */
	public static function makeGuessLink($guess){
		$template = "<a class='notice_link' href='/guess/view/?id={id}' target='_blank'>{title}</a>";
		return addslashes(self::tagReplace($template, $guess));
	}
	
	/**
	 * 创建用户链接
	 * @param array $user
	 */
	public static function makeUserLink($user){
		$template = "<a class='notice_link' href='/member/space/?uid={id}' target='_blank'>{name}</a>";
		return addslashes(self::tagReplace($template, $user));
	}
	
	/**
	 * 创建商品链接
	 * @param array $goods
	 */
	public static function makeGoodsLink($goods){
		$template = "<a class='notice_link' href='/goods/view/?id={id}' target='_blank'>{title}</a>";
		return addslashes(self::tagReplace($template, $goods));
	}
}

?>
<?php
/**
 * 竞猜服务接口
 * 
 * @author blueyb.java@gmail.com
 */
interface IGuessService{
	
	/**
	 * 获取竞猜点
	 * @param int $id
	 * @return GuessPoint
	 */
	public function getGuessPoint($id);
	
	/**
	 * 发布一个竞猜
	 * @param Guess $guess
	 * @return boolean
	 */
	public function add(Guess $guess);
	
	/**
	 * 获取一个竞猜
	 * @param int $id
	 * @param boolean $full 是否获取全部信息
	 * @return Guess
	 */
	public function get($id, $full=false);
	
	/**
	 * 删除一个竞猜
	 * @param Guess $guess
	 * @return boolean
	 */
	public function delete(Guess $guess);
	
	/**
	 * 获取竞猜列表
	 * @param array/string $conditions
	 * @param array/string $gets
	 * @param array/string $orders
	 * @param int $page
	 * @param int $perpage
	 * @return array(Guess)
	 */
	public function gets($conditions, $gets, $orders, $page, $perpage);
	
	/**
	 * 获取竞猜个数
	 * @param array/string $conditions
	 * @return int
	 */
	public function count($conditions);
	
	/**
	 * 邀请好友参与竞猜
	 * @param Guess $guess
	 */
	public function inviteFriends(Guess $guess);
	
	/**
	 * 竞猜关注
	 * @param User $user
	 * @param Guess $guess
	 * @return boolean
	 */
	public function follow(User $user, Guess $guess);
	
	/**
	 * 竞猜取消关注
	 * @param User $user
	 * @param Guess $guess
	 * @return boolean
	 */
	public function unFollow(User $user, Guess $guess);
	
	/**
	 * 是否已关注
	 * @param unknown $userId
	 * @param unknown $guessId
	 * @return boolean
	 */
	public function isFollow($userId, $guessId);
	
	/**
	 * 竞猜通过审核
	 * @param Guess $guess
	 * @return boolean
	 */
	public function check(Guess $guess);
	
	/**
	 * 关闭竞猜
	 * @param Guess $guess
	 * @return boolean
	 */
	public function close(Guess $guess);
	
	/**
	 * 根据竞猜点对竞猜进行判定
	 * @param GuessPoint $guessPoint
	 * @return boolean
	 */
	public function guessPointRudge(GuessPoint $guessPoint);
}

?>
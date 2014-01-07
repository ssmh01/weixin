<?php

/**
 * 商品服务
 * 
 * @author blueyb.java@gmail.com
 */
interface IGoodsService{
	
	/**
	 * 兑换
	 * @param User $user
	 * @param array $goods
	 * @param array $exchange
	 * @return boolean
	 */
	public function exchange(User $user, $goods, $exchange);
	
	/**
	 * 抽奖
	 * @param User $user
	 * @param array $goods
	 * @return boolean 中奖返回true
	 */
	public function lottery(User $user, $goods);
}

?>
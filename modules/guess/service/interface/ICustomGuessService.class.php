<?php
/**
 * 自定义竞猜服务接口
 * @author blueyb.java@gmail.com
 */
interface ICustomGuessService extends IGuessService{
	
	/**
	 * 提交判定
	 * @param Guess $guess
	 * @return boolean
	 */
	public function rudgeApply(Guess $guess);
	
	/**
	 * 竞猜判定
	 * @param Guess $guess
	 * @return boolean
	 */
	public function rudge(Guess $guess);
}
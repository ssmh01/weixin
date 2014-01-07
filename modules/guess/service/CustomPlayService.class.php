<?php

/**
 * 参与自定义竞猜服务接口实现
 * 
 * @author blueyb.java@gmail.com
 */
class CustomPlayService extends PlayService implements IPlayService{
	
	/*
	 * @see IPlayService::add()
	 */
	public function add(Play $play){
		if(!$play || $play->isEmpty() || !$play->getCustom()) return false;
		$user = $play->getUser();
		$guess = $play->getGuess();
		$playData = $play->getFirstPlayData();
		$play->setPlayDatas(serialize($play->getPlayDatas()));
		try{
			$this->beginTransation();
			//增加投注
			$id = $this->dao->add($play);
			if(!$id){
				$this->rollBack();
				return false; 
			}
			$play->setId($id);
			//更新竞猜
			$guessDao = MD('Guess');
			$playCount = $guess->getPlayCount() + 1;
			$paramter = $guess->getParameter();
			$paramter->addPlayCount($playData->getChoose());
			$update = array(
					'play_count'=>$playCount,
					'parameter'=>serialize($paramter)
					);
			
			if(!$guessDao->update($update, $guess->getId())){
				$this->rollBack();
				return false;
			}
			//更新用户竞猜数
			$userDao = MD('User');
			if(!$userDao->update(array('guess_count'=>'guess_count + 1'), $user->getId(), true)){
				$this->rollBack();
				return false;
			}
			$this->commit();
			return true;
		}catch(Exception $e){
			$this->rollBack();
			return false;
		}
	}
}

?>
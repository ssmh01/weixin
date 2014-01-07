<?php

/**
 * 玩法服务接口实现
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 15, 2013
 */
class PlayWayService implements IPlayWayService{
	
	private $playWays = array();
	
	/**
	 * @var ModelDao
	 */
	private $dao = null;
	
	public function __construct(){
		$this->dao = MD('PlayWay');
	}
	
	/**
	 *
	 * @see IPlayWayService::add()
	 */
	public function add(PlayWay $playWay){
		$playWay->setParameter(serialize($playWay->getParameter()));
		return $this->dao->add($playWay);
	}
	
	/**
	 *
	 * @see IPlayWayService::get()
	 */
	public function get($id){
		if(!$this->playWays[$id]){
			$playWay = $this->dao->get($id, null, true);
			if($playWay){
				$playWay->setParameter(unserialize($playWay->getParameter()));
				$playWay = ModelTransform::toCustomModel($playWay, 'PlayWay');
			}
			$this->playWays[$id] = $playWay;
		}
		return $this->playWays[$id];
	}
	
	/**
	 *
	 * @see IPlayWayService::gets()
	 */
	public function gets($conditions = null){
		$tempPlayWays = $this->dao->gets($conditions);
		$playWays = array();
		foreach($tempPlayWays as $playWay){
			$playWay['parameter'] = unserialize($playWay['parameter']);
			$playWays[$playWay['id']] = $playWay;
		}
		return $playWays;
	}
	
	/*
	 * @see IPlayWayService::getObjects()
	 */
	public function getObjects($conditions = null){
		$tempPlayWays = $this->dao->gets($conditions);
		$playWays = array();
		foreach($tempPlayWays as $playWay){
			$playWay['parameter'] = unserialize($playWay['parameter']);
			$playWay = ModelTransform::toCustomModel(Model::newModel('PlayWay', $playWay), 'PlayWay');
			$playWays[$playWay->getId()] = $playWay;
		}
		return $playWays;
	}
}

?>
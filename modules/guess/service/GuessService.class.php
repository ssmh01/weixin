<?php

/**
 * 竞猜服务接口实现
 * 
 * @author blueyb.java@gmail.com
 */
class GuessService extends TransationSupport implements IGuessService{
	/*
	 * @see IGuessService::getGuessPoint()
	 */
	public function getGuessPoint($id){
		$guessPointDao = MD('GuessPoint');
		$guessPoint = $guessPointDao->get($id, null, true);
		$guessPoint->params = unserialize($guessPoint->params);
		return ModelTransform::toCustomModel($guessPoint, 'GuessPoint');
	}
	
	/*
	 * @see IGuessService::add()
	 */
	public function add(Guess $guess){
		$guess->setKeepWealth($guess->needKeepWealth());
		$guess->setOddsType($guess->parseOddsType());
		$guess->setPlayDatas(serialize($guess->getPlayDatas()));
		$user = $guess->getUser();
		try{
			$this->beginTransation();
			// 添加竞猜
			$guessDao = MD('Guess');
			$guessId = $guessDao->add($guess);
			if(!$guessId){
				$this->rollBack();
				return false;
			}
			$guess->setId($guessId);
			//更新竞猜点的竞猜数
			$guessPointDao = MD('GuessPoint');
			if(!$guessPointDao->update(array('guess_count'=>'guess_count+1'), $guess->getGuessPointId(), true)){
				$this->rollBack();
				return false;
			}
			$guessLink = NoticeService::makeGuessLink(array('id'=>$guess->getId(), 'title'=>$guess->getTitle()));
			// 冻结资金
			$keepWealth = $guess->getKeepWealth();
			if($keepWealth){
				$userService = MemberServiceFactory::getUserService();
				if($guess->wealthTypeIsMoney()){
					$io = array(
						'from_user_id' => $user->getId(),
						'to_user_id' => 0,
						'from_title' => "冻结-发布竞猜{$guessLink}",
						'wealth_type' => Io::WEALTH_TYPE_MONEY,
						'wealth' => $keepWealth,
						'from_balance' => $user->getAvailableMoney() - $keepWealth
					);
					if(!$userService->money($io, -1)){
						$this->rollBack();
						return false;
					}
				}elseif($guess->wealthTypeIsIntegral()){
					$io = array(
						'from_user_id' => $user->getId(),
						'to_user_id' => 0,
						'from_title' => "冻结-发布竞猜{$guessLink}",
						'wealth_type' => Io::WEALTH_TYPE_INTEGRAL,
						'wealth' => $keepWealth,
						'from_balance' => $user->getAvailableIntegral() - $keepWealth
					);
					if(!$userService->integral($io, -1)){
						$this->rollBack();
						return false;
					}
				}
			}
			//邀请好友参与
			if($guess->getInviteFriend() == '1'){
				if(!$this->inviteFriends($guess)){
					$this->rollBack();
					return false;
				}
			}
			
			$this->commit();
			return true;
		}catch(Exception $e){
			$this->rollBack();
			return false;
		}
	}
	
	/*
	 * @see IGuessService::delete()
	*/
	public function delete(Guess $guess){
		if(!$guess || $guess->getPlayCount()) return false;
		$user = $guess->getUser();
		try{
			$this->beginTransation();
			//删除竞猜
			$success = MD('Guess')->delete($guess->getId());
			if(!$success){
				$this->rollBack();
				return false;
			}
			//删除用户竞猜数据(user_guess)
			$conditions = array('guess_id'=>$guess->getId());
			$success = MD('UserGuess')->deletes($conditions);
			if(!$success){
				$this->rollBack();
				return false;
			}
			
			if($guess->getStatus() != Guess::STATUS_WAITING_CKECK){
				//更新用户坐庄竞猜个数
				$userDao = MD('User');
				if(!$userDao->update(array('guess_add_count'=>'guess_add_count-1'), $guess->getUserId(), true)){
					$this->rollBack();
					return false;
				}
			}
			if($guess->getGuessPointId()){
				//更新竞猜点的竞猜数
				$guessPointDao = MD('GuessPoint');
				if(!$guessPointDao->update(array('guess_count'=>'guess_count-1'), $guess->getGuessPointId(), true)){
					$this->rollBack();
					return false;
				}
			}
			$guessLink = NoticeService::makeGuessLink(array('id'=>$guess->getId(), 'title'=>$guess->getTitle()));
			if($guess->getStatus() !== Guess::STATUS_END && $guess->getStatus() !== Guess::STATUS_CLOSE){
				//资金解冻
				$keepWealth = $guess->getKeepWealth();
				if(!$guess->getCustom() && $keepWealth){
					$userService = MemberServiceFactory::getUserService();
					if($guess->wealthTypeIsMoney()){
						$io = array(
								'from_user_id' => 0,
								'to_user_id' => $user->getId(),
								'to_title' => "解冻-删除竞猜{$guessLink}",
								'wealth_type' => Io::WEALTH_TYPE_MONEY,
								'wealth' => $keepWealth,
								'to_balance' => $user->getAvailableMoney() + $keepWealth
						);
						if(!$userService->money($io, 1)){
							$this->rollBack();
							return false;
						}
					}elseif($guess->wealthTypeIsIntegral()){
						$io = array(
								'from_user_id' => 0,
								'to_user_id' => $user->getId(),
								'to_title' => "解冻-删除竞猜{$guessLink}",
								'wealth_type' => Io::WEALTH_TYPE_INTEGRAL,
								'wealth' => $keepWealth,
								'to_balance' => $user->getAvailableIntegral() + $keepWealth
						);
						if(!$userService->integral($io, 1)){
							$this->rollBack();
							return false;
						}
					}
				}
			}
			$this->commit();
			return true;
		}catch(Exception $e){
			$this->rollBack();
			return false;
		}
	}
	
	/*
	 * @see IGuessService::get()
	 */
	public function get($id, $full=false){
		$guessDao = MD('Guess');
		$guess = $guessDao->get($id, null, true);
		if(!$guess) return null;
		$guess->play_datas = unserialize($guess->play_datas);
		$guess->parameter = unserialize($guess->parameter);
		$guess = ModelTransform::toCustomModel($guess, 'Guess');
		if($full){
			//获取庄家
			$userService = MemberServiceFactory::getUserService();
			$user = $userService->get($guess->getUserId());
			$guess->setUser($user);
		}
		return $guess;
	}
	
	/*
	 * @see IGuessService::count()
	 */
	public function count($conditions){
		$guessDao = MD('Guess');
		return $guessDao->count($conditions);
	}
	
	/*
	 * @see IGuessService::gets()
	 */
	public function gets($conditions, $gets, $orders, $page, $perpage){
		$guessDao = MD('Guess');
		$tempGuesses = $guessDao->gets($conditions, $gets, $orders, $page, $perpage);
		$guesses = array();
		foreach($tempGuesses as $guess){
			$guess['play_datas'] = unserialize($guess['play_datas']);
			$guess['parameter'] = unserialize($guess['parameter']);
			$guesses[$guess['id']] = $guess;
		}
		return $guesses;
	}
	
	/*
	 * @see IGuessService::inviteFriends()
	 */
	public function inviteFriends(Guess $guess){
		$user = $guess->getUser();
		if(!$user) return false;

		/*
		$followService = MemberServiceFactory::getFollowService();
		$users = $followService->getUserFollows($user->getId(), null, null);
		*/
		
		$userService = MemberServiceFactory::getUserService();		
		$users = $userService->getUserFriend($user->getId(), null, null);
		
		$noticeService = MemberServiceFactory::getNoticeService();
		$userGuessService = GuessServiceFactory::getUserGuessService();
		foreach($users as $toUser){
			// 填写邀请
			$userGuess = array(
				'from_uid' => $user->getId(),
				'to_uid' => $toUser['id'],
				'guess_id' => $guess->getId(),
				'type'=>UserGuess::TYPE_INVITE,
				'create_time' => time()
			);
			if(!$userGuessService->add($userGuess)){
				return false;
			}
			// 给用户发通知
			if($toUser['configs']['guess_play_invite']){
				$userLink = NoticeService::makeUserLink(array('id'=>$user->getId(), 'name'=>$user->getName()));
				$guessLink = NoticeService::makeGuessLink(array('id'=>$guess->getId(), 'title'=>$guess->getTitle()));
				$notice = "好友{$userLink}邀请您参与他的竞猜{$guessLink}";
				if(!$noticeService->notice($notice, $toUser['id'])){
					return false;
				}
			}
		}
		return true;
	}
	
	/* 
	 * @see IGuessService::follow()
	 */
	public function follow(User $user, Guess $guess){
		$userGuess = array(
			'type' => UserGuess::TYPE_ATTENTION,
			'from_uid' => $user->getId(),
			'to_uid' => $guess->getUser()->getId(),
			'guess_id' => $guess->getId(),
			'create_time'=>time()
		);
		$userGuessService = GuessServiceFactory::getUserGuessService();
		return $userGuessService->add($userGuess);
	}

	/* 
	 * @see IGuessService::unFollow()
	 */
	public function unFollow(User $user, Guess $guess){
		$userGuess = array(
			'type' => UserGuess::TYPE_ATTENTION,
			'from_uid' => $user->getId(),
			'guess_id' => $guess->getId(),
		);
		$userGuessService = GuessServiceFactory::getUserGuessService();
		return $userGuessService->delete($userGuess);
	}
	
	/* 
	 * @see IGuessService::isFollow()
	 */
	public function isFollow($userId, $guessId){
		$userGuessService = GuessServiceFactory::getUserGuessService();
		return $userGuessService->count(array('type'=>UserGuess::TYPE_ATTENTION, 'from_uid'=>$userId, 'guess_id'=>$guessId));
	}
	
	/* 
	 * @see IGuessService::check()
	 */
	public function check(Guess $guess){
		if(!$guess || $guess->getStatus() != Guess::STATUS_WAITING_CKECK) return false;
		try{
			$this->beginTransation();
			//改变状态
			$success = MD('Guess')->update(array('status'=>Guess::STATUS_NORMAL), $guess->getId());
			if(!$success){
				$this->rollBack();
				return false;
			}
			//更新用户坐庄竞猜个数
			$userDao = MD('User');
			if(!$userDao->update(array('guess_add_count'=>'guess_add_count+1'), $guess->getUserId(), true)){
				$this->rollBack();
				return false;
			}
			//发通知
			$user = $guess->getUser();
			if($user && $user->getConfig('guess_check')){
				$guessLink = NoticeService::makeGuessLink(array('id'=>$guess->getId(), 'title'=>$guess->getTitle()));
				$notice = "你发布的竞猜{$guessLink}审核通过已发布";
				$noticeService = MemberServiceFactory::getNoticeService();
				if(!$noticeService->notice($notice, $user->getId())){
					$this->rollBack();
					return false;
				}
			}
			$this->commit();
			return true;
		}catch(Exception $e){
			$this->rollBack();
			return false;
		}
	}

	/* 
	 * @see IGuessService::close()
	 */
	public function close(Guess $guess){
		if(!$guess || $guess->getPlayCount()) return false;
		try{
			$this->beginTransation();
			//改变状态
			$success = MD('Guess')->update(array('status'=>Guess::STATUS_CLOSE), $guess->getId());
			if(!$success){
				$this->rollBack();
				return false;
			}
			$guessLink = NoticeService::makeGuessLink(array('id'=>$guess->getId(), 'title'=>$guess->getTitle()));
			//发通知
			$user = $guess->getUser();
			if($user && $user->getConfig('guess_check')){
				$guessLink = NoticeService::makeGuessLink(array('id'=>$guess->getId(), 'title'=>$guess->getTitle()));
				$notice = "你发布的竞猜{$guessLink}已关闭";
				$noticeService = MemberServiceFactory::getNoticeService();
				if(!$noticeService->notice($notice, $user->getId())){
					$this->rollBack();
					return false;
				}
			}
			
			//资金解冻
			$keepWealth = $guess->getKeepWealth();
			if(!$guess->getCustom() && $keepWealth){
				$userService = MemberServiceFactory::getUserService();
				if($guess->wealthTypeIsMoney()){
					$io = array(
						'from_user_id' => 0,
						'to_user_id' => $user->getId(),
						'to_title' => "解冻-关闭竞猜{$guessLink}",
						'wealth_type' => Io::WEALTH_TYPE_MONEY,
						'wealth' => $keepWealth,
						'to_balance' => $user->getAvailableMoney() + $keepWealth
					);
					if(!$userService->money($io, 1)){
						$this->rollBack();
						return false;
					}
				}elseif($guess->wealthTypeIsIntegral()){
					$io = array(
						'from_user_id' => 0,
						'to_user_id' => $user->getId(),
						'to_title' => "解冻-关闭竞猜{$guessLink}",
						'wealth_type' => Io::WEALTH_TYPE_INTEGRAL,
						'wealth' => $keepWealth,
						'to_balance' => $user->getAvailableIntegral() + $keepWealth
					);
					if(!$userService->integral($io, 1)){
						$this->rollBack();
						return false;
					}
				}
			}
			$this->commit();
			return true;
		}catch(Exception $e){
			$this->rollBack();
			return false;
		}
	}
	
	/* 
	 * @see IGuessService::guessPointRudge()
	 */
	public function guessPointRudge(GuessPoint $guessPoint){
		if($guessPoint->getStatus() != GuessPoint::STATUS_NORMAL || $guessPoint->getPlayDeadline() > time()) return false;
		//获取这个竞猜点的所有竞猜
		$guesses = $this->getGuessPointGuesses($guessPoint);
		try{
			$this->beginTransation();
			$playWayService = GuessServiceFactory::getPlayWayService();
			$userService = MemberServiceFactory::getUserService();
			$playService = GuessServiceFactory::getPlayService();
			$noticeService = MemberServiceFactory::getNoticeService();
			$guessDao = MD('Guess');
			$userDao = MD('User');
			$ioDao = MD('io');
			$playWinWealth = 0;
			$guessWinWealth = 0;
			
			foreach($guesses as $guess){
				$plays = $playService->getPlays($guess);
				$guessUser = $guess->getUser();
				$guessWinWealth = 0;
				$guessLink = NoticeService::makeGuessLink(array('id'=>$guess->getId(), 'title'=>$guess->getTitle()));
				foreach($plays as $play){
					//对用户的竞猜参与进行判定
					$playUser = $play->getUser();
					$playWinWealth = 0;
					foreach($play->getPlayDatas() as $playData){
						//创建这个玩法的参数适配器
						$playData->setPlay($play);
						$playWay = $playWayService->get($playData->getPlayWayId());
						$playWayAdapter = $playWay->getPlayWayAdapter();
						if(!$playWayAdapter->resultRudge($playData)){
							$this->rollBack();
							return false;
						}
						$playWinWealth += $playData->getWinWealth();
						$playData->setPlay(null);	//删除Play避免保存
					}
					$play->setWinWealth($playWinWealth);
					//保存竞猜结果
					$playDao = MD('Play');
					$update = array(
						'win_wealth'=>$play->getWinWealth(),
						'status'=>Play::STATUS_REDGED,
						'play_datas'=>serialize($play->getPlayDatas())
					);
					if(!$playDao->update($update, $play->getId())){
						$this->rollBack();
						return false;
					}
					//统计用户竞猜金额
					$playKeepWealth = $play->getWealth();
					$io = array(
							'from_user_id' => 0,
							'to_user_id' => $play->getUserId(),
							'create_time' => time()
					);
					if($guess->wealthTypeIsMoney()){
						$io['wealth_type'] = Io::WEALTH_TYPE_MONEY;
						if($playWinWealth >= 0){
							//赢
							$io['to_title'] = "「赢{$playWinWealth},解冻{$playKeepWealth}」竞猜{$guessLink}公布结果";
						}else{
							$basWinWealth = abs($playWinWealth);
							$io['to_title'] = "「输{$basWinWealth},解冻{$playKeepWealth}」竞猜{$guessLink}公布结果";
						}
						$io['wealth'] = $playWinWealth + $playKeepWealth;
						$io['to_balance'] = $playUser->getAvailableMoney() + $io['wealth'];
						
						//更新金额
						$update = array(
							'available_money' => "available_money + {$io['wealth']}",
							'freeze_money' => "freeze_money - {$playKeepWealth}"
						);
						
						if(!$userDao->update($update, $playUser->getId(), true)){
							$this->rollBack();
							return false;
						}
						//记录细明
						if(!$ioDao->add($io)){
							$this->rollBack();
							return false;
						}
						
					}elseif($guess->wealthTypeIsIntegral()){
						$io['wealth_type'] = Io::WEALTH_TYPE_INTEGRAL;
						if($playWinWealth >= 0){
							//赢
							$io['to_title'] = "「赢{$playWinWealth},解冻{$playKeepWealth}」竞猜{$guessLink}公布结果";
						}else{
							$basWinWealth = abs($playWinWealth);
							$io['to_title'] = "「输{$basWinWealth},解冻{$playKeepWealth}」竞猜{$guessLink}公布结果";
						}
						$io['wealth'] = $playWinWealth + $playKeepWealth;
						$io['to_balance'] = $playUser->getAvailableIntegral() + $io['wealth'];
						
						//更新积分
						$update = array(
								'available_integral' => "available_integral + {$io['wealth']}",
								'freeze_integral' => "freeze_integral - {$playKeepWealth}"
						);
						if(!$userDao->update($update, $playUser->getId(), true)){
							$this->rollBack();
							return false;
						}
						//记录细明
						if(!$ioDao->add($io)){
							$this->rollBack();
							return false;
						}
					}
					
					//竞猜判定通知
					if($playUser->getConfig('guess_result')){
						$notice = "你参与的竞猜{$guessLink}已经公布结果";
						if(!$noticeService->notice($notice, $playUser->getId())){
							$this->rollBack();
							return false;
						}
					}
					
					//更新用户竞猜准确率
					if(!$userService->updateGuessAccuracy($playUser->getId())){
						$this->rollBack();
						return false;
					}
					$guessWinWealth = $guessWinWealth - $playWinWealth;
				}
				//竞猜判定通知庄家
				//更新庄家，避免金币不同步
				$guessUser = $userService->get($guess->getUserId());
				$guess->setUser($guess);
				if($guessUser->getConfig('guess_result')){
					$notice = "你坐庄的竞猜{$guessLink}已经公布结果";
					if(!$noticeService->notice($notice, $guessUser->getId())){
						$this->rollBack();
						return false;
					}
				}
				//对坐庄进行分成计算
				$guessKeepWealth = $guess->getKeepWealth();
				$taxWealth = 0;
				$io = array(
						'from_user_id' => 0,
						'to_user_id' => $guess->getUserId(),
						'create_time' => time()
				);
				if($guess->wealthTypeIsMoney()){
					$io['wealth_type'] = Io::WEALTH_TYPE_MONEY;
					if($guessWinWealth >= 0){
						//赢
						$taxWealth = $guessWinWealth * $guess->getTax();
						$io['to_title'] = "「赢{$guessWinWealth},税{$taxWealth},解冻{$guessKeepWealth}」坐庄竞猜{$guessLink}公布结果";
					}else{
						$basWinWealth = abs($guessWinWealth);
						$io['to_title'] = "「输{$basWinWealth},解冻{$guessKeepWealth}」坐庄竞猜{$guessLink}公布结果";
					}
					$io['wealth'] = $guessWinWealth + $guessKeepWealth - $taxWealth;
					$io['to_balance'] = $guessUser->getAvailableMoney() + $io['wealth'];
				
					//更新金额
					$update = array(
							'available_money' => "available_money + {$io['wealth']}",
							'freeze_money' => "freeze_money - {$guessKeepWealth}"
					);
					if(!$userDao->update($update, $guessUser->getId(), true)){
						$this->rollBack();
						return false;
					}
					//记录细明
					if(!$ioDao->add($io)){
						$this->rollBack();
						return false;
					}
				}elseif($guess->wealthTypeIsIntegral()){
					$io['wealth_type'] = Io::WEALTH_TYPE_INTEGRAL;
					if($guessWinWealth >= 0){
						//赢
						$taxWealth = $guessWinWealth * $guess->getTax();
						$io['to_title'] = "「赢{$guessWinWealth},税{$taxWealth},解冻{$guessKeepWealth}」坐庄竞猜{$guessLink}公布结果";
					}else{
						$basWinWealth = abs($guessWinWealth);
						$io['to_title'] = "「输{$basWinWealth},解冻{$guessKeepWealth}」坐庄竞猜{$guessLink}公布结果";
					}
					$io['wealth'] = $guessWinWealth + $guessKeepWealth - $taxWealth;
					$io['to_balance'] = $guessUser->getAvailableIntegral() + $io['wealth'];
				
					//更新积分
					$update = array(
							'available_integral' => "available_integral + {$io['wealth']}",
							'freeze_integral' => "freeze_integral - {$guessKeepWealth}"
					);
					if(!$userDao->update($update, $guessUser->getId(), true)){
						$this->rollBack();
						return false;
					}
					//记录细明
					if(!$ioDao->add($io)){
						$this->rollBack();
						return false;
					}
				}
				
				//更新竞猜状态
				if(!$guessDao->update(array('status'=>Guess::STATUS_END, 'win_wealth'=>$guessWinWealth), $guess->getId())){
					$this->rollBack();
					return false;
				}
			}
			//更新竞猜点的状态
			if(!MD('GuessPoint')->update(array('status'=>GuessPoint::STATUS_RUDGED), $guessPoint->getId())){
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
	
	private function getGuessPointGuesses(GuessPoint $guessPoint){
		$guessDao = MD('Guess');
		$tempGuesses = $guessDao->gets(array('guess_point_id'=>$guessPoint->getId()));
		$userIds = ArrayUtil::colKeySet($tempGuesses, 'user_id');
		if($userIds){
			$userIds = implode(',', $userIds);
			$userService = MemberServiceFactory::getUserService();
			$tempUsers = $userService->gets("id in ({$userIds})");
			$users = array();
			foreach($tempUsers as $user){
				$user = ModelTransform::toCustomModel(Model::newModel('User', $user), 'User');
				$users[$user->getId()] = $user;
			}
			unset($tempUsers);
		}else{
			$users = array();
		}
		$guesses = array();
		foreach($tempGuesses as $guess){
			$guess['play_datas'] = unserialize($guess['play_datas']);
			$guess['parameter'] = unserialize($guess['parameter']);
			$guess = ModelTransform::toCustomModel(Model::newModel('Guess', $guess), 'Guess');
			$guess->setGuessPoint($guessPoint);
			$guess->setUser($users[$guess->getUserId()]);
			$guesses[$guess->getId()] = $guess;
		}
		unset($tempGuesses);
		return $guesses;
	}
}

?>
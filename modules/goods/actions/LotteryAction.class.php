<?php
/**
 * 抽奖
 * @author blueyb.java@gmail.com
 */
class LotteryAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		// 检查商品状态、用户抽奖记录状态
		$goodsId = $request->getParameter('id');
		if(empty($goodsId)){
			show_message('请选择要抽奖的商品!');
		}
		$goodsDao = MD("Goods");
		$goods = $goodsDao->get($goodsId);
		if(!$goods){
			show_message('商品不存在!');
		}
		if(!$goods['can_exchange'] || $goods['count'] <= 0){
			show_message('商品不支持抽奖或库存不足');
		}
		
		if($request->isPost()){
			$username = $request->getParameter('username');
			$address = $request->getParameter('address');
			$zip = $request->getParameter('zip');
			$mobile = $request->getParameter('mobile');
			if(!$address){
				show_message("收件地址不能为空!");
			}
			if(!$username){
				show_message("收件人不能为空!");
			}
			if(!$zip){
				show_message("邮编不能为空!");
			}
			if(!$mobile){
				show_message("手机号码不能为空!");
			}
			if(!String::test(String::REGEX_MOBILE, $mobile)){
				show_message("手机号码格式不正确!");
			}
			$exchange = array(
				'goods_id' => $goods['id'],
				'user_id' => $this->user->getId(),
				'is_lottery' => 1,
				'is_exchange' => 0,
				'username' => $username,
				'address' => $address,
				'zip' => $zip,
				'mobile' => $mobile,
				'send_status' => 0,
				'receive_status' => 0,
				'create_time' => $request->getRequestTime()
			);
			$exchangeDao = MD("Exchange");
			if($exchangeDao->add($exchange)){
				//更新商品库存
				$goodsDao = MD('Goods');
				$goodsDao->update(array('count'=>'count - 1'), $goods['id'], true);
				AjaxResult::closeAjaxWindow('抽奖成功，正在关闭窗口!');
			}else{
				show_message('兑换失败!');
			}
		}else{
			//检测
			$lotteryRecordDao = MD('LotteryRecord');
			if($goods['lottery_count']){				
				$record = $lotteryRecordDao->getOne(array('goods_id'=>$goods['id'], 'user_id'=>$this->user->getId()));
				if($record && $record['count'] >= $goods['lottery_count']){
					show_message('抱歉，你抽奖次数超过了限制!');
				}
			}
			if($goods['lottery_credit']){
				if($this->user->getAvailableIntegral() < $goods['lottery_credit']){
					show_message('抱歉，你的积分不够!');	
				}			
			}
			
			//增加抽奖次数
			$record = $lotteryRecordDao->getOne(array('goods_id'=>$goods['id'], 'user_id'=>$this->user->getId()));
			if(!$record)
				$lotteryRecordDao->add(array('goods_id'=>$goods['id'], 'user_id'=>$this->user->getId(), 'count'=>'1'));
			else
			{
				$nowCount = $record['count'] + 1;
				$lotteryRecordDao->update(array('count'=>$nowCount), $record['id']);
			}
			
			//消耗积分
			/*
			if($goods['lottery_credit'])
			{
				$nowIntegral = $this->user->getAvailableIntegral() - $goods['lottery_credit'];
				$userDao = MD("User");
				$userDao->update(array('available_integral'=>$nowIntegral), $this->user->getId());		
			}
			*/
			
			//记录积分明细
			$goodsLink = NoticeService::makeGoodsLink(array('id'=>$goods['id'], 'title'=>$goods['title']));
			$io = array(
				'from_user_id'=>$this->user->getId(),
				'to_user_id'=>0,
				'from_title'=>"商品抽奖{$goodsLink}",
				'wealth_type'=>Io::WEALTH_TYPE_INTEGRAL,
				'wealth'=>$goods['lottery_credit'],
				'from_balance'=>$this->user->getAvailableIntegral() - $goods['lottery_credit']
			);
			$userService = MemberServiceFactory::getUserService();
			$userService->integral($io);
			
			//抽奖
			$goodsService = GoodsServiceFactory::getGoodsService();
			$lottery = $goodsService->lottery($this->user, $goods);
			if(!$lottery){
				show_message('抱歉，你没有中奖,下次努力！');
			}
			$request->setAttribute('goods', $goods);
			$this->setView('lottery');

		}
	}
}

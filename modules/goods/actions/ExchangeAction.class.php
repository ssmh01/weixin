<?php
/**
 * 兑换
 * @author blueyb.java@gmail.com
 */
class ExchangeAction extends UserCenterAction{
	public function index(HttpRequest $request){
		// 检查商品状态、用户金币状态
		$goodsId = $request->getParameter('id');
		if(empty($goodsId)){
			show_message('请选择要兑换的商品!');
		}
		$goodsDao = MD("Goods");
		$goods = $goodsDao->get($goodsId);
		if(!$goods){
			show_message('商品不存在!');
		}
		if(!$goods['can_exchange'] || $goods['count'] <= 0){
			show_message('商品不支持兑换或库存不足');
		}
		if($this->user->getAvailableMoney() < $goods['money'] || $this->user->getAvailableMoney() < $goods['money_limit']){
			show_message('你的金币不足，请先充值');
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
				'is_lottery' => 0,
				'is_exchange' => 1,
				'money' => $goods['money'],
				'username' => $username,
				'address' => $address,
				'zip' => $zip,
				'mobile' => $mobile,
				'send_status' => 0,
				'receive_status' => 0,
				'create_time' => $request->getRequestTime()
			);
			$goodsService = GoodsServiceFactory::getGoodsService();
			if($goodsService->exchange($this->user, $goods, $exchange)){
				AjaxResult::closeAjaxWindow('兑换成功，正在关闭窗口!');
			}else{
				show_message('兑换失败!');
			}
		}else{
			$request->setAttribute('goods', $goods);
			$this->setView('exchange');
		}
	}
	public function receive(HttpRequest $request){
		$id = $request->getParameter('id');
		if(!$id){
			show_message('请选择要确认收货的奖品');
		}
		$exchangeDao = MD("Exchange");
		$exchange = $exchangeDao->get($id);
		if(!$exchange){
			show_message('要确认收货的奖品不存在');
		}
		if($exchange['user_id'] != $this->user->getId()){
			show_message('非法操作');
		}
		if($exchangeDao->update(array(
			'receive_status' => '1'
		), $id)){
			AjaxResult::closeAjaxWindow('确认收货成功，正在刷新页面!');
		}else{
			show_message('确认收货失败!');
		}
	}
}
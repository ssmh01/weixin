<?php

/**
 * 支付回调处理
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 4, 2013
 */
class PayAction extends CommonAction{
	
	/**
	 * 转向登陆界面
	 */
	public function index(HttpRequest $request){
		include_once (EXT_LIB_ROOT . '/payment/Payment.php');
		//创建支付工具类
		$paymentUtil = new PaymentUtil();
		//获取合适类型的支付接口
		$payment = $paymentUtil->getProperPayment();
		if(empty($payment)){
			show_message('系统出错，没有找到正确的支付处理方式！');
		}
		//验证通知的正确性
		$verify = $payment->notifyVerify();
		if($verify){
			//检查交易是否成功
			$success = $payment->isSuccessTrade();
			if($success){
				//如果成功,获取通知(响应)参数
				$responseParameter = $payment->getResponseParameter();
				//转换成公共的参数
				$responseParameter = $paymentUtil->responseParameterTransform($payment->getPaymentType(), $responseParameter);
				//Do what you want here with the response parameters.
				//注意,并不是在payment_common_parameter里列出的所有公共响应参数都有返回，只能确保返回
				//payment_out_trade_no(订单号)和payment_total_fee(payment_total_fee)
				$rechargeService = MemberServiceFactory::getRechargeService();
				$recharge = $rechargeService->getBySn($responseParameter['payment_out_trade_no']);
				if(!$recharge){
					show_message('没有找到充值记录', '/member/recharge/history/');
				}
				$user = MD('User')->get($recharge['user_id']);
				if(!$user){
					show_message('没有找到充值用户', '/member/recharge/history/');
				}
				if($rechargeService->pay($user, $recharge)){
					show_message('充值成功!', '/member/recharge/history/');
				}else{
					show_message('支付成功，但系统没有正确运行，请联系客服!', '');
				}
			}else{
				show_message('充值支付失败', '/member/recharge/history/');
			}
		}else{
			show_message('非法支付通知');
		}
	}
}

?>
<?php
class PaymentPartnerProvider implements PartnerProvider{
	
	/*
	 * @see PartnerProvider::getPartner()
	 */
	public function getPartner($paymentType) {
		$partner = new Partner();
		switch ($paymentType){
			case 'alipay':
				/*
				$partner->setId('2088002451288862');
				$partner->setKey('udojyd9v6f509gtszeo1b2do9rdis4y7');
				$partner->setAccount('andyfish2@126.com');
				*/
				$partner->setId(R::getConfig()->getConfig('alipay_parter_id'));
				$partner->setKey(R::getConfig()->getConfig('alipay_parter_key'));
				$partner->setAccount(R::getConfig()->getConfig('alipay_parter_account'));
				break;
			case 'alipaybank':
				$partner->setId('2088301731054756');
				$partner->setKey('xqieuo6dbhkb9hwr0sipxbfdyv6shbur');
				$partner->setAccount('1367278408@qq.com');
				break;
			case 'chinabank':
				$partner->setId('1001');	//商户ID
				$partner->setKey('test');	//MD5密钥,登陆商户后台，地址：https://merchant3.chinabank.com.cn/
				break;
			case 'tenpay':
				$partner->setId('1900000113');
				$partner->setKey('e82573dc7e6136ba414f2e2affbe39fa');
				$partner->setAccount('自助商户测试帐户');
				break;
			case 'bill99':
				$partner->setId('1900000113');
				$partner->setKey('e82573dc7e6136ba414f2e2affbe39fa');
				$partner->setAccount('自助商户测试帐户');
				break;
			default:
				break;
		}
		return $partner;
	}
} 
<?php
/**
 * 用户设置
 * @author blueyb.java@gmail.com
 */
class SettingAction extends UserCenterAction{
	
	public function index(HttpRequest $request){
		$this->base($request);
	}
	
	/**
	 * 更新基本资料
	 * 
	 * @param HttpRequest $request        	
	 */
	public function base(HttpRequest $request){
		if($request->isPost()){
			$sex = intval($request->getParameter('sex'));
			$birthdayYear = intval($request->getParameter('birthday_year'));
			$birthdayMonth = intval($request->getParameter('birthday_month'));
			$birthdayDay = intval($request->getParameter('birthday_day'));
			$province = $request->getParameter('province');
			$city = $request->getParameter('city');
			$sign = $request->getParameter('sign');
			$website = $request->getParameter('website');
			$avatar = $request->getParameter('avatar');
			
			//检测网址是否有人使用
			$Eu = MD('User')->getOne(array('website'=>$website));
			if($Eu && $Eu['id']!=$this->user->getId()) show_message('个性网址重复!');
			
			$update = array(
					'sex' => $sex,
					'birthday_year' => $birthdayYear,
					'birthday_month' => $birthdayMonth,
					'birthday_day' => $birthdayDay,
					'province' => $province,
					'city' => $city,
					'sign' => $sign,
					'website' => $website,
					'avatar' => $avatar,
			);
			if(MD('User')->update($update, $this->user->getId())){
				$ioDao = MD('Io');
				$isReward = $ioDao->count(array('to_user_id'=>$this->user->getId(),'type'=>Io::TYPE_FINISH_USER_INFO_REWARD));
				if(!$isReward && $update['sex'] && $update['birthday_year'] && $update['birthday_month'] && $update['birthday_month'] && $update['birthday_day'] && $update['province'] && $update['city'] && $update['sign'] && $update['avatar'] != User::AVATAR_DEFAULT){
					$userInfoIntegral = intval(R::getConfig()->getConfig('integral_user_info'));
					if($userInfoIntegral){
						//赠送
						$io = array(
								'from_user_id' => 0,
								'type'=>Io::TYPE_FINISH_USER_INFO_REWARD,
								'to_user_id' => $this->user->getId(),
								'to_title' => "完善个人资料",
								'wealth_type' => Io::WEALTH_TYPE_INTEGRAL,
								'wealth' => $userInfoIntegral,
								'from_balance' => $this->user->getAvailableIntegral() + $userInfoIntegral
						);
						MemberServiceFactory::getUserService()->integral($io);
						//通知
						$notice = "完善个人资料，系统赠送你{$userInfoIntegral}积分";
						MemberServiceFactory::getNoticeService()->notice($notice, $this->user->getId());
					}
				}
				
				show_message('修改基本资料成功!');
			}else{
				show_message('修改基本资料失败!');
			}
		}else{
			$seo = array(
					'title' => '基本资料设置',
					'description' => '',
					'keywords' => ''
			);
		
			/* 省市列表 */
			$db = R::getDB();
			$province_arr = $db->getRows("SELECT * FROM yyx_province WHERE 1 ORDER BY id ASC");			
			
			$myProvince = $this->user->getProvince();			
			$myProvinceInfo = $db->getRow("SELECT id FROM yyx_province WHERE name='{$myProvince}'");
			$myProvinceId = $myProvinceInfo['id'];
			
			$city_arr = $db->getRows("SELECT * FROM yyx_city WHERE province_id='{$myProvinceId}' ORDER BY city_index ASC");
			$request->assign('province_arr', $province_arr);
			$request->assign('city_arr', $city_arr);
			
			$request->assign('seo', $seo);
			$this->setView('setting_base');
		}
	}
	
	public function password(HttpRequest $request){
		if($request->isPost()){
			$oldPassword = $request->getParameter('old_password');
			$newPassword = $request->getParameter('new_password');
			$reNewPassword = $request->getParameter('re_new_password');
			if(empty($newPassword)){
				show_message('新密码不能为空');
			}
			if($newPassword != $reNewPassword){
				show_message('两次输入的新密码不相同');
			}
			$userService = MemberServiceFactory::getUserService();
			$status = $userService->modifyPassword($this->user, $oldPassword, $newPassword);
			if($status == 1){
				show_message("修改密码成功!");
			}elseif($status == -1){
				show_message('原密码不对,修改密码失败!');
			}else{
				show_message('修改密码失败!');
			}
		}else{
			$seo = array(
					'title' => '密码设置',
					'description' => '',
					'keywords' => ''
			);
			$request->assign('seo', $seo);
			$this->setView('setting_password');
		}
	}
	
	public function notice(HttpRequest $request){
		if($request->isPost()){
			$configs = $request->getParameters();
			$userDao = MD('User');
			if($userDao->update(array('configs'=>serialize($configs)), $this->user->getId())){
				show_message('修改通知动态成功!');
			}else{
				show_message('修改通知动态失败!');
			}
		}else{
			$seo = array(
					'title' => '通知动态设置',
					'description' => '',
					'keywords' => ''
			);
			$request->assign('seo', $seo);
			$this->setView('setting_notice');
		}
	}
	
	/**
	 * 获取城市列表
	 * @param HttpRequest $request
	 */
	public function citys(HttpRequest $request){
		$provinceName = $request->getParameter('provinceName');
		$db = R::getDb();
		
		$r = $db->getRow("SELECT id FROM yyx_province WHERE name='$provinceName'");
		$provinceID = $r['id'];

		$citys = '';
		if(!empty($provinceID))
		{
			$citys = $db->getRows("SELECT * FROM yyx_city WHERE province_id='$provinceID'");
		}

		AjaxResult::ajaxResult('1', $citys);
	}	
}
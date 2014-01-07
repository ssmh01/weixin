<?php
/**
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-12-23
 * 
 */
class User extends DynamicModelTransformSupport{
	
	/**
	 * 默认头像
	 *
	 * @var int
	 */
	const AVATAR_DEFAULT = '/res/images/avatar.gif';
	
	/**
	 * 系统默认头像
	 *
	 * @var int
	 */
	const AVATAR_SYSTEM = '/res/images/avatar_system.gif';
	
	/**
	 * 名称
	 *
	 * @var int
	 */
	private $id;
	
	/**
	 * 名称
	 *
	 * @var string
	 */
	private $name;
	
	/**
	 * 密码
	 *
	 * @var string
	 */
	private $password;
	
	/**
	 * 邮箱
	 *
	 * @var string
	 */
	private $email;
	
	/**
	 * 昵称
	 *
	 * @var string
	 */
	private $nickname;
	
	/**
	 * 头像
	 *
	 * @var string
	 */
	private $avatar;
	
	/**
	 * 性别
	 *
	 * @var int
	 */
	private $sex;
	
	/**
	 * 生日:年
	 *
	 * @var int
	 */
	private $birthdayYear;
	
	/**
	 * 生日:月
	 *
	 * @var int
	 */
	private $birthdayMonth;
	
	/**
	 * 生日:日
	 *
	 * @var int
	 */
	private $birthdayDay;
	
	/**
	 * 手机号码
	 *
	 * @var string
	 */
	private $mobile;
	
	/**
	 * QQ号码
	 *
	 * @var string
	 */
	private $qq;
	
	/**
	 * 省份
	 *
	 * @var string
	 */
	private $province;
	
	/**
	 * 城市
	 *
	 * @var string
	 */
	private $city;
	
	/**
	 * 地区
	 *
	 * @var string
	 */
	private $area;
	
	/**
	 * 现居住地
	 *
	 * @var string
	 */
	private $address;
	
	/**
	 * 个性签名
	 *
	 * @var string
	 */
	private $sign;
	
	/**
	 * 个性网址
	 *
	 * @var string
	 */
	private $website;
	
	/**
	 * 新浪weibo
	 *
	 * @var string
	 */
	private $sinaWeibo;
	
	/**
	 * 腾讯weibo
	 *
	 * @var string
	 */
	private $qqWeibo;
	
	/**
	 * 可用金额
	 *
	 * @var double
	 */
	private $availableMoney;
	
	/**
	 * 冻结的金额
	 *
	 * @var double
	 */
	private $freezeMoney;
	
	/**
	 * 可用积分
	 *
	 * @var int
	 */
	private $availableIntegral;
	
	/**
	 * 冻结的积分
	 *
	 * @var int
	 */
	private $freezeIntegral;
	
	/**
	 * 被查看次数
	 *
	 * @var int
	 */
	private $views;
	
	/**
	 * 庄家级别
	 *
	 * @var int
	 */
	private $makersLevel;
	
	/**
	 * 坐庄次数
	 *
	 * @var int
	 */
	private $addGuessCount;
	
	/**
	 * 竞猜次数
	 *
	 * @var int
	 */
	private $guessCount;
	
	/**
	 * 竞猜准确率
	 *
	 * @var int
	 */
	private $accuracy;
	
	/**
	 * 粉丝次数
	 *
	 * @var int
	 */
	private $fanCount;
	
	/**
	 * 关注次数
	 *
	 * @var int
	 */
	private $followCount;
	
	/**
	 * 是否允许登陆
	 *
	 * @var int
	 */
	private $allowLogin;
	
	/**
	 * 上次登陆时间
	 *
	 * @var int
	 */
	private $lastLoginTime;
	
	/**
	 * 注册时间
	 *
	 * @var int
	 */
	private $registerTime;
	
	/**
	 * 好友
	 * 
	 * @var string
	 */
	private $friend;
	
	/**
	 * 新通知个数
	 *
	 * @var int
	 */
	private $newNoticeCount = 0;
	
	/**
	 * 新短消息个数
	 *
	 * @var int
	 */
	private $newMessageCount = 0;
	
	/**
	 * 个人设置,序列化
	 *
	 * @var array
	 */
	private $configs;
	
	/**
	 * 配置模板
	 *
	 * @var array
	 */
	private $configTemplate = array(
		'notice' => array(
			'follow_add' => '有人加我为好友',
			'guess_check' => '发布的竞猜通过审核',
			'guess_result' => '发布/参与的竞猜已公布结果',
			'guess_custom_end' => '发布的自定义竞猜已结束',
			'guess_play_invite' => '有人邀请我参与竞猜',
	//		'wealth_change' => '金币与积分变更'
		),
		'trend' => array(
			'trend_condition' => array(
				'name' => '按条件',
				'options' => array(
					'0' => '显示全站竞猜',
					'1' => '显示好友竞猜'
				)
			),
			'trend_time' => array(
				'name' => '按时间',
				'options' => array(
					'1' => '当天发布的竞猜',
					'3' => '三天之内发布的竞猜',
					'7' => '七天之内发布的竞猜'
				)
			)
		)
	);
	
	/**
	 * 默认配置
	 * @var array
	 */
	public static $CONFIGS_DEFAULT = array(
			'follow_add'=>'1',
			'guess_check'=>'1',
			'guess_result'=>'1',
			'guess_custom_end'=>'1',
			'guess_play_invite'=>'1',
			'wealth_change'=>'1',
			'trend_condition'=>'0',
			'trend_time'=>'7',
			);
	
	/**
	 *
	 * @return int
	 */
	public function getId(){
		return $this->id;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setId($id){
		$this->id = $id;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setName($name){
		$this->name = $name;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getPassword(){
		return $this->password;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setPassword($password){
		$this->password = $password;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getEmail(){
		return $this->email;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setEmail($email){
		$this->email = $email;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getNickname(){
		return $this->nickname;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setNickname($nickname){
		$this->nickname = $nickname;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getAvatar(){
		return $this->avatar;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setAvatar($avatar){
		$this->avatar = $avatar;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getSex(){
		return $this->sex;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setSex($sex){
		$this->sex = $sex;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getBirthdayMonth(){
		return $this->birthdayMonth;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setBirthdayMonth($birthdayMonth){
		$this->birthdayMonth = $birthdayMonth;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getBirthdayDay(){
		return $this->birthdayDay;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setBirthdayDay($birthdayDay){
		$this->birthdayDay = $birthdayDay;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getMobile(){
		return $this->mobile;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setMobile($mobile){
		$this->mobile = $mobile;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getQq(){
		return $this->qq;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setQq($qq){
		$this->qq = $qq;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getProvince(){
		return $this->province;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setProvince($province){
		$this->province = $province;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getCity(){
		return $this->city;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setCity($city){
		$this->city = $city;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getArea(){
		return $this->area;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setArea($area){
		$this->area = $area;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getAddress(){
		return $this->address;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setAddress($address){
		$this->address = $address;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getSign(){
		return $this->sign;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setSign($sign){
		$this->sign = $sign;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getWebsite(){
		return $this->website;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setWebsite($website){
		$this->website = $website;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getSinaWeibo(){
		return $this->sinaWeibo;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setSinaWeibo($sinaWeibo){
		$this->sinaWeibo = $sinaWeibo;
	}
	
	/**
	 *
	 * @return string
	 */
	public function getQqWeibo(){
		return $this->qqWeibo;
	}
	
	/**
	 *
	 * @param
	 *        	string
	 */
	public function setQqWeibo($qqWeibo){
		$this->qqWeibo = $qqWeibo;
	}
	
	/**
	 *
	 * @return double
	 */
	public function getAvailableMoney(){
		return $this->availableMoney;
	}
	
	/**
	 *
	 * @param
	 *        	double
	 */
	public function setAvailableMoney($availableMoney){
		$this->availableMoney = $availableMoney;
	}
	
	/**
	 *
	 * @return double
	 */
	public function getFreezeMoney(){
		return $this->freezeMoney;
	}
	
	/**
	 *
	 * @param
	 *        	double
	 */
	public function setFreezeMoney($freezeMoney){
		$this->freezeMoney = $freezeMoney;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getAvailableIntegral(){
		return $this->availableIntegral;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setAvailableIntegral($availableIntegral){
		$this->availableIntegral = $availableIntegral;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getFreezeIntegral(){
		return $this->freezeIntegral;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setFreezeIntegral($freezeIntegral){
		$this->freezeIntegral = $freezeIntegral;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getViews(){
		return $this->views;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setViews($views){
		$this->views = $views;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getMakersLevel(){
		return $this->makersLevel;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setMakersLevel($makersLevel){
		$this->makersLevel = $makersLevel;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getGuessCount(){
		return $this->guessCount;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setGuessCount($guessCount){
		$this->guessCount = $guessCount;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getAccuracy(){
		return $this->accuracy;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setAccuracy($accuracy){
		$this->accuracy = $accuracy;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getFanCount(){
		return $this->fanCount;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setFanCount($fanCount){
		$this->fanCount = $fanCount;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getFollowCount(){
		return $this->followCount;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setFollowCount($followCount){
		$this->followCount = $followCount;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getAllowLogin(){
		return $this->allowLogin;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setAllowLogin($allowLogin){
		$this->allowLogin = $allowLogin;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getLastLoginTime(){
		return $this->lastLoginTime;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setLastLoginTime($lastLoginTime){
		$this->lastLoginTime = $lastLoginTime;
	}
	
	/**
	 *
	 * @return int
	 */
	public function getRegisterTime(){
		return $this->registerTime;
	}
	
	/**
	 *
	 * @param
	 *        	int
	 */
	public function setRegisterTime($registerTime){
		$this->registerTime = $registerTime;
	}
	
	/**
	 *
	 * @return number $newNoticeCount
	 */
	public function getNewNoticeCount(){
		return $this->newNoticeCount;
	}
	
	/**
	 *
	 * @param number $newNoticeCount        	
	 */
	public function setNewNoticeCount($newNoticeCount){
		$this->newNoticeCount = $newNoticeCount;
	}
	
	/**
	 *
	 * @return number $newMessageCount
	 */
	public function getNewMessageCount(){
		return $this->newMessageCount;
	}
	
	/**
	 *
	 * @param number $newMessageCount        	
	 */
	public function setNewMessageCount($newMessageCount){
		$this->newMessageCount = $newMessageCount;
	}
	/**
	 *
	 * @return number $birthdayYear
	 */
	public function getBirthdayYear(){
		return $this->birthdayYear;
	}
	
	/**
	 *
	 * @param number $birthdayYear        	
	 */
	public function setBirthdayYear($birthdayYear){
		$this->birthdayYear = $birthdayYear;
	}
	
	/**
	 *
	 * @return array: $configs
	 */
	public function getConfigs(){
		return $this->configs;
	}
	
	/**
	 * 返回用户配置
	 * @param string $key
	 * @return multitype:
	 */
	public function getConfig($key){
		return $this->configs[$key];
	}
	
	/**
	 *
	 * @param multitype: $configs        	
	 */
	public function setConfigs($configs){
		if(!$configs){
			$configs = array();
		}elseif(is_string($configs)){
			$configs = unserialize($configs);
		}
		$this->configs = $configs;
	}
	
	/**
	 * 获取个人设置模板
	 * @return array
	 */
	public function getConfigTemplate(){
		return $this->configTemplate;
	}
	
	public function getAge(){
		if(!$this->getBirthdayYear()) return 0;
		$nowYear = intval(date('Y', time()));
		return $nowYear - $this->getBirthdayYear();
	}
	
	/**
	 * @return number $addGuessCount
	 */
	public function getAddGuessCount(){
		return $this->addGuessCount;
	}

	/**
	 * @param number $addGuessCount
	 */
	public function setAddGuessCount($addGuessCount){
		$this->addGuessCount = $addGuessCount;
	}

	
	public function getFriend(){
		return $this->friend;
	}
	
	public function setFriend($friend){
		$this->friend = $friend;
	}
}
?>
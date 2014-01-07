<?php
/**
 * 添加竞猜
 * @author blueyb.java@gmail.com
 */
class AddAction extends UserCenterAction{
	
	/**
	 * 添加玩法竞猜
	 * @see Action::index()
	 */
	public function index(HttpRequest $request){
		$guessService = GuessServiceFactory::getGuessService();
		$categoryService =GuessServiceFactory::getGuessCategoryService();
		$rootCategorys = $categoryService->getRoots();
		$categorys = $categoryService->gets();
		if($request->isPost()){
			$guess = new Guess();
			$guess->setUserId($this->user->getId());
			$guess->setGuessPointId($request->getParameter('guess_point_id'));
			$guess->setCateId($request->getParameter('sub_cateid'));
			$guess->setTax(R::getConfig()->getConfig('guess_tax'));
			$guess->setTitle($request->getParameter('title'));
			$guess->setPlayStartTime(strtotime($request->getParameter('play_start_time')));
			$guess->setPlayDeadline(strtotime($request->getParameter('play_deadline')));
			$guess->setWealthType($request->getParameter('wealth_type'));
			$guess->setPlayRole($request->getParameter('play_role'));
			$guess->setSummary($request->getParameter('summary'));
			$guess->setStatus(R::getConfig()->getConfig('guess_add_check'));
			$guess->setCreateTime($request->getRequestTime());
			$guess->setInviteFriend($request->getParameter('invite_friend'));			
			
			//检查
			if(!$guess->getGuessPointId()){
				show_message('竞猜点不能为空');
			}
			$guessPoint = $guessService->getGuessPoint($guess->getGuessPointId());
			if(!$guessPoint){
				show_message('竞猜点不存在');
			}
			if($guessPoint->getPlayDeadline() <= $request->getRequestTime()){
				show_message('竞猜点的竞猜截止时间已到');
			}
			
			if(!$guess->getCateId()){
				show_message('分类不能为空');
			}
			if(!$guess->getTitle()){
				show_message('标题不能为空');
			}
			if(!$guess->getPlayStartTime()){
				$guess->setPlayStartTime($request->getRequestTime());
			}
			if(!$guess->getPlayDeadline() || $guess->getPlayDeadline() < $request->getRequestTime() || $guess->getPlayDeadline() > $guessPoint->getPlayDeadline()){
				show_message('竞猜截止时间不正确');
			}
			if($guess->getPlayDeadline() < $guess->getPlayStartTime()){
				show_message('竞猜开始时间不能大于竞猜截止时间');
			}
			if(!$guess->getSummary()){
				show_message('说明不能为空');
			}
			
			//创建玩法数据
			$tempPlayWayDatas = $request->getParameter('playWayDatas');
			$playWayDatas = array();
			foreach($tempPlayWayDatas as $playWayData){
				$playWayData = BeanUtils::builtInstance('PlayWayData', json_decode($playWayData, true));
				if(!$playWayData->isCorrectData()){
					show_message('玩法中有数据不正确!');
				}
				//创建这个玩法的参数
				$playWayService = GuessServiceFactory::getPlayWayService();
				$playWay = $playWayService->get($playWayData->getId());
				$playWayAdapter = $playWay->getPlayWayAdapter();
				$parameter = $playWayAdapter->getParameter($playWay, $guessPoint);
				$playWayData->setParameter($parameter);
				$playWayDatas[$playWayData->getId()] = $playWayData;
			}
			if(empty($playWayDatas)){
				show_message('至少选择一个玩法');
			}
			$guess->setPlayDatas($playWayDatas);
			if(!$guess->wealthIsEnough($this->user)){
				show_message('你的积分或金币不够，请调整玩法');
			}
			$guess->setUser($this->user);
			if($guessService->add($guess)){
				$scripts =  "<script type='text/javascript'>
						setTimeout(function(){
						parent.window.location = '/guess/view/?id={$guess->getId()}';
						}, 1500);
						</script>";
				show_message('发布成功，正在转跳到浏览页面...'.$scripts);
			}else{
				show_message('发布竞猜失败!');
			}
		}else{
			$request->setAttribute('rootCategorys', $rootCategorys);
			$request->setAttribute('categorys', $categorys);
			$seo = array(
					'title' => '我要坐庄',
					'description' => '',
					'keywords' => ''
			);
			$request->assign('seo', $seo);
			$this->setView('guess_add');
		}
	}
	
	/**
	 * 加载模板
	 * @param HttpRequest $request
	 */
	public function template(HttpRequest $request){
		$guessPointId = intval($request->getParameter('guessPointId'));
		if($guessPointId <= 0){
			show_message('没有找到相应的竞猜模板');
		}
		$guessService = GuessServiceFactory::getGuessService();
		
		//获取竞猜点信息
		$guessPoint = $guessService->getGuessPoint($guessPointId);
		if(!$guessPoint){
			show_message('没有找到相应的竞猜模板');
		}
		
		//获取分类信息
		$cateId = $guessPoint->getCateId();
		$categoryService =GuessServiceFactory::getGuessCategoryService();
		$category = $categoryService->get($cateId);
		if(!$category){
			show_message('没有找到相应的分类模板');
		}
		if(!$category['fixed_odds'] && !$category['float_odds']){
			show_message('分类赔率不正确');
		}
		$parentCategoryId = $category['parent_id'];
		$parentCategory = $categoryService->get($parentCategoryId);
		//获取分类玩法
		if(!$parentCategory['play_ways']){
			show_message('该分类还没有添加玩法！');
		}
		$conditions = " id in ({$parentCategory['play_ways']})";
		$playWayService = GuessServiceFactory::getPlayWayService();
		$playWays = $playWayService->getObjects($conditions);
		if(empty($playWays)){
			show_message('该分类还没有添加玩法！');
		}
		
		$playDeadline = date('Y-m-d H:i', $guessPoint->getPlayDeadline());
		$recomdedDeadline = date('Y-m-d H:i', $guessPoint->getPlayDeadline() - 30 * 60);
		$request->setAttribute('playWays', $playWays);
		$request->setAttribute('playDeadline', $playDeadline);
		$request->setAttribute('recomdedDeadline', $recomdedDeadline);
		$request->setAttribute('category', $category);
		$request->setAttribute('guessPoint', $guessPoint);
		$this->setView('guess_add_template');
	}
	
	/**
	 * 编辑玩法
	 * @param HttpRequest $request
	 */
	public function playWay(HttpRequest $request){
		$playWayId = intval($request->getParameter('pwid'));
		$guessPointId = intval($request->getParameter('gpid'));
		if($playWayId <= 0 || $guessPointId <= 0){
			show_message('参数错误');
		}
		$playWayService = GuessServiceFactory::getPlayWayService();
		$guessService = GuessServiceFactory::getGuessService();
		
		//获取玩法
		$playWay = $playWayService->get($playWayId);
		if(!$playWay){
			show_message('玩法不存在');
		}
		
		//获取竞猜点信息
		$guessPoint = $guessService->getGuessPoint($guessPointId);
		if(!$guessPoint){
			show_message('竞猜点不存在');
		}
	
		//获取分类信息
		$cateId = $guessPoint->getCateId();
		$categoryService =GuessServiceFactory::getGuessCategoryService();
		$category = $categoryService->get($cateId);
		if(!$category){
			show_message('没找到分类');
		}
		if(!$category['fixed_odds'] && !$category['float_odds']){
			show_message('分类赔率不正确');
		}
		
		//玩法参数适配
		$playWayAdapter = $playWay->getPlayWayAdapter();
		$parameter = $playWayAdapter->getParameter($playWay, $guessPoint);
	
		$request->setAttribute('playWay', $playWay);
		$request->setAttribute('parameter', $parameter);
		$request->setAttribute('category', $category);
		$request->setAttribute('guessPoint', $guessPoint);
		$this->setView('guess_add_playway');
	}
	
	/**
	 * 添加自定义竞猜
	 * @param HttpRequest $request
	 */
	public function custom(HttpRequest $request){
		if($request->isPost()){
			$guess = new Guess();
			$guess->setUserId($this->user->getId());
			$guess->setCateId(0);
			$guess->setCustom(1);
			$guess->setTitle($request->getParameter('title'));
			$guess->setPlayStartTime(strtotime($request->getParameter('play_start_time')));
			$guess->setPlayDeadline(strtotime($request->getParameter('play_deadline')));
			$guess->setWealthType(Guess::WEALTH_TYPE_EDPF);
			$guess->setPlayRole($request->getParameter('play_role'));
			$guess->setSummary($request->getParameter('summary'));
			$guess->setStatus(R::getConfig()->getConfig('guess_custom_add_check'));
			$guess->setCreateTime($request->getRequestTime());
			$guess->setInviteFriend($request->getParameter('invite_friend'));
			
			$customType = trim($request->getParameter('custom_type'));
			$myCustomType = trim($request->getParameter('my_custom_type'));
			if($customType){
				$guess->setCustomType($customType);
			}else{
				$guess->setCustomType($myCustomType);
			}
				
			if(!$guess->getTitle()){
				show_message('标题不能为空');
			}
			if(!$guess->getPlayStartTime()){
				$guess->setPlayStartTime($request->getRequestTime());
			}
			if(!$guess->getPlayDeadline() || $guess->getPlayDeadline() < $request->getRequestTime()){
				show_message('竞猜截止时间不正确');
			}
			if($guess->getPlayDeadline() < $guess->getPlayStartTime()){
				show_message('竞猜开始时间不能大于竞猜截止时间');
			}
			if(!$guess->getCustomType()){
				show_message('下注形式不能为空');
			}
			if(!$guess->getSummary()){
				show_message('说明不能为空');
			}
			
			//创建竞猜参数
			$options = $request->getParameter('options');
			$options = array_filter($options);
			if(count($options) < 2){
				show_message('自定义选项数量不能小于2');
			}
			$parameter = new PlayWayParameter();
			foreach($options as $key=>$option){
				$parameterOption = new PlayWayParameterOption();
				$parameterOption->setLabel($option);
				$parameterOption->setValue($key);
				$parameter->addOption($parameterOption);
			}
			$guess->setParameter($parameter);
			$guess->setUser($this->user);
			
			$guessService = GuessServiceFactory::getCustomGuessService();
			if($guessService->add($guess)){
				$scripts =  "<script type='text/javascript'>
						setTimeout(function(){
						parent.window.location = '/guess/view/?id={$guess->getId()}';
						}, 1500);
						</script>";
				show_message('发布成功，正在转跳到浏览页面...'.$scripts);
			}else{
				show_message('发布竞猜失败!');
			}
		}else{
			$customTypes = MD('CustomType')->gets(null, null, array('sort_num'=>'desc'));
			$seo = array(
				'title' => '自定义竞猜-我要坐庄',
				'description' => '',
				'keywords' => ''
			);
			$request->assign('customTypes', $customTypes);
			$request->assign('seo', $seo);
			$this->setView('custom_add');
		}
	}
}
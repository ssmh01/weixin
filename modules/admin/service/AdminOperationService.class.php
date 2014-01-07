<?php

/**
 * 后台操作服务实现
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-05
 */
class AdminOperationService implements IAdminOperationService{
	
	/**
	 * 操作
	 *
	 * @var array
	 */
	private static $operations = array(
		'系统管理' => array(
			'config' => array(
				'name' => '系统设置',
				'methods' => array(
					'index' => '浏览',
					'update' => '编辑'
				)
			),
			'emailTemplate' => array(
				'name' => '邮件模板',
				'methods' => array(
					'index' => '浏览',
					'edit' => '编辑'
				)
			),
			'menu' => array(
				'name' => '菜单管理',
				'methods' => array(
					'index' => '浏览',
					'add' => '添加',
					'edit' => '编辑',
					'del' => '删除'
				)
			)
		),
		'管理员管理' => array(
			'manager' => array(
				'name' => '管理员',
				'methods' => array(
					'index' => '浏览',
					'add' => '添加',
					'edit' => '编辑',
					'del' => '删除'
				)
			),
			'manageGroup' => array(
				'name' => '管理组',
				'methods' => array(
					'index' => '浏览',
					'add' => '添加',
					'edit' => '编辑',
					'del' => '删除',
					'permission' => '权限分配'
				)
			)
		),
		'用户管理' => array(
			'user' => array(
				'name' => '用户管理',
				'methods' => array(
					'index' => '浏览',
					'edit' => '编辑'
				)
			),
			'recharge' => array(
				'name' => '用户充值',
				'methods' => array(
					'index' => '浏览'
				)
			),
			'makersAuth' => array(
				'name' => '庄家认证',
				'methods' => array(
					'index' => '浏览',
					'allow' => '通过',
					'refuse' => '拒绝',
					'del' => '删除',
				)
			)
		),
		'商城管理' => array(
			'goods' => array(
				'name' => '商品管理',
				'methods' => array(
					'index' => '浏览',
					'add' => '添加',
					'edit' => '编辑',
					'del' => '删除'
				)
			),
			'exchange' => array(
				'name' => '兑换抽奖',
				'methods' => array(
					'index' => '浏览',
					'shipments' => '发货'
				)
			)
		),
		'文章管理' => array(
			'news' => array(
				'name' => '文章管理',
				'methods' => array(
					'index' => '浏览',
					'add' => '添加',
					'edit' => '修改',
					'del' => '删除',
					'view' => '查看'
				)
			),
			'newsCategory' => array(
				'name' => '分类管理',
				'methods' => array(
					'index' => '浏览',
					'add' => '添加',
					'edit' => '修改',
					'del' => '删除'
				)
			)
		),		
		'竞猜管理' => array(
			'guess' => array(
				'name' => '竞猜坐庄',
				'methods' => array(
					'index' => '浏览',
					'check' => '审核',
					'close' => '关闭',
					'del' => '删除'
				)
			),
			'guessCategory' => array(
				'name' => '竞猜分类',
				'methods' => array(
					'index' => '浏览',
					'add' => '添加',
					'edit' => '编辑',
					'del' => '删除',
					'playWay' => '玩法编辑'
				)
			),
			'guessPoint' => array(
				'name' => '竞猜点',
				'methods' => array(
					'index' => '浏览',
					'add' => '添加',
					'edit' => '编辑',
					'del' => '删除',
					'enable' => '启用',
					'param' => '编辑参数',
					'result' => '结果判定'
				)						
			),
			'playWay' => array(
				'name' => '竞猜玩法',
				'methods' => array(
					'index' => '浏览',
					'add' => '添加',
					'edit' => '编辑',
					'del' => '删除',
					'enable' => '启用'
				)		
			),
			'customType' => array(
				'name' => '自定义类型',
				'methods' => array(
					'index' => '浏览',
					'add' => '添加',
					'edit' => '修改',
					'del' => '删除'
				)			
			)		
		)
	);
	
	private static $operations_array = array(
		'admin' => array(
			'actions' => array(
				//系统设置
				'config' => array(
					'methods' => array(
						'index' => '浏览',
						'update' => '编辑',
					)
				),
				//菜单管理
				'menu' => array(
					'methods' => array(
						'index' => '浏览',
						'add' => '添加',
						'edit' => '编辑',
						'del' => '删除',
					)
				),
				//邮件模板
				'emailTemplate' => array(
					'methods' => array(
						'index' => '浏览',
						'edit' => '编辑',
					)
				),				
				//管理员管理	
				'manager' => array(
					'methods' => array(
						'index' => '浏览',
						'add' => '添加',
						'edit' => '编辑',
						'del' => '删除'
					)
				),
				//管理组管理
				'manageGroup' => array(
					'methods' => array(
						'index' => '浏览',
						'add' => '添加',
						'edit' => '编辑',
						'del' => '删除',
						'permission' => '权限分配'
					)
				),
				//用户管理
				'user' => array(
					'methods' => array(
						'index' => '浏览',
						'edit' => '编辑'
					)
				),
				//用户充值
				'recharge' => array(
					'methods' => array(
						'index' => '浏览'
					)
				),
				//庄家认证	
				'makersAuth' => array(
					'methods' => array(
						'index' => '浏览',
						'allow' => '通过',
						'refuse' => '拒绝',
						'del' => '删除',
					)
				),
				//商品管理
				'goods' => array(
					'methods' => array(
						'index' => '浏览',
						'add' => '添加',
						'edit' => '编辑',
						'del' => '删除'
					)
				),								
				//兑换抽奖	
				'exchange' => array(
					'methods' => array(
						'index' => '浏览',
						'shipments' => '发货'
					)
				),
				//文章管理					
				'news' => array(
					'methods' => array(
						'index' => '浏览',
						'add' => '添加',
						'edit' => '修改',
						'del' => '删除',
						'view' => '查看'
					)
				),
				//分类管理
				'newsCategory' => array(
					'methods' => array(
						'index' => '浏览',
						'add' => '添加',
						'edit' => '修改',
						'del' => '删除'
					)
				),
				//竞猜坐庄
				'guess' => array(
					'methods' => array(
						'index' => '浏览',
						'check' => '审核',
						'close' => '关闭',
						'del' => '删除'
					)
				),
				//竞猜分类
				'guessCategory' => array(
					'methods' => array(
						'index' => '浏览',
						'add' => '添加',
						'edit' => '编辑',
						'del' => '删除',
						'playWay' => '玩法编辑'
					)
				),
				//竞猜点
				'guessPoint' => array(
					'methods' => array(
						'index' => '浏览',
						'add' => '添加',
						'edit' => '编辑',
						'del' => '删除',
						'enable' => '启用',
						'param' => '编辑参数',
						'result' => '结果判定'
					)
				),
				//竞猜玩法
				'playWay' => array(
					'methods' => array(
						'index' => '浏览',
						'add' => '添加',
						'edit' => '编辑',
						'del' => '删除',
						'enable' => '启用'
					)
				),
				//自定义类型
				'customType' => array(
					'methods' => array(
						'index' => '浏览',
						'add' => '添加',
						'edit' => '修改',
						'del' => '删除'
					)
				)		
			)		
		)
	);
	
	/*
	 * @see IOperationService::getModules()
	 */
	public function getOperations(){
		return self::$operations;
	}
	
	/*
	 * @see IOperationService::getOperationName()
	 */
	public function getOperationName(Operation $operation){
		if(!$operation->getModule() || !$operation->getAction()) return '';
		$name = self::$operations[$operation->getModule()]['name'];
		$name .= '@' . self::$operations[$operation->getModule()]['actions'][$operation->getAction()]['name'];
		if($operation->getMethod()){
			$name .= '@' . self::$operations[$operation->getModule()]['actions'][$operation->getAction()]['methods'][$operation->getMethod()];
		}
		return $name;
	}
	
	/*
	 * @see IOperationService::needPermission()
	 */
	public function needPermission(Operation $operation){
		return isset(self::$operations_array[$operation->getModule()]['actions'][$operation->getAction()]['methods'][$operation->getMethod()]);
	}
	
	/*
	 * @see IOperationService::hasPermission()
	 */
	public function hasPermission(Operation $operation, $employe){
		if(!$this->needPermission($operation)) return true; // 不需要权限
		
		$managerService = AdminServiceFactory::getManagerService();
		if($managerService->isFounder($employe)) return true; //是创始人
		
		if(empty($employe['group_id'])) return false; // 没有分配角色
		
		$roleDao = MD('ManageGroup');
		$role = $roleDao->get($employe['group_id']);
		if(empty($role)) return false; // 角色不存在
		
		$permissions = unserialize($role['permissions']);
		$key = $operation->getKey();
		return $permissions[$key];
	}
}

?>
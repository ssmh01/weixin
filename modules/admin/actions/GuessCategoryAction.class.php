<?php
/**
 * 竞猜分类
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-02
 */
class GuessCategoryAction extends AbstractAdminAction{
	
    private $guessCategoryService;
    
    protected $leftMenuParentId = 15;

    public function __construct(){
        parent::__construct();
        $this->guessCategoryService = GuessServiceFactory::getGuessCategoryService();
    }

    /**
     * 获取可分配的上级链
     */
    private function _getEnableParents(){
        $parents = $this->guessCategoryService->getParents();
        foreach($parents as $k => $v){
            if($v['status']){
                $parents[$k]['name'] = str_repeat('—', $v['layer']).$v['name'];
            }else{
                unset($parents[$k]);
            }
        }
        return $parents;
    }

    /**
     * 列表
     *
     * @param HttpRequest $request
     */
    public function index(HttpRequest $request){
        $list = $this->guessCategoryService->gets();
        foreach($list as $k => $v){
            $list[$k]['name'] = '|-'.str_repeat('----', $v['layer']).' '.$v['name'];
        }
        $request->assign('list', $list);
        $request->assign('title', '系统竞猜分类');
        $request->assign('parents', $this->_getEnableParents());
    }

    /**
     * 添加界面
     *
     * @param HttpRequest $request
     */
    public function add(HttpRequest $request){
    	$request->assign('title', '添加竞猜分类');
        $request->assign('parents', $this->_getEnableParents());
    }

    /**
     * 修改界面
     *
     * @param HttpRequest $request
     */
    public function edit(HttpRequest $request){
        parent::edit($request);
        $item = $request->getAttribute('item');
        $request->assign('parents', $this->_getEnableParents());
        $request->assign('title', '修改竞猜分类');
    }

    /**
     * 删除
     *
     * @param HttpRequest $request
     */
    public function del(HttpRequest $request){
        $id = $request->getParameter('id');
        empty($id) && show_message(get_lang('no_record_common'));
        $this->guessCategoryService->haveSubGuessCategory($id) && show_message('请先删除子分类');
        $guessCategory = $this->guessCategoryService->get($id);
        if($this->guessCategoryService->delete($id)){
            $this->setMessage('op_success');
            $request->redirect($request->getAttribute('index_url'));
        }else{
            show_message('operation_failed_common');
        }
    }
    
    /**
     * 玩法编辑
     *
     * @param HttpRequest $request
     */
    public function playWay(HttpRequest $request){
    	$id = $request->getParameter('id');
    	empty($id) && show_message(get_lang('no_record_common'));
    	$guessCategory = $this->guessCategoryService->get($id);
    	if(!$request->isPost()){
    		$guessCategory['play_ways'] = explode(',', $guessCategory['play_ways']);
    		$playWayService = GuessServiceFactory::getPlayWayService();
    		$playWays = $playWayService->gets(array('status'=>'1'));
    		$request->assign('item', $guessCategory);
    		$request->assign('playWays', $playWays);
    		$request->assign('title', '编辑分类玩法');
    	}else{
    		$playWays = $request->getParameter('play_ways');
    		$playWays = implode(',', $playWays);
    		$dao = MD('GuessCategory');
    		if($dao->update(array('play_ways'=>$playWays), $id)){
    			//操作成功
    			$this->setMessage('op_success');
    			$request->redirect($request->getReferer());
    		}else{
    			show_message(get_lang('operation_failed_common'));
    		}
    	}
    }
}
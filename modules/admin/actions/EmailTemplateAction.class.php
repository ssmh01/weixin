<?php
/**
 * 邮件模板　
 * @author blueyb.java@gmail.com
 * @since 1.0 2012-08-03
 */
class EmailTemplateAction extends AbstractAdminAction{

     protected $leftMenuParentId = 1;
	
	/**
	 * 模型列表，只能处理单表
	 * @see Action::index()
	 */
	public function index(HttpRequest $request){
		$model =$this->createModelByAdminAction();
		$modelDao = MD($model);
		$items = $modelDao->gets($this->getConditions(), null, $this->getOrders(), $this->getPage(), $this->getPerpage());
		$total = $modelDao->count($this->getConditions());
		$pages = multi_page($total, $this->getPerpage(), $this->getPage());
		$request->setAttribute('items', $items);
		$request->setAttribute('total', $total);
		$request->setAttribute('pages', $pages);
		$request->setAttribute('title', '邮件模板');
	}
	
	public function edit(HttpRequest $request){
		parent::edit($request);
		$request->setAttribute('title', '编辑邮件模板');
	}
	
	public function update(HttpRequest $request){
		$id = $request->getParameter('id');
		if(empty($id)){
			show_message(get_lang('no_record_common'));
		}
		$modelDao = MD('EmailTemplate');
		$item = $modelDao->get($id);
		if(empty($item)){
			show_message(get_lang('empty_record_common'));
		}
		$item['name'] = $request->getParameter('name');
		$item['subject'] = $request->getParameter('subject');
		$item['value'] = $request->getParameter('value');
        if($modelDao->update($item, $id)){
        	$request->redirect($request->getAttribute('index_url'));
        }else{
        	show_message('operation_failed_common');
        }
	}
}
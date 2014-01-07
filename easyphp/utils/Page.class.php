<?php
/**
 * 分页工具类
 * @author blueyb.java@gmail.com
 * @since 1.0 -  2012-01-27
 * 方法调用:
 *	$pages = new Page($count, $perpage, $page, '/cms/news/list/?key=top');	创建对象
 *	$pages->setShowPageNum($num);			设置显示的页数
 *	$pages->setCurrentIndexPage($num);		设置当前页在分页栏中的位置
 *	$pages->setAnchor('anchor');			设置锚点
 *	$pages->setFirstPageText($text);		设置链接第一页显示的文字
 *	$pages->setLastPageText($text);			设置链接最后一页显示的文字
 *	$pages->setPrePageText($text);			设置链接上一页显示的文字
 *	$pages->setNextPageText($text);			设置链接下一页显示的文字
 *	$pages->setPageCss($css);				设置各分页码css样式的class名称
 *	$pages->setCurrentPageCss($css);		设置当前页码css样式的class名称
 *	$pages->setPageStyle($style);			设置各分页码的样式，即style属性
 *	$pages->setCurrentPageStyle($style);	设置当前页码的样式，即style属性
 *	$pages->setLinkSymbol('=');				设置地址链接中页码与变量的连接符，如page=2中的“=”
 *	$pages->isShowFirstAndLast(true);		设置是否显示第一页与最后一页的链接
 *	$pages->isShowForSimplePage(true);		设置当只有一页时是否显示分页
 *	$pageCount = $pages->getTotalPageNum();	获取总页数
 */

class Page{
	private $eachDisNums;					//每页显示的条目数
	private $nums;							//总条目数
	private $pageParamName = 'page';		//分页参数名
	private $currentPage;					//当前被选中的页
	private $showPageNum = 9;				//每次显示的页数
	private $curIndexPage = 5;				//当前页在分页中的位置
	private $totalPageNum;					//总页数
	private $arrPage = array();				//用来构造分页的数组
	private $subPageLink;					//每个分页的链接
	private $anchor = '';					//锚点
	private $firstPageText = '首页';			//第一页显示的文字
	private $lastPageText = '末页';					//最后一页显示的文字
	private $prePageText = '<<上一页';				//上一页显示的文字
	private $nextPageText = '下一页>>';			//下一页显示的文字
	private $pageCss = '';					//一般页的样式名称
	private $curPageCss = 'active';				//当前页的样式名称
	private $pageStyle = '';				//一般页的样式
	private $curPageStyle = '';				//当前页的样式
	private $isShowFirstLast = true;		//是否显示第一页和最后一页
	private $isShowForSimplePage = false;	//当没有分页时(即总条目数不大于每页显示的条目数)是否显示分页栏
	
	/**
	 * 构造方法
	 *
	 * @param integer $nums 总条目数
	 * @param integer $eachDisNums 每页显示的条目数
	 * @param integer $currentPage 当前被选中的页
	 * @param string $subPageLink 每个分页的链接，如果不指定则使用当前的请求URL
	 * @return void
	 */
	public function __construct($nums, $eachDisNums, $currentPage, $subPageLink){
		$nums = $nums==0 ? 1: $nums;
		$this->nums = intval($nums);
		$this->totalPageNum = ceil($nums/$eachDisNums);
		$this->eachDisNums=intval($eachDisNums);
		$this->currentPage =intval($currentPage);
		$this->currentPage =  $this->currentPage<=0 ? 1: $this->currentPage;
		$this->currentPage = $this->currentPage > $this->totalPageNum ? 1 : $this->currentPage;
		if(!$subPageLink){
			$subPageLink = dynamicUrl();
			if(strpos($subPageLink, '?') === false){
				$subPageLink .= '?'; 
			}
		}
		$this->subPageLink = $subPageLink;
	}
	
	/**
	 * 设置显示的页数
	 *
	 * @param integer $num 显示的页数
	 * @return void
	 */
	public function setShowPageNum($num){
		$this->showPageNum = $num;
	}

	/**
	 * 设置当前页在分页栏中的位置
	 *
	 * @param integer $num 当前页在分页栏中的位置
	 * @return void
	 */
	public function setCurrentIndexPage($num){
		$this->curIndexPage = $num;
	}
	
	/**
	 * 设置分页参数名
	 * @param string $pageParamName
	 */
	public function setPageParamName($pageParamName) {
		$this->pageParamName = $pageParamName;
	}

	/**
	 * 设置锚点
	 *
	 * @param string $anchor 锚点名
	 * @return void
	 */
	public function setAnchor($anchor){
		$this->anchor = $anchor;
	}

	/**
	 * 设置链接第一页显示的文字
	 *
	 * @param string $text 要显示的文字
	 * @return void
	 */
	public function setFirstPageText($text){
		$this->firstPageText = $text;
	}

	/**
	 * 设置链接最后一页显示的文字
	 *
	 * @param string $text 要显示的文字
	 * @return void
	 */
	public function setLastPageText($text){
		$this->lastPageText = $text;
	}

	/**
	 * 设置链接上一页显示的文字
	 *
	 * @param string $text 要显示的文字
	 * @return void
	 */
	public function setPrePageText($text){
		$this->prePageText = $text;
	}

	/**
	 * 设置链接下一页显示的文字
	 *
	 * @param string $text 要显示的文字
	 * @return void
	 */
	public function setNextPageText($text){
		$this->nextPageText = $text;
	}

	/**
	 * 设置各分页码css样式的class名称
	 *
	 * @param string $css css样式名称
	 * @return void
	 */
	public function setPageCss($css){
		$this->pageCss = $css;
	}

	/**
	 * 设置当前页码css样式的class名称
	 *
	 * @param string $css css样式名称
	 * @return void
	 */
	public function setCurrentPageCss($css){
		$this->curPageCss = $css;
	}

	/**
	 * 设置各分页码的样式，即style属性
	 *
	 * @param string $style style样式
	 * @return void
	 */
	public function setPageStyle($style){
		$this->pageStyle = $style;
	}

	/**
	 * 设置当前页码的样式，即style属性
	 *
	 * @param string $style style样式
	 * @return void
	 */
	public function setCurrentPageStyle($style){
		$this->curPageStyle = $style;
	}

	/**
	 * 获取总页数
	 *
	 * @access private
	 * @return integer
	 */
	public function getTotalPageNum(){
		return $this->totalPageNum;
	}

	/**
	 * 设置是否显示第一页与最后一页的链接
	 *
	 * @param boolean $is true:显示，false:不显示
	 * @return void
	 */
	public function isShowFirstAndLast($is){
		$this->isShowFirstLast = $is;
	}

	/**
	 * 设置当只有一页时是否显示分页
	 *
	 * @param boolean $is true:显示，false:不显示
	 * @return void
	 */
	public function isShowForSimplePage($is){
		$this->isShowForSimplePage = $is;
	}


	/**
	 * 生成分页
	 * @return string
	 */
	public function generatePages(){
		//去掉url上的页参数
		if(preg_match("/{$this->pageParamName}=.+?&*/",  $this->subPageLink)){
			$this->subPageLink = preg_replace("/{$this->pageParamName}=.+?&*/", '', $this->subPageLink);
		}
		
		$subPageCss2Str = "<div class='pagination pagination-centered'><ul>";

		$isShow = false;
		if($this->totalPageNum == 1){	//只有一页时
			if($this->isShowForSimplePage){
				$isShow = true;
			}
		}else{
			$isShow = true;
		}
		
		if($isShow){
			if($this->currentPage > 1){
				//构造上一页
				$prewPageUrl = $this->generateUrl($this->currentPage - 1);
				if($this->isShowFirstLast){
					$firstPageUrl = $this->generateUrl(1);
					$subPageCss2Str .= '<li><a href="'.$firstPageUrl.'" class="'.$this->pageCss.'" style="'.$this->pageStyle.'">'.$this->firstPageText.'</a></li>';
				}
				$subPageCss2Str .= '<li><a href="'.$prewPageUrl.'" class="'.$this->pageCss.'" style="'.$this->pageStyle.'">'.$this->prePageText.'</a></li>';
			}

			$pages=$this->construct_num_Page();
			$pageCount = count($pages);
			for($i=0; $i<$pageCount; $i++){
				$page=$pages[$i];
				if($page == $this->currentPage ){
					$subPageCss2Str .= '<li class="'.$this->curPageCss.'"><a href="#'.($this->anchor ? $this->anchor : '').'" class="'.$this->curPageCss.'" style="'.$this->curPageStyle.'">'.$page.'</a></li>';
				}else{
					$url = $this->generateUrl($page);
					$subPageCss2Str .= '<li><a href="'.$url.'" class="'.$this->pageCss.'" style="'.$this->pageStyle.'">'.$page.'</a></li>';
				}
			}
			if($this->currentPage < $this->totalPageNum){
				$nextPageUrl = $this->generateUrl($this->currentPage+1);
				$subPageCss2Str .= '<li><a href="'.$nextPageUrl.'" class="'.$this->pageCss.'" style="'.$this->pageStyle.'">'.$this->nextPageText.'</a></li>';
				if($this->isShowFirstLast){
					$lastPageUrl = $this->generateUrl($this->totalPageNum);
					$subPageCss2Str .= '<li><a href="'.$lastPageUrl.'" class="'.$this->pageCss.'" style="'.$this->pageStyle.'">'.$this->lastPageText.'</a></li> ';
				}
			}
		}
		$subPageCss2Str .= '</ul></div>';
		return $subPageCss2Str;
	}//End of generatePages() Method
	
	/**
	 * 产生页链接
	 * @param int $page
	 * @return string
	 */
	private function generateUrl($page){
		$url = "{$this->subPageLink}&{$this->pageParamName}={$page}";
		$url = url($url);
		$url .= ($this->anchor ? ('#'.$this->anchor) : '');
		return $url;
	}

	/**
	 * 用来给建立分页的数组初始化的函数。
	 *
	 * @return array
	 */
	private function initArray(){
		for($i=0; $i < $this->showPageNum; $i ++){
			$this->arrPage[$i] = $i;
		}
		return $this->arrPage;
	}//End of initArray() Method

	/**
	 * 用来构造显示的条目
	 * 即：[1][2][3][4][5][6][7][8][9][10]
	 *
	 * @return array
	 */
	private function construct_num_Page(){
		if($this->totalPageNum < $this->showPageNum){
			$currentArray = array();
			for($i=0; $i < $this->totalPageNum; $i ++){
				$currentArray[$i] = $i + 1;
			}
		}else{
			$currentArray = $this->initArray();
			$curArrayLen = count($currentArray);
			if($this->currentPage <= $this->curIndexPage){
				for($i=0; $i < $curArrayLen; $i ++){
					$currentArray[$i] = $i+1;
				}
			}elseif (($this->currentPage <= $this->totalPageNum) && ($this->currentPage > ($this->totalPageNum - $this->showPageNum + 1))){	
				//构造最后的分页栏，35 36 37 38 39 40 [下一页] [最后一页] 总页数为40
				for($i=0; $i < $curArrayLen; $i ++){
					$currentArray[$i] = $this->totalPageNum - $this->showPageNum + 1 + $i;
				}
			}else{
				for($i=0; $i < $curArrayLen; $i ++){
					$currentArray[$i] = $this->currentPage - $this->curIndexPage + 1 +$i;
				}
			}
		}

		return $currentArray;
	}//End of construct_num_Page() Method
}//End of Pages Class
?>
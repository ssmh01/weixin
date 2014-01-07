<?php

/**
 * 用来访问静态资源.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2012-03-22
 */
class res extends TagSelfParse{
	
	/**
	 * 资源服务器url
	 * @var string
	 */
	private $resServerUrl = null;
	
	public function __construct(){
		$this->resServerUrl = get_config('site_url');
	}
	
	public function getName(){
		return __CLASS__;
	}
	
	/**
	 * @see TagSelfParse::start()
	 */
	public function start($tag){
		return $tag->toString();
	}
	
	/**
	 * access the css resources
	 * @param Tag $tag
	 */
	public function startCss($tag){
		$cssUrl = $this->resServerUrl . '/res/css/';
		//$time = time();
		//$script =  "<link rel=\"stylesheet\" href=\"{$cssUrl}{$tag->getBody()}?t={$time}\" />";
		$script =  "<link rel=\"stylesheet\" href=\"{$cssUrl}{$tag->getBody()}\" />";
		return $script;
	}
	
	/**
	 * access the js resources
	 * @param Tag $tag
	 */
	public function startJs($tag){
		$jsUrl = $this->resServerUrl . '/res/js/';
		//$time = time();
		//$script =  "<script type=\"text/javascript\" src=\"{$jsUrl}{$tag->getBody()}?t={$time}\"></script>";
		$script =  "<script type=\"text/javascript\" src=\"{$jsUrl}{$tag->getBody()}\"></script>";
		return $script;
	}
	
	/**
	 * access the image resources
	 * @param Tag $tag
	 */
	public function startImage($tag){
		$imageUrl = $this->resServerUrl . '/res/images/';
		$script =  $imageUrl . $tag->getBody();
		return $script;
	}
	
	/**
	 * access the image resources
	 * @param Tag $tag
	 */
	public function startAttach($tag){
		$attachedUrl =  $this->resServerUrl . '/res/attached/';
		$script =  $attachedUrl . $tag->getBody();
		return $script;
	}
}
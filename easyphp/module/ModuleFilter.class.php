<?php

/**
 * 模块过滤器，用来在Action的服务方法执行之前对Moudel进行事务处理
 * @author blueyb.java@gmail.com
 * @since 1.0 - Feb 16, 2012
 */
interface ModuleFilter{
	
	/**
	 * 对Moudel进行事务处理，在Action的服务方法执行前调用
	 * @param Module $module
	 * @param HttpReqeust $request
	 */
	public function doFilter(Module $module, HttpRequest $request);
}

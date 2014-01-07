<?php

/**
 * This class file define a compile interface to compile the template file.
 * You can use you compiler to compile template by setting the configure item 
 * of mvc framework.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - 2011-2-14
 */

interface CompileInterface{
	
	/**
	 * Set up the compile environment.
	 */
	public function setUp($config);
	
	/**
	 * Compile the template and get the template content after compile.
	 * 
	 * @param <code>Template</code> $template
	 * 		The template you want to compile.
	 * @return string
	 * 		The template content after compile.
	 */
	public function compile(Template $template);
}
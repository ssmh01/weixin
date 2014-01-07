<?php

/**
 * This Object use to process the event produce by scanner.
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0  -  2011-03-14
 */
interface ScanProcessorInterface{
	
	/**
	 * This method been call before scan start.
	 */
	public function start();
	
	/**
	 * This method been call when the scanner had scan a character in normal mode.
	 * @param string $char
	 */
	public function hold($char);
	
	/**
	 * This method been call when the scanner had scan a Tag.
	 * @param Tag $tag
	 * @param Tag $parentTag
	 */
	public function startTag($tag, $parentTag);
	
	/**
	 * This method been call after the scanner had scan a Tag.
	 * @param Tag $tag
     * @param Tag $parentTag
	 */
	public function endTag($tag, $parentTag);
	
	/**
	 * This method been call after scan finished.
	 */
	public function end();
}
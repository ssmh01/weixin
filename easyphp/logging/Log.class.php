<?php

/**
* This Object reprents a simple light-weight logging class
* @author blueyb.java@gmail.com
* @since 1.0 - 2010-12-17
*/
class Log {
	
	/**
	 * The log level.
	 */
	private $level;

	/**
	 * The file to record the log.
	 */
	private $logFile	= null;

	function __construct($level) {	
		$this->setLevel($level);
	}
	
	public function setLevel($level){
		if(LogLevel::isLogLevel($level)){
			$this->level = $level;
		}else{
			$this->level = LogLevel::OFF;
		}
	}
	
	public function getLevel(){
		return $this->level;
	}
	
	public function setLogFile($logFile){
		$this->logFile = $logFile;
	}
	
	public function getLogFile(){
		return $this->logFile;
	}

	function debug($msgString, $callFile, $callLine) {
		if($this->level < LogLevel::DEBUG) return;
		$this->log($msgString, LogLevel::DEBUG, $callFile, $callLine);
	}
	
	function info($msgString, $callFile, $callLine) {
		if($this->level < LogLevel::INFO) return;
		$this->log($msgString, LogLevel::INFO, $callFile, $callLine);	
	}

	function warn($msgString, $callFile, $callLine) {
		if($this->level < LogLevel::WARN) return;
		$this->log($msgString, LogLevel::WARN, $callFile, $callLine);	
	}

	function error($msgString, $callFile, $callLine) {
		if($this->level < LogLevel::ERROR) return;
		$this->log($msgString, LogLevel::ERROR, $callFile, $callLine);
	}

	function fatal($msgString, $callFile, $callLine) {
		if($this->level < LogLevel::FATAL) return;
		$this->log($msgString, LogLevel::FATAL, $callFile, $callLine);
	}
	
	private function log($msgString, $level, $callFile, $callLine){
		if($this->logFile != '' && $this->logFile != NULL) {
			$msgString = LogLevel::getLevelName($level) . "#" . date( "Y-m-d H:i:s ") . ": " . $msgString . "\n";
			if($callFile){
				$msgString .= "--------";
				if($callLine){
					$msgString .= "({$callLine})";
				}
				$msgString .= $callFile . "\n\n";
			}
			$logFile = @fopen($this->logFile, "a+");
			@fseek($logFile, 0);
			@fwrite($logFile, $msgString);
			@fclose($logFile);
		}else{
			$msgString = LogLevel::getLevelName($level) . "#" . date( "Y-m-d H:i:s ") . ": " . $msgString . "<br>";
			if($callFile){
				$msgString .= "--------";
				if($callLine){
					$msgString .= "({$callLine})";
				}
				$msgString .= $callFile . "<br><br>";
			}
			echo $msgString;
		}
	}
}

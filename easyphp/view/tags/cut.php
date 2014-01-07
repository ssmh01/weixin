<?php
/**
 * This class use to parse the for tag.
 *
 * @author Away shaoweizheng@163.com
 */
class cut extends TagSelfParse{
    public function getName(){
        return __CLASS__;
    }

    public function start($tag){
        $script =  Constant::PHP_START_TAG . Constant::BLANK;
        $body = $this->splitTagBody($tag);
        if($body[2]){
        	$script .= "echo mb_substr({$body[0]},0,{$body[1]},'utf-8').{$body[2]}";
        }else{
        	$script .= "echo mb_substr({$body[0]},0,{$body[1]},'utf-8')";
        }
        $script .= Constant::BLANK . Constant::PHP_END_TAG;
        return $script;
    }
}

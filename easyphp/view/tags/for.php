<?php
/**
 * This class use to parse the for tag.
 *
 * @author Away shaoweizheng@163.com
 */
class testfor extends TagSelfParse{
    public function getName(){
        return __CLASS__;
    }

    public function start($tag){
        $script =  Constant::PHP_START_TAG . Constant::BLANK;
        $body = preg_split("/[\s]+/", $tag->getBody(), -1, PREG_SPLIT_NO_EMPTY);
        $script .= "for({$body[0]}; {$body[1]}; {$body[2]}){";
        $script .= Constant::BLANK . Constant::PHP_END_TAG;
        return $script;
    }
}

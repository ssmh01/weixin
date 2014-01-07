<?php
/**
 * 玩法适配器
 * 
 * @author blueyb.java@gmail.com
 * @since 1.0 - Jan 15, 2013
 */
abstract class IPlayWayAdapter{
	
	/**
	 * 打平参数名
	 * 
	 * @var string
	 */
	const PARAMETER_NAME_EQUAL = 'equal';
	
	/**
	 * 竞猜对玩法参数进行渲染
	 * 
	 * @param PlayWay $playWay        	
	 * @return string 参数表单html
	 */
	abstract public function parameterRenderer(PlayWay $playWay, GuessPoint $guessPoint);
	
	/**
	 * 获取玩法参数
	 * 
	 * @param PlayWay $playWay        	
	 * @param GuessPoint $guessPoint        	
	 * @return PlayWayParameter
	 */
	abstract public function getParameter(PlayWay $playWay, GuessPoint $guessPoint);
	
	/**
	 * 竞猜结果判定
	 * 
	 * @param PlayData $playData        	
	 * @return PlayWayParameter 返回正确的参数对象
	 */
	abstract public function resultRudge(PlayData $playData);
	
	/**
	 * 分割字符串并删除空元素
	 * @param string $string
	 * @return array:
	 */
	protected function stringSplit($string){
		$string = preg_split('/[\s,;|]+/', $string);
		return array_filter($string);
	}
	
	/**
	 * 值是否是为范围
	 * @param string/int $value
	 * @return boolean
	 */
	protected function isRangeValue($value){
		return strpos($value, PlayWayParameterOption::RANGE_SEPARATOR) !== false;
	}
	
	/**
	 * 是否在范围值内
	 * @param string $value
	 */
	protected function inRangeValue($value, $rangeValue){
		$tempValues = explode(PlayWayParameterOption::RANGE_SEPARATOR, $rangeValue);
		$rangeValues = array('minValue'=>$tempValues[0], 'maxValue'=>$tempValues[1]);
		if(is_numeric($rangeValues['minValue']) && is_numeric($rangeValues['maxValue'])){
			return $rangeValues['minValue'] <= $value && $value <= $rangeValues['maxValue'];
		}elseif(is_numeric($rangeValues['minValue'])){
			return $rangeValues['minValue'] <= $value;
		}elseif(is_numeric($rangeValues['maxValue'])){
			return $value <= $rangeValues['maxValue'];
		}else{
			return false;
		}
	}
}
?>
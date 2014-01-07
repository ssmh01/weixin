<?php
/**
 * 猜胜负玩法适配器
 * 
 * @author blueyb.java@gmail.com
 */
class WinOrLostPlayWayAdapter extends IPlayWayAdapter{
	/*
	 * @see IPlayWayAdapter::getParameter()
	 */
	public function getParameter(PlayWay $playWay, GuessPoint $guessPoint){
		$parameter = $playWay->getParameter();
		$guessPointParameters = $guessPoint->getParams();
		
		if(empty($guessPointParameters)) return $parameter;
		$guessPointParameter = current($guessPointParameters);
		//第一参数
		$option = new PlayWayParameterOption();
		$option->setLabel($guessPointParameter->getLabel() . '胜');
		$option->setValue($guessPointParameter->getName());
		$parameter->addOption($option);
		//打平参数
		$option = new PlayWayParameterOption();
		$option->setLabel('打平');
		$option->setValue(self::PARAMETER_NAME_EQUAL);
		$parameter->addOption($option);
		//第二参数
		$guessPointParameter = next($guessPointParameters);
		$option = new PlayWayParameterOption();
		$option->setLabel($guessPointParameter->getLabel() . '胜');
		$option->setValue($guessPointParameter->getName());
		$parameter->addOption($option);
		
		return $parameter;
	}
	
	/*
	 * @see IPlayWayAdapter::parameterRenderer()
	 */
	public function parameterRenderer(PlayWay $playWay, GuessPoint $guessPoint){
		// TODO Auto-generated method stub
	}
	
	/*
	 * @see IPlayWayAdapter::resultRudge()
	 */
	public function resultRudge(PlayData $playData){
		$play = $playData->getPlay();
		$guess = $play->getGuess();
		$playWayDatas = $guess->getPlayDatas();
		$playWayData = $playWayDatas[$playData->getPlayWayId()];
		$guessPoint = $guess->getGuessPoint();
		$guessPointParameters = $guessPoint->getParams();
		$firstParameter = current($guessPointParameters);
		$secondParameter = next($guessPointParameters);
		if($firstParameter->isEmptyValue() || $secondParameter->isEmptyValue()){
			return false;
		}
		$chooseValue = $playData->getChoose();
		if($chooseValue == ''){
			return false;
		}
		$chooseOods = $playWayData->getOptionOdds($chooseValue);
		if($chooseOods == 0){
			//没有赔率,当打平
			$winWealth = 0;
		}else{
			if($firstParameter->getValue() > $secondParameter->getValue()){
				$correctChoose = $firstParameter->getName();
			}elseif($firstParameter->getValue() == $secondParameter->getValue()){
				$correctChoose = IPlayWayAdapter::PARAMETER_NAME_EQUAL;
			}else{
				$correctChoose = $secondParameter->getName();
			}
			$isCorrect = ($correctChoose == $chooseValue);
			if($isCorrect){
				$winWealth = $chooseOods * $playData->getWealth();
			}else{
				//输
				$winWealth = 0 - $playData->getWealth();
			}
		}
		$playData->setWinWealth($winWealth);
		return true;
	}
}

?>
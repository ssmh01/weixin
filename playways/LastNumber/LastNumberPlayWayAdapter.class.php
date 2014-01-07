<?php
/**
 * 末位号码玩法适配器
 * 
 * @author blueyb.java@gmail.com
 */
class LastNumberPlayWayAdapter extends IPlayWayAdapter{
	/*
	 * @see IPlayWayAdapter::getParameters()
	 */
	public function getParameter(PlayWay $playWay, GuessPoint $guessPoint){
		return $playWay->getParameter();
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
		$guess = $playData->getPlay()->getGuess();
		$playWayDatas = $guess->getPlayDatas();
		$playWayData = $playWayDatas[$playData->getPlayWayId()];
		$guessPointParameters = $guess->getGuessPoint()->getParams();
		$parameter = current($guessPointParameters);
		$chooseValue = $playData->getChoose();
		if($parameter->isEmptyValue() || $chooseValue == ''){
			return false;
		}
		$chooseOods = $playWayData->getOptionOdds($chooseValue);
		if($chooseOods == 0){
			//没有赔率,当打平
			$winWealth = 0;
		}else{
			$numbers = $this->stringSplit($parameter->getValue());
			$lastNumber = end($numbers);
			$isCorrect = ($lastNumber == $chooseValue);
			if($isCorrect){
				$winWealth = $chooseOods * $playData->getWealth();
			}else{
				//输
				$winWealth = 0 - $playData->getWealth();
			}
			unset($numbers);
		}
		$playData->setWinWealth($winWealth);
		return true;
	}
}

?>
<?php
/**
 * 猜总进球数玩法适配器
 * 
 * @author blueyb.java@gmail.com
 */
class TotalGoalPlayWayAdapter extends IPlayWayAdapter{
	/*
	 * @see IPlayWayAdapter::getParameter()
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
		$totalGoal = $firstParameter->getValue() + $secondParameter->getValue();
		$chooseValue = $playData->getChoose();
		if($chooseValue == ''){
			return false;
		}
		$chooseOods = $playWayData->getOptionOdds($chooseValue);
		if($chooseOods == 0){
			//没有赔率,当打平
			$winWealth = 0;
		}else{
			if($this->isRangeValue($chooseValue)){
				//值为范围
				$isCorrect = $this->inRangeValue($totalGoal, $chooseValue);
			}else{
				$isCorrect = ($chooseValue == $totalGoal);
			}
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
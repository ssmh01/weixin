<?php
/**
 * 猜比分玩法适配器
 * 
 * @author blueyb.java@gmail.com
 */
class ScorePlayWayAdapter extends IPlayWayAdapter{
	/*
	 * @see IPlayWayAdapter::getParameter()
	 */
	public function getParameter(PlayWay $playWay, GuessPoint $guessPoint){
		$parameter = $playWay->getParameter();
		$guessPointParameters = $guessPoint->getParams();
		$aGuessPointParameter = current($guessPointParameters);
		next($guessPointParameters);
		$bGuessPointParameter = current($guessPointParameters);
		$scoreNumbers = array(0,1,2);
		$scores = array();
		$count = count($scoreNumbers);
		for($i = 0; $i < $count; $i++){
			$a = $scoreNumbers[$i];
			for($j = 0; $j < $count; $j++){
				$b = $scoreNumbers[$j];
				$scores["{$a}_{$b}"] = array('a'=>$a, 'b'=>$b);
			}
		}
		
		foreach($scores as $score){
			$option = new PlayWayParameterOption();
			$option->setLabel($aGuessPointParameter->getLabel() . ' VS ' . $bGuessPointParameter->getLabel() . "[{$score['a']}-{$score['b']}]");
			$option->setValue("{$aGuessPointParameter->getName()}_{$score['a']}-{$bGuessPointParameter->getName()}_{$score['b']}");
			$parameter->addOption($option);
		}
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
			$correctChoose = "{$firstParameter->getName()}_{$firstParameter->getValue()}-{$secondParameter->getName()}_{$secondParameter->getValue()}"; 
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
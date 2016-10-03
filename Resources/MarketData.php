<?php 
require_once 'Comparable.php';
//Model
class MarketData extends Comparable{
	private $symbol;
	private $high;
	private $low;
	private $date;
	
	function __construct($symbol, $date, $high, $low){
		$this->symbol = $symbol;
		$this->date = $date;
		$this->high = $high;
		$this->low = $low;
	}

	function getSymbol(){
		return $this->symbol;
	}

	function getDate(){
		return $this->date;
	}

	function getHigh(){
		return $this->high;
	}

	function getLow(){
		return $this->low;
	}

	function compareTo($other, $isHigh){
		if ($isHigh) {
			if ($this->high == $other->getHigh()) {
				return 0;
			} elseif ($this->high > $other->getHigh()) {
				return 1;
			} elseif ($this->high < $other->getHigh()) {
				return -1;
			}
		} else {
			if ($this->low == $other->getLow()) {
				return 0;
			} elseif ($this->low > $other->getLow()) {
				return 1;
			} elseif ($this->low < $other->getLow()) {
				return -1;
			}
		}
	}
	
}

 ?>
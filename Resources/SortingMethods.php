<?php 
	class SortingMethods{

		//Insertion sort
		public function insertion($array){
			$n = count($array);
			$swapIndex = 1;
			$auxElement = new Comparable();

			for ($index=1; $index < $n; $index++) { 
				$auxElement = $array[$index];
				$swapIndex = $index - 1;
				//$auxElement < $array[$swapIndex]
				while (
					($swapIndex >= 0) && 
					($auxElement->compareTo($array[$swapIndex], false) < 0) ){

					$array[$swapIndex + 1] = $array[$swapIndex];
					$swapIndex = $swapIndex - 1;
	 			}

	 			$array[$swapIndex + 1] = $auxElement;
			}
			unset($auxElement);
			return $array;
		} //end insertion

		//Reverse insertion sort
		public function r_insertion($array){
			$n = count($array);
			$swapIndex = 1;
			$auxElement = new Comparable();

			for ($index=1; $index < $n; $index++) { 
				$auxElement = $array[$index];
				$swapIndex = $index - 1;

				while (($swapIndex >= 0) && 
					($auxElement->compareTo($array[$swapIndex], true) > 0) ){
					$array[$swapIndex + 1] = $array[$swapIndex];
					$swapIndex = $swapIndex - 1;
	 			}

	 			$array[$swapIndex + 1] = $auxElement;
			}
			unset($auxElement);
			return $array;
		} //end r_insertion





		//Bubble sort (Mayor)
		public function bubble($array){
			$n = count($array);
			$auxElement = new Comparable();

			for ($index=1; $index < $n; $index++) { 
				for ($swapIndex=0; $swapIndex < $n - $index; $swapIndex++) { 
					//	$array[$swapIndex] > $array[$swapIndex + 1]
					if ($array[$swapIndex]->compareTo($array[$swapIndex + 1], false) > 0) {
						$auxElement = $array[$swapIndex];
						$array[$swapIndex] = $array[$swapIndex + 1];
						$array[$swapIndex + 1] = $auxElement;
					}
				}
			}
			unset($auxElement);
			return $array;
		} //end bubble

		//Reverse bubble sort (Mayor)
		public function r_bubble($array){
			$n = count($array);
			$auxElement = new Comparable();

			for ($index=1; $index < $n; $index++) { 
				for ($swapIndex=0; $swapIndex < $n - $index; $swapIndex++) { 
					//	$array[$swapIndex] < $array[$swapIndex + 1]
					if ($array[$swapIndex]->compareTo($array[$swapIndex + 1], true) < 0) {
						$auxElement = $array[$swapIndex];
						$array[$swapIndex] = $array[$swapIndex + 1];
						$array[$swapIndex + 1] = $auxElement;
					}
				}
			}
			unset($auxElement);
			return $array;
		} //end r_bubble





		//Shell sort
		public function shell($array){
			$n = count($array);
			$interval = $n;
			$canChange = true;
			$index = 0;
			$auxElement = new Comparable();

			while ($interval > 0) {
				$interval = floor($interval / 2);
				$canChange = true;

				while ($canChange) {
					$canChange = false;
					$index = 0;

					while (($index + $interval) < $n) {
						//	$array[$index] > $array[$index + $interval]
						if ($array[$index]->compareTo($array[$index + $interval], false) > 0) {
							$auxElement = $array[$index];
							$array[$index] = $array[$index + $interval];
							$array[$index + $interval] = $auxElement;
							$canChange = true;
						}
						$index = $index + 1;
					}
				}
			}
			unset($auxElement);
			return $array;
		} //end shell

		//Reverse shell sort
		public function r_shell($array){
			$n = count($array);
			$interval = $n;
			$canChange = true;
			$index = 0;
			$auxElement = new Comparable();

			while ($interval > 0) {
				$interval = floor($interval / 2);
				$canChange = true;

				while ($canChange) {
					$canChange = false;
					$index = 0;

					while (($index + $interval) < $n) {
						//	$array[$index] < $array[$index + $interval]
						if ($array[$index]->compareTo($array[$index + $interval], true) < 0) {
							$auxElement = $array[$index];
							$array[$index] = $array[$index + $interval];
							$array[$index + $interval] = $auxElement;
							$canChange = true;
						}
						$index = $index + 1;
					}
				}
			}
			unset($auxElement);
			return $array;
		} //end r_shell





		//Merge sort
		public function merge($array){
			$size = count($array);
			if ($size <= 1) {
				return $array;
			} else{
				$half = floor($size / 2);
				$rightPart = array_slice($array, 0, $half);
				$leftPart = array_slice($array, $half, $size);

				$leftPart = $this->merge($leftPart);
				$rightPart = $this->merge($rightPart);
				$array = $this->unite($leftPart, $rightPart);
				return $array;
			}
			return $array;
		}//end merge

		//unite is used by merge()
		private function unite($left, $right){
			$leftIndex = 0;
			$rightIndex = 0;
			$result = array();

			while ( ($leftIndex < count($left)) && ($rightIndex < count($right)) ) {
				//	 $left[$leftIndex] < $right[$rightIndex]
				if ( $left[$leftIndex]->compareTo($right[$rightIndex], false) < 0) {
					array_push($result, $left[$leftIndex]);
					$leftIndex = $leftIndex + 1;
				} else{
					array_push($result, $right[$rightIndex]);
					$rightIndex = $rightIndex + 1;
				}
			}

			$residual = array();
			$residualIndex = 0;
			if ($leftIndex >= count($left)) {
				$residual = $right;
				$residualIndex = $rightIndex;
			} else{
				$residual = $left;
				$residualIndex = $leftIndex;
			}

			for ($i=$residualIndex; $i < count($residual); $i++) { 
				array_push($result, $residual[$i]);
			}

			unset($left);
			unset($right);
			unset($residual);
			return $result;
		} //end unite



		public function r_merge($array){
			$size = count($array);
			if ($size <= 1) {
				return $array;
			} else{
				$half = floor($size / 2);
				$rightPart = array_slice($array, 0, $half);
				$leftPart = array_slice($array, $half, $size);

				$leftPart = $this->r_merge($leftPart);
				$rightPart = $this->r_merge($rightPart);
				$array = $this->r_unite($leftPart, $rightPart);
				return $array;
			}
			return $array;

			/*
			$array = $this->merge($array);
			$array = array_reverse($array);
			return $array;
			*/
		}

		private function r_unite($left, $right){
			$leftIndex = 0;
			$rightIndex = 0;
			$result = array();

			while ( ($leftIndex < count($left)) && ($rightIndex < count($right)) ) {
				//	 $left[$leftIndex] < $right[$rightIndex]
				if ( $left[$leftIndex]->compareTo($right[$rightIndex], true) > 0) {
					array_push($result, $left[$leftIndex]);
					$leftIndex = $leftIndex + 1;
				} else{
					array_push($result, $right[$rightIndex]);
					$rightIndex = $rightIndex + 1;
				}
			}

			$residual = array();
			$residualIndex = 0;
			if ($leftIndex >= count($left)) {
				$residual = $right;
				$residualIndex = $rightIndex;
			} else{
				$residual = $left;
				$residualIndex = $leftIndex;
			}

			for ($i=$residualIndex; $i < count($residual); $i++) { 
				array_push($result, $residual[$i]);
			}

			unset($left);
			unset($right);
			unset($residual);
			return $result;
		} //end unite




/*
		//Quick sort
		public function quick($array){
			$top = 0;
			$lowStack = array();
			$highStack = array();
			array_push($lowStack, 0);
			array_push($highStack, (count($array) - 1) );

			while ($top >= 0) {
				$beginning = array_pop($lowStack);	// beginning = lowStack.remove(top);
				$ending = array_pop($highStack);
				$top = $top - 1;
				$position = $this->reduce($array, $beginning, $ending);

				if (($position - 1) > $beginning) {
					$top = $top + 1;
					array_push($lowStack, $beginning);
					array_push($highStack, ($position - 1) );
				}
				if (($position + 1) < $ending) {
					$top = $top + 1;
					array_push($lowStack, ($position + 1) );
					array_push($highStack, $ending);
				}
			}

			return $array;
		} //End quick
		//reduce, que sirve para quick
		private function reduce($array, $beginning, $ending){
			$left = $beginning;
			$right = $ending;
			$position = $beginning;
			$canPosition = true;

			while ($canPosition) {
				while ( ( $array[$position] <= $array[$right] ) && ( $position != $right)) {
					$right = $right - 1;
				}

				if ($position == $right) {
					$canPosition = false;
				} else{
					$this->swap($array, $position, $right);
					$position = $right;
				}

				while ( ($array[$position] >= $array[$left]) && ($position != $left) ) {
					$left = $left + 1;
				}

				if ($position == $left) {
					$canPosition = false;
				} else{
					$array = $this->swap($array, $position, $left);
					$position = $left;
				}
			}
			return $position;
		}
		//swap para reduce(que tambien sirve para quick)
		private function swap($array, $index, $next){
			$aux = $array[$index];
			$array[$index] = $array[$next];
			$array[$next] = $aux;
		}
*/




		//Quick sort
		public function quicksort( $array ) {
		    if( count( $array ) < 2 ) {
		        return $array;
		    }
		    $left = $right = array( );
		    reset( $array );
		    $pivot_key  = key( $array );
		    $pivot  = array_shift( $array );
		    foreach( $array as $k => $v ) {
		        if( $v->compareTo($pivot, false) < 0 )
		            $left[$k] = $v;
		        else
		            $right[$k] = $v;
		    }
		    return array_merge($this->quicksort($left), 
		    	array($pivot_key => $pivot), 
		    	$this->quicksort($right) );
		}


		public function r_quicksort( $array ) {
		    if( count( $array ) < 2 ) {
		        return $array;
		    }
		    $left = $right = array( );
		    reset( $array );
		    $pivot_key  = key( $array );
		    $pivot  = array_shift( $array );
		    foreach( $array as $k => $v ) {
		        if( $v->compareTo($pivot, true) < 0 )
		            $left[$k] = $v;
		        else
		            $right[$k] = $v;
		    }
		    return array_merge($this->quicksort($left), 
		    	array($pivot_key => $pivot), 
		    	$this->quicksort($right) );
		}


	}

 ?>
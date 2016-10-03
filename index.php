<?php 
require_once 'Resources/php-stock-market-api-master/class.stockMarketAPI.php';
require_once 'Resources/MarketData.php';
require_once 'Resources/SortingMethods.php';
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Bolsa de Valores</title>
	<link rel="stylesheet" href="Resources/styles.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="Resources/script.js"></script>
</head>
<body>
<?php

if( isset($_POST["symbol"]) &&
	isset($_POST["sort_methods"]) &&
	isset($_POST["initial_date"]) &&
	isset($_POST["final_date"]) &&
	isset($_POST["index"]) ) :

	$dateArray = explode("-", $_POST["initial_date"]);
	$start = $dateArray[1] ."-". $dateArray[2] ."-". $dateArray[0];
	$dateArray = explode("-", $_POST["final_date"]);
	$end = $dateArray[1] ."-". $dateArray[2] ."-". $dateArray[0];

	$sortMethod = $_POST["sort_methods"];
	
	$symbol = $_POST["symbol"];

	$isReverseSort = false;
	if ($_POST["index"] == "max") {
		$isReverseSort = true;
	} elseif ($_POST["index"]) {
		$isReverseSort = false;
	}

	$sortBy = new SortingMethods;

	if (isset($_POST["refresh"])) {
		
		$stockMarketData = array();
		$StockMarketAPI = new StockMarketAPI;
		$StockMarketAPI->symbol = $symbol;
		$StockMarketAPI->history = array(
		  'start' 	 => $start,
		  'end' 	 => $end,
		  'interval' => 'd' // Daily
		);
		$data = $StockMarketAPI->getData();
		$data = $data[$symbol];

		for ($i=1; $i < count($data); $i++) {
			$element = $data[$i]; 
			$date = $element['date'];
			$high = $element['high'];
			$low = $element['low'];
			array_push(
				$stockMarketData, 
				new MarketData($symbol, $date, $high, $low) 
			);
		}
	} elseif (isset($_POST["sort"])) {

		$stockMarketData = array();
		$StockMarketAPI = new StockMarketAPI;
		$StockMarketAPI->symbol = $symbol;
		$StockMarketAPI->history = array(
		  'start' 	 => $start,
		  'end' 	 => $end,
		  'interval' => 'd' // Daily
		);
		$data = $StockMarketAPI->getData();
		$data = $data[$symbol];

		for ($i=1; $i < count($data); $i++) {
			$element = $data[$i]; 
			$date = $element['date'];
			$high = $element['high'];
			$low = $element['low'];
			array_push(
				$stockMarketData, 
				new MarketData($symbol, $date, $high, $low) 
			);
		}

		if ($isReverseSort) {
			switch ($sortMethod) {
				case 'insertion':
					$stockMarketData = $sortBy->r_insertion($stockMarketData);
					break;
				case 'bubble':
					$stockMarketData = $sortBy->r_bubble($stockMarketData);
					break;
				case 'shell':
					$stockMarketData = $sortBy->r_shell($stockMarketData);
					break;
				case 'merge':
					$stockMarketData = $sortBy->r_merge($stockMarketData);
					break;
				case 'quick':
					$stockMarketData = $sortBy->r_insertion($stockMarketData);
					break;
				case 'direct_merge':
					$stockMarketData = $sortBy->r_bubble($stockMarketData);
					break;
				case 'natural_merge':
					$stockMarketData = $sortBy->r_shell($stockMarketData);
					break;
				default:
					break;
			}
		} else{
			switch ($sortMethod) {
				case 'insertion':
					$stockMarketData = $sortBy->insertion($stockMarketData);
					break;
				case 'bubble':
					$stockMarketData = $sortBy->bubble($stockMarketData);
					break;
				case 'shell':
					$stockMarketData = $sortBy->shell($stockMarketData);
					break;
				case 'merge':
					$stockMarketData = $sortBy->merge($stockMarketData);
					break;
				case 'quick':
					$stockMarketData = $sortBy->insertion($stockMarketData);
					break;
				case 'direct_merge':
					$stockMarketData = $sortBy->bubble($stockMarketData);
					break;
				case 'natural_merge':
					$stockMarketData = $sortBy->shell($stockMarketData);
					break;
				default:
					break;
			}

		}

	}

endif;

 ?>
	<div class="container">

	<div class="header"><h1>Bolsa de Valores</h1></div>

	<div class="option_box">
		<form action="" method="post" id="form">
			<div>
				Símbolo: 
				<input id="symbol" type="text" name="symbol" placeholder="AAPL">
			</div>
			<div id="sorting">
				Ordenamiento:
				<select name="sort_methods">
					<option value="insertion">Inserción</option>
					<option value="bubble">Burbuja</option>
					<option value="shell">Shell</option>
					<option value="merge">Merge</option>
					<option value="quick">Quick</option>
					<option value="direct_merge">Mezcla Directa</option>
					<option value="natural_merge">Mezcla Natural</option>
				</select>
			</div>
			<div id="date">
				Fecha inicial:
				<input id="#i_date" type="date" name="initial_date" max="<?php echo date('Y-m-d'); ?>"><br> 
				Fecha final:
				<input id="input" type="date" name="final_date" max="<?php echo date('Y-m-d'); ?>">
			</div>
			<div id="index">
				Indice:
				<br><input type="radio" name="index" value="max"> Máximo
				<br><input type="radio" name="index" value="min" checked > Mínimo
			</div>
			<div id="buttons">
				<input type="submit" name="refresh" value="Actualizar">
				<input type="submit" name="sort" value="Ordenar">
			</div>

		</form>
	</div>
	<div class="data">
		<?php if (isset($stockMarketData)): ?>
		<table>
			<tr>
				<th>Symbol</th>
				<th>Low</th>
				<th>High</th>
				<th>Date</th>
			</tr>
			<?php 
			foreach ($stockMarketData as $marketData): ?>
				<tr>
					<td><?php echo $marketData->getSymbol(); ?></td>
					<td><?php echo $marketData->getLow(); ?></td>
					<td><?php echo $marketData->getHigh(); ?></td>
					<td><?php echo $marketData->getDate(); ?></td>
				</tr>
			<?php endforeach ?>
			
		</table>
		<?php endif ?>
	</div>

	</div>



</body>
</html>
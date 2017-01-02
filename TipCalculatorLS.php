<!DOCTYPE html>
<html>
<head>
<title>Tip Calculator</title>
<style>
	body{
		/*background code via http://lea.verou.me/css3patterns/*/
		background:
		linear-gradient(135deg, white 22px, lavender 22px, lavender 24px, transparent 24px, transparent 67px, lavender 67px, lavender 69px, transparent 69px),
		linear-gradient(225deg, white 22px, lavender 22px, lavender 24px, transparent 24px, transparent 67px, lavender 67px, lavender 69px, transparent 69px)0 64px;
		background-color:white;
		background-size: 64px 128px
	}
	div.outer{
		background-color: papayawhip;
		position: relative;
		max-width: 270px;
		border: 3px solid indigo;
		padding: 15px;
		margin: 15px;
		color: indigo;
	}
	div.inner{
		background-color: peachpuff;
		max-width: 230px;
		border: 2px solid indigo;
		padding: 15px;
		margin: 5px;
		color: indigo;
	}
	h2{
		text-align: center;
		font: 30px/1 Georgia, serif;
		font-weight: bold;
	}
</style>
</head>
<body>
<?php
	$bill=$percent=$cpercent=0.0;
	$split=0;
	$print=$printSplit=false;
	$error_bill=$error_per=$error_split='';
	if($_SERVER["REQUEST_METHOD"]=="POST"){
		$bill=$_POST["bill"];
		if(is_numeric($_POST["bill"]) && $_POST["bill"]>0){
			$bill=(intval(100*$_POST["bill"]))/100.0;
			$print=true;
		}
		else{
			$error_bill='color: salmon';
		}
		$cpercent=$_POST["custompercent"];
		if($_POST["percent"]=="custom" && (!is_numeric($_POST["custompercent"]) || $_POST["custompercent"]<=0)){
			$error_per='color: salmon';
			$print=false;
		}
		switch($_POST["percent"]){
			case "10%":
				$percent=0.10;
				break;
			case "15%":
				$percent=0.15;
				break;
			case "20%":
				$percent=0.20;
				break;
			case "custom":
				if($print){
					$percent=$cpercent/100.0;
				}
				break;
			default:
				$percent=0.0;
				$print=false;
		}
		$split=$_POST["split"];
		if(!is_numeric($_POST["split"]) || $_POST["split"]<=0 || !is_int(intval($split))){
			$error_split='color: salmon';
			$print=false;
		}
		elseif($split>1){
			$printSplit=true;
		}
	}
	if(empty($_POST['submitbutton'])){
		$bill=123.45;
		$cpercent=18.5;
		$split=12;
	}
?>
<div class="outer"><!--text box that encloses this calculator-->
<h2>Tip Calculator</h2>
<form method='post' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<p><!--form fields and labels-->
	<span style="<?php echo $error_bill;?>">Bill subtotal:
	$<input type="text" name="bill" style="width: 70px" maxlength="8" placeholder="123.45" value="<?php echo $bill?>">
	</span><br><br>

	<span style="<?php echo $error_per;?>">Tip percentage:<br>
	<input type="radio" name="percent" value="10%" <?php if(isset($_POST["percent"]) && $_POST["percent"]=="10%") echo 'checked="checked"';?>>10%<br>
	<input type="radio" name="percent" value="15%" <?php if(isset($_POST["percent"]) && $_POST["percent"]=="15%") echo 'checked="checked"';?>>15%<br>
	<input type="radio" name="percent" value="20%" <?php if(isset($_POST["percent"]) && $_POST["percent"]=="20%") echo 'checked="checked"';?>>20%<br>
	<input type="radio" name="percent" value="custom" <?php if(!isset($_POST["percent"]) || $_POST["percent"]=="custom") echo 'checked="checked"';?>>Custom:
	<input type="text" name="custompercent" style="width: 45px" maxlength="6" placeholder="18.5" value="<?php echo $cpercent;?>">%
	</span><br><br>

	<span style="<?php echo $error_split;?>">Split between:
	<input type="text" name="split"  style="width: 30px" maxlength="2" placeholder="12" value="<?php echo $split;?>">
	person(s)
	</span><br><br>

	<input type="submit" name="submitbutton" style="margin-left: 38%;" value="Calculate">
</p>
</form>
<!--following field prints results, if input is correct-->
<?php
	if($print){
		echo "<br><div class='inner'>";
			printf("Tip: $%.2f<br><br>Total: $%.2f", $bill*$percent, $bill*(1+$percent));
			if($printSplit){
				printf("<br><br>Tip each: $%.2f<br><br>Total each: $%.2f", $bill*$percent/$split, $bill*(1+$percent)/$split);
			}
		echo "</div>";
	}
?>
</div>
</body>
</html>

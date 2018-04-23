<?php

error_reporting(1);
require "db/connect.php";
require "functions/security.php";

$records=array();
$records1=array();

if(!empty($_POST)){
	
   if($results1=$db->query("SELECT RegistrationNumber FROM attendance")){
	if($results1->num_rows){
		while($row=$results1->fetch_object()){
			$records1[]=$row;
		}
		$results1->free();
	}
	
	
} 
}

$i1=0;
	foreach($records1 as $r){
		$i1++;
		$value=$_POST["group".$i1];
		echo $value.$i1.'<br>';
		
		$txt=sprintf("insert into %s (PresentAbsent,Date) values ('{$value}',NOW())",escape('_'.$r->RegistrationNumber));
		$db->query($txt);
		
		
			
		if($db->affected_rows){
			echo "Success!!!";
		} else{
			echo "Failiure???";
		}

	}
			
			



if($results=$db->query("SELECT RegistrationNumber FROM attendance")){
	if($results->num_rows){
		while($row=$results->fetch_object()){
			$records[]=$row;
		}
		$results->free();
	}
} $i=0;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Attendance</title>
</head>
<body>
	<h3>Attendance</h3>
	<?php
		if(!count($records)){
			echo "No records";
		}else{

		?>
	<table>
		<thead>
			<tr>
				<th>Index number</th>
				<th>Present</th>
				<th>Absent</th>
				
			</tr>
		</thead>
		<tbody>
		<form action="" method="post">
		<?php
			foreach($records as $r){
				$i++;
		?>
			<tr>
				<td><?php echo escape($r->RegistrationNumber);?></td>
				
				
				<td><input type="radio" name="<?php echo "group".$i;?>" id="<?php echo escape($r->RegistrationNumber)."pres".$i;?>" value="1" checked="checked"></td>
				<td><input type="radio" name="<?php echo "group".$i;?>" id="<?php echo escape($r->RegistrationNumber)."abs".$i;?>"value="0" ></td>
			</tr>
		<?php
		}
		?>
		
		
		</tbody>
	</table>
	<input type="submit" value="Submit">
		</form>
	
	<?php
		}
	?>
	<hr>

	
</body>
</html>
<?php require APPROOT.'/views/inc/header.php';?>

<?php 
/*
	Madiha

	below is a simple layout for printing, this is for u to take refference on how to print

	use $data['showAll'] to print necessary informations
		//these are the associative information in $data array
		
		foreach($data['showAll'] as $value){
			$value['cid'];
		}
		example $data['cid'] should give u course code
		'cid'=> $value->Course_Code,
		'sec'=>	$value->Section,
		'f_ini'=>$value->Faculty_Initials,
		'total_Seats'=>$value->Total_Seats,
		'seats_booked'=>$value->Seats_Booked,
		'seats_remaining'=>$value->Seats_Remaining,
		'day'=>$value->Day,
		'stime'=>$value->Start_Time,
		'etime'=>$value->End_Time


*/
$scheduleTitle =[
	'Course_Code',
	'Section',
	'Faculty Initials',
	'Total Seats',
	'Seats Booked',
	'Seats Remaining',
	'Day',
	'Start Time',
	'End_Time'
];
	//$data['showAll'];

/*
	'cid'=> $value->Course_Code,
	'sec'=>	$value->Section,
	'f_ini'=>$value->Faculty_Initials,
	'total_Seats'=>$value->Total_Seats,
	'seats_booked'=>$value->Seats_Booked,
	'seats_remaining'=>$value->Seats_Remaining,
	'day'=>$value->Day,
	'stime'=>$value->Start_Time,
	'etime'=>$value->End_Time
*/
?>
<table border="2">
	<thead>
		<tr>
			<?php foreach ($scheduleTitle as  $titles): ?>
				<th><?php echo $titles; ?></th>
			<?php endforeach ;?>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($data['showAll'] as $value): ?>
				
				<tr>
					
						
					<td><a href="<?php echo URLROOT.'/advisings/addCourse/'.$value['cid'].'/'.$value['sec'].'/'.$value['semester'].'/'.$value['year']; ?>"><?php echo $value['cid']; ?></a></td>
					<td><?php echo $value['sec']; ?></td>
					<td><?php echo $value['f_ini']; ?></td>
					<td><?php echo $value['total_Seats']; ?></td>
					<td><?php echo $value['seats_booked']; ?></td>
					<td><?php echo $value['seats_remaining']; ?></td>
					<td><?php echo $value['day']; ?></td>
					<td><?php echo $value['stime']; ?></td>
					<td><?php echo $value['etime']; ?></td>

					
				</tr>
		<?php endforeach ;?>
		
	</tbody>
</table>
<?php require APPROOT.'/views/inc/footer.php';?>
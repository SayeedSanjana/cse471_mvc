<?php require APPROOT.'/views/inc/header.php';?>

	 <?php
	 $thead = [
	 	'Name',
		'Designation',
		'Phone_No',
		'Email_Id',
		'Gender',
		'Room_No'
	];
	// print_r($data)
	//  foreach ($data['allFaculty'] as $value) {
	// 		foreach ($value as $key => $val) {
	// 			echo $val;
	// 		}
	// 		echo "<br>";
	// } ?>

	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<?php foreach ($thead as $value):?>
					<th><?php echo $value; ?></th>
				<?php endforeach; ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data['allFaculty'] as  $val):?>
			<tr>
				<?php foreach ($val as $key=> $value): ?>
					<td><?php echo $val[$key]; ?></td>
				<?php endforeach ?>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

<?php require APPROOT.'/views/inc/footer.php';?>
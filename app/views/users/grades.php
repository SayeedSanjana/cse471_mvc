<?php require APPROOT.'/views/inc/header.php';?>

<?php 
	$thead = [
		
		'Course Description',
		'Course Code',
		'Credits',
		'GPA'
	]; 
	//print_r($data['gradeSheet']);
	// foreach ($data['gradeSheet'] as  $value) {
	// 	//print_r($value);
	// 	foreach ($value as $key => $val) {
	// 		foreach ($val as $va) {
	// 			echo ' '.$va;
	// 		}
	// 		echo "<br>";
	// 	}
	// 	echo "<br>";
	// }

?>
<?php if (count($data['gradeSheet'])>0):?>
	
		 	<table class="table table-bordered">
		 		<?php foreach ($data['gradeSheet'] as $semester):?>
			 		
					<thead>
						<tr class="bg-secondary">
							<th><?php echo ($semester[0]['sem']); ?></th>
							<th ><?php echo ($semester[0]['year']); ?></th>
						</tr>
			 			<tr>
			 				<?php foreach ($thead as $value): ?>
			 					<th><?php echo $value; ?></th>
			 				<?php endforeach; ?>
			 			</tr>
			 		</thead>

			 		<tbody>
						
			 			<?php foreach ($semester as $val):?>
			 				<tr>
			 					<td ><?php echo $val['c_desc']; ?></td>
			 					<td><?php echo $val['cid']; ?></td>
			 					<td><?php echo $val['credits']; ?></td>
			 					<td><?php echo $val['gpa']; ?></td>
			 					
			 				</tr>
			 			<?php endforeach; ?>
			 		</tbody>
		 		<?php endforeach; ?>
		 	</table>
<?php else: ?>
	
	<?php echo $data['data_err']; ?>
	
<?php endif; ?>

<div class="card" style="width: 18rem;">
  <h3>What You Need To Know</h3>
  <div class="card-body">
    <table class="table">
    	<tr>
    		<td>
    			<label for="">Credits Completed</label>
    		</td>
    		<td><?php echo $data['creditsCompleted']; ?></td>
    	</tr>
    	
		<tr>
    		<td>
    			<label for="">Credits Remaining</label>
    		</td>
    		<td><?php echo ($data['totalCredits']-$data['creditsCompleted']); ?></td>
    	</tr>

    	<tr>
    		<td>
    			<label for="">Total Credits</label>
    		</td>
    		<td><?php echo $data['totalCredits']; ?></td>
    	</tr>
		<tr>
    		<td>
    			<label for="">CGPA</label>
    		</td>
    		<td><?php echo $data['cgpa']; ?></td>
    	</tr>
    </table>
  </div>
</div>

<?php require APPROOT.'/views/inc/footer.php'; ?>*/
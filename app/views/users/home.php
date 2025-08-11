<?php require APPROOT.'/views/inc/header.php';?>
	
<?php
	 /*
	 	'cid'	----> course id
		'sec'	-----> section
		'day'	-----> day
		'stime'	-----> start time
		'etime'	-----> end time
	 	
	 	array format data['cid'] OR data['sec'] OR data['day'] OR data['stime']
	 				 OR data['etime']

		// use foreachloop
		// printing format
		foreach ($data as $key => $value){
			$value['cid'];
			$value['sec'];
			$value['day'];
			$value['stime'];
			$value['etime'];
		}

		<?php if($myroutine['day']==$values['did'] 
						&& $myroutine['slot']== $values[$key]['tid']): ?>
							<td><?php echo $myroutine['cid']."--".$myroutine['sec']; ?></td>		
	*/ 

		$days = [
		    'Sunday',
		    'Monday',
		    'Tuesday',
		    'Wednesday',
		    'Thursday',
		    'Friday',
		    'Saturday'
		];
		$timeSlots =[
			'first',
			'second',
			'third',
			'fourth',
			'fifth',
			'sixth',
			'seventh'
		];
		//print_r($data);
		//echo strtoupper($days[0]);
?>


<h3>Dashboard</h3>
<hr>


<p>
  <button class="btn btn-primary" type="submit" data-toggle="collapse" data-target="#academicNotice" aria-expanded="false" aria-controls="collapseExample">
    Academic Notice
  </button>
  <button class="btn btn-secondary" type="submit" data-toggle="collapse" data-target="#universityEvents" aria-expanded="false" aria-controls="collapseExample">
    University Events
  </button>
</p>

	<div class="collapse" id="academicNotice">
	  <div class="card card-body">
	  		
	  		<?php foreach ($data['academicNotice'] as  $value):?>
	  			<h4><?php echo $value['cid'].'-'.$value['sec']."\t\t".$value['post']; ?></h4>
	  		<?php endforeach; ?>
	  </div>
	</div>

	<div class="collapse" id="universityEvents">
	  <div class="card card-body">
	  		
	  		data needs to be imported 
	  </div>
	</div>

	<table class="table table-bordered table-striped table-sm">
		
		<thead class="thead-dark">
			
			<tr>
				<th>Time</th>
				
				<?php foreach ($days as $value):?>
				
					<th><?php echo $value;?></th>
				
				<?php endforeach; ?>
			
			</tr>
		
		</thead>
		
		<tbody>
			
			<?php foreach ($data['timeSlots'] as $time) :?>
				<tr>
					

					<td><?php echo date('h:i a',strtotime($time['stime']))."<br>".date('h:i a',strtotime($time['etime'])) ;?></td>
					

					<?php for ($j=0; $j <count($days) ; $j++):?>
						<!--// here values are in the form [slot][days]-->
						
						<?php $routine =findClassRoutine($time['slot'],$days[$j],$data['routine']);?>
						
						<?php if (strlen($routine)> 0):?>
							

							<td><?php echo $routine ?></td>
						

						<?php else: ?>
							
							<td></td>
						
						<?php endif; ?>
					
					<?php endfor; ?>
				
				</tr>
			
			<?php endforeach ;?>
		
		</tbody>
	
	</table>

<?php 
	function findClassRoutine($slot,$days,$data)
	{
		/*	takes in a day param and slot param
			searches in the data['routine'] and gives a feed back on
			that particular day to build the routine table	
		*/
		
		foreach ($data as $myroutine){	
			if($slot== $myroutine['slot'] && strtoupper($days) == $myroutine['day']){
				//feedback
				return $myroutine['cid']." - ".$myroutine['sec'];
			}
		}
		return false;
	}
?>
		


<?php require APPROOT.'/views/inc/footer.php'; ?>

<?php require APPROOT.'/views/inc/header.php';?>

	<h1><?php echo $data['title']?></h1>
	<p align="justify">
		<?php echo $data['description'] ?> <br>
		This Application is Built to <b>Connect Peers and Faculty</b> under one System,
		Aiming to reduce the communication gap. <i>Fresher to juniors</i> can consult with both 
		<b>faculty and seniors</b> regarding Academics and university related curricullum.
		<b>Seniors can seek direct guideline from faculty</b> through personal communication via the application.
		<b>Furthermore bultin Academic Guidelines</b> are also integrated within the system.
		<i>Students can View faculty profile containing image,bio,field of specialization, course , projects and Thesis Worked.Similarly Faculty has full view Access to Student profile. Students can Also their peer profile to see Academic information such as course taken current semester, course completed, credits completed excluding gradesheet.</i>
				
	</p>
	<ul class="list-group">
		<?php foreach ($data['members'] as $value):?>
			<li class="list-group-item"><?php echo $value ?></li>
		<?php endforeach ?>
	</ul>	

<?php require APPROOT.'/views/inc/footer.php'; ?>


<?php require APPROOT.'/views/inc/header.php' ?>

<!DOCTYPE html>
<html>
<head>
	
</head>
<style >
*{margin: 0px;padding: 0px;}
#main{border: 1px solid black; width: 450px;height: 500px;margin: 24px auto;}
#message_area{width:98%;border: 1px solid blue; height:440px;}
}
	
</style>
<body>
<div id ="main">
	<div id ="message_area"></div>
	<form method="post">
		<input type="text" name="message"  style="width :370px;height:50px;"  placeholder="Type Your message" />
		<input type="submit" name="submit" style= "width:70px; height:50px ;" value="message"/>

		
		
	</form>
	
</div>>
</body>
</html>>
<?php require APPROOT.'/views/inc/footer.php' ?>
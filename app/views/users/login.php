<?php require APPROOT.'/views/inc/header.php' ?>
	<div class="row">
		<div class="col-md-6 mx-auto">
			<div class="card card-body bg-light mt-5">
				<h2>Login</h2>
				<p>Please Enter Necessary Details</p>
				<form action="<?php echo URLROOT;?>/users/login" method="POST">
					
					
					<!-- ------------------------------------------------------------------ -->
					<div class="form-group">
						<label for="name">Username : <sup>*</sup></label>
						<input 
							type="text" 
							name="username" 
							class="form-control form-control-lg 
							<?php echo(!empty($data['username_err']) ? 'is-invalid' : ''); ?>" 
							value="<?php echo($data['username']);?>">
						
						<span class="invalid-feedback">
							<?php echo $data['username_err'];?>
						</span>
					</div>
					<!-- ------------------------------------------------------------------ -->
					<div class="form-group">
						<label for="name">Password : <sup>*</sup></label>
						<input 
							type="password" 
							name="password" 
							class="form-control form-control-lg 
							<?php echo(!empty($data['password_err']) ? 'is-invalid' : ''); ?>" 
							value="<?php echo($data['password']);?>">
						
						<span class="invalid-feedback">
							<?php echo $data['password_err'];?>
						</span>
					</div>
					<!-- ------------------------------------------------------------------- -->
					
					<!-- ------------------------------------------------------------------- -->

					<div class="row">
						<div class="col">
							<input type="submit" name="login" value="Login" class="btn btn-success btn-block">
						</div>
						<div class="col">
							<a href="<?php echo URLROOT;?>/users/signUp" class="btn btn-light btn-block">
								Dont Have An Account? Create One
							</a>
						</div>
					</div>
					<!-- ---------------------------------------------------------------------- -->

				</form>
			</div>
		</div>	
	</div>
<?php require APPROOT.'/views/inc/footer.php' ?>
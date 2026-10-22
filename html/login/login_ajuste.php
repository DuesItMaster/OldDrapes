<?php
include "verifica.php";
session_start();
if(!empty($_SESSION['login_user']))
{
header('Location: ../cotizar/index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login | Dues Drapes</title>
		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->
		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/bootstrap2.css" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/login.css" />	
		<script src="js/jquery.min.js"></script>
        <script src="js/jquery.ui.shake.js"></script>
		<script>
			$(document).ready(function() {
				$('#login').click(function()
				{
				var username=$("#username").val();
				var password=$("#password").val();
				var dataString = 'username='+username+'&password='+password;
				if($.trim(username).length>0 && $.trim(password).length>0){
					$.ajax({
						type: "POST",
						url: "verifica.php",
						data: dataString,
						cache: false,
						beforeSend: function(){ $("#login").val('Connecting...');},
						success: function(data){
							if(data){
								$(window).attr("location","../cotizar/index.php");
							}else{
								$('#box').shake();
								$("#login").val('Login')
								$("#error").html("<span style='color:#cc0000'>Error:</span> Usuario o contraseña invalido . ");
							}
						}
					});
				}
				return false;
				});
			});
		</script>
	</head>
	<body class="menubar-hoverable header-fixed fondo-login">
				<div class="cuadlog" id="box">
					<img class="img-responsive logo" src="../../assets/img/logo/logo_drapes_blanco.png"  width="200px" height="70px"/>

					<form class="form floating-label"  accept-charset="utf-8" method="post"> <!-- action="../../html/dashboards/dashboard.html"-->
						<div class="form-group">
							<input type="text" class="form-control" id="username" name="username" placeholder="Usuario">
						</div>
						<div class="form-group">
							<input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
							<p class="help-block"><a href="#">¿Se te olvid&oacute;?</a></p>
						</div>
						<br>
						<div class="login-bottom">
							<div class="col-xs-12">
								<button class="btn btn-primary btn-raised" name="btn-login" type="submit" value="Log In" id="login"	>Iniciar Sesion</button>
							</div>
							<div class="col-xs-12">
								<div class="checkbox checkbox-inline checkbox-styled">
									<label>
										<input type="checkbox"> <span>Recordarme</span>
									</label>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="links-bottom">
									<a href="#">T&eacute;rminos y condiciones</a> | <a href="#">Pol&iacute;ticas de privacidad</a>
								</div>
							</div>
						</div>
					</form>
					<div id="error"></div>
				</div>
			</body>
				<script src="../../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		</html>

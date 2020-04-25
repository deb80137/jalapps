<!DOCTYPE html>
<html>
<head>
	<title>login</title>
	<meta name="viewport" content="width=device-width, initial-state=1"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

	<style type="text/css">
	.bg{background: url('https://jalapps.herokuapp.com/back.jpg') ;
	width:100%;
	height:100%;
	}
	#log{
		border : 2px solid white;
		padding : 25px 25px;
		background-color: #006dcc;
		margin-top : 80px;
		-webkit-box-shadow: -5px 2px 10px 6px rgba(0,0,0,0.75);
-moz-box-shadow: -5px 2px 10px 6px rgba(0,0,0,0.75);
box-shadow: -5px 2px 10px 6px rgba(0,0,0,0.75);
	}
	img{ width: 180px;
		margin:auto;

	}
	h1{
		color:white;
		text-align:center;
		font-weight:bolder;
		margin-top:-20px;
	}


	label{font-size:20px; color:white;}

	</style>
</head>
<body>
	<div class="container-fluid bg">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12"></div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<form id="log" action="logincheck.php" method="post">
								<h1>Login Form</h1>
								<img class="rounded-circle" src="https://jalapps.herokuapp.com/login.jpg">
								<div class="form-group">
									<label>Username</label>
									<input name="myusername" id="myusername" type="text" class="form-control" placeholder="Username">
									
								</div>
								<div class="form-group">
									<label>Password</label><input type="password" name="mypassword" id="mypassword" class="form-control" placeholder="Password">						
								</div>
								<button type="submit" class="btn btn-success btn-block">Login</button>
							</form>

						</div>

			
		</div>
		
	</div>

</body>
</html>

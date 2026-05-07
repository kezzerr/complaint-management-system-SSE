<?php

//webpage which allows the user to login to their account

require_once __DIR__ . '/../src/controllers/login.php';
require __DIR__ . '/../src/views/navbar.php';

$controller = new LoginController();
$errors = $controller->handleLogin();
$erroruser = $errors["erroruser"];
$errorpass = $errors["errorpass"];

?>

<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lato'>
        <link rel="stylesheet" href="../css/site.css">
		<title>Login - Complaint Management System</title>
    </head>
	
	<body>
		<div class="container" style="margin-top: 10px">
        	<div class="row">
            	<div class="col" style="font-family: lato; font-weight: bold">
                	<div class="row">
                    	<h1 style="text-align: center; font-weight: bold; margin-top: 30px">Complaint Management System</h1>
                	</div>
            	</div>
        	</div>
    	</div>

    	<div class="container">
    		<div class="row d-flex justify-content-center">
				<div class="col-12 col-md-6 col-lg-4 mx-auto" style="font-family: lato; font-weight: bold; margin-top: 30px; max-width: 275px">
    				<form method="post" class="text-center">
        				<label for="user"; style="margin-bottom: 5px">Username</label>
        				<input class="form-control form-control-sm mb-2" type="text" id="user" name="user" aria-describedby="userError">
        				<div class="error" id="userError" style="margin-top: 5px"><?php echo $erroruser; ?></div>
						<label for="pass" style="margin-top: 10px; margin-bottom: 5px">Password</label>
        				<input class="form-control form-control-sm mb-2" type="password" id="pass" name="pass" aria-describedby="passError">
        				<div class="error" id="passError" style="margin-top: 5px"><?php echo $errorpass; ?></div>
						<button class="btn btn-dark mt-3" type="submit" name="submit">Submit</button>	
   				 	</form>  
				</div>
			</div>
		</div>
    </body>
</html>
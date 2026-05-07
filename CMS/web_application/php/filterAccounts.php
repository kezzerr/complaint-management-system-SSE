<?php

//webpage which allows the help desk agent to filter accounts based user email address

require __DIR__ . '/../src/views/navbar.php';
require_once __DIR__ . '/../src/services/userServices.php';
require_once __DIR__ . '/../src/middleware/authenticate.php';

Authenticate::requireAgent();

$service = new UserService();
$searchText = $_POST['search'] ?? '';
$orgId = $_SESSION['org_id'];
$accounts = $service->filterUsers($searchText, $orgId);

?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lato'>
        <link rel="stylesheet" href="../css/site.css">
    </head>
    
    <body>       
        <div class="container" style="margin-top: 10px">
            <div class="row">
                <div class="col" style="font-family: lato; font-weight: bold">
                    <div class="row">
                        <h2 style="text-align: center; font-weight: bold; margin-top: 30px">Filter Users</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
    	    <div class="row d-flex justify-content-center">
			    <div class="col-12 col-md-6 col-lg-4 mx-auto" style="font-family: lato; font-weight: bold; margin-top: 30px; max-width: 275px">
    			    <form method="post" class="text-center">
        			    <label for="search" style="padding-bottom: 5px">Filter By Email Address:</label>
        			    <input class="form-control form-control-sm mb-2" type="text" id="search" name="search" value="">
					    <button class="btn btn-dark mt-3" type="submit" name="filter" value="filter">Filter</button>	
   				    </form>  
			    </div>
		    </div>
	    </div>
        <?php if (!empty($searchText) && !empty($accounts)): ?>
        <div class="container content-wrapper">
            <div class="container mt-5 d-flex justify-content-center">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">User ID</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Problems</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($accounts as $acc): ?>
                            <tr>
                                <td><?= htmlspecialchars($acc[0], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($acc[2], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($acc[3], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($acc[4], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><a href="viewProblems.php?user_id=<?= urlencode($acc[0]) ?>" class="btn btn-sm btn-primary">View</a></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php elseif (!empty($searchText) && empty($accounts)): ?>
        <div>
            <p class="text-center mt-3" style="font-family: lato; font-weight: bold; color: #A40000;">There is no account associated with the email address: <?= htmlspecialchars($searchText) ?></p>
        </div>
        <?php endif; ?>
    </body>
</html>
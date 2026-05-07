<?php

//webpage which allows the help desk agent to filter problem based problem id

require __DIR__ . '/../src/views/navbar.php';
require_once __DIR__ . '/../src/middleware/authenticate.php';
require_once __DIR__ . '/../src/services/problemService.php';

Authenticate::requireAgent();

$service = new ProblemService();
$searchId = $_POST['search'] ?? '';
$orgId = $_SESSION['org_id'];
$problem = null;

if (!empty($searchId)) {
    $problem = $service->getProblemByIds($searchId, $orgId);
}

?>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" crossorigin="anonymous">
        <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lato'>
        <link rel="stylesheet" href="../css/site.css">
    </head>

    <body>
        <div class="container" style="margin-top: 10px">
            <div class="row">
                <div class="col" style="font-family: lato; font-weight: bold">
                    <div class="row">
                        <h2 style="text-align: center; font-weight: bold; margin-top: 30px">Filter Problems</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-6 col-lg-4 mx-auto" style="font-family: lato; font-weight: bold; margin-top: 30px; max-width: 275px">
                        <form method="post" class="text-center">
                            <label for="search" style="padding-bottom: 5px">Filter By Problem ID:</label>
                            <input class="form-control form-control-sm mb-2" type="text" id="search" name="search" value="">
                            <button class="btn btn-dark mt-3" type="submit" name="filter" value="filter">Filter</button>	
                        </form>  
                    </div>
                </div>
            </div>
        <?php if ($problem): ?>
        <div class="container content-wrapper">
        <div class="container mt-5 d-flex justify-content-center">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Problem ID</th>
                                <th scope="col">User ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">Description</th>
                                <th scope="col">Status</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">Created</th>
                                <th scope="col">Updated</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?= htmlspecialchars($problem['problem_id'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($problem['user_id'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td style="max-width:250px; white-space:normal; word-wrap:break-word;"><?= htmlspecialchars($problem['title'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td style="max-width:250px; white-space:normal; word-wrap:break-word;"><?= htmlspecialchars($problem['description'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($problem["status"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($problem["assigned_to"], ENT_QUOTES, 'UTF-8') ?: "-" ?></td>
                                <td><?= htmlspecialchars($problem["created_at"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($problem["updated_at"], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><a class="btn btn-sm btn-primary">Assign</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php elseif (!empty($searchId)): ?>
            <div>
                <p class="text-center mt-3" style="font-family: lato; font-weight: bold; color: #A40000;">Problem ID: <?= htmlspecialchars($searchId) ?> returned no results.</p>
            </div>
        <?php endif; ?>
    </body>
</html>
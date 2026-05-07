<?php

//problem service class which delegates to the problem respository

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../models/problemRepo.php';

class ProblemService {

    private $repo;

    public function __construct() {

        $db = new Database();
        $this->repo = new ProblemRepository($db->getConnection());
    }

    public function getProblemByIds($id, $orgId) {

        return $this->repo->getProblemByIds($id, $orgId);
    }
}
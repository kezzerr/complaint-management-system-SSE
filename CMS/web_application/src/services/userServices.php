<?php

//user service class which delegates to the user respository

require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../models/userRepo.php';

class UserService {

    private $repo;

    public function __construct() {
        $this->repo = new UserRepository();
    }

    public function filterUsers($searchInput, $orgId) {
        
        if (empty($searchInput)) {
            return $this->repo->getAllUsers($orgId);
        }

        return $this->repo->getUsersByEmail($searchInput, $orgId);
    }
}
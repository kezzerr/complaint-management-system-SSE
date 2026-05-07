<?php

//problem controller class which handles problem submission/retrieval requests

require_once __DIR__ . '/../models/problemRepo.php';
require_once __DIR__ . '/../database.php';
require_once __DIR__ . '/../services/loggingService.php';

class ViewProblemsController {

    private $problemRepo;

    public function __construct() {

        $db = new Database();
        $conn = $db->getConnection();

        $this->problemRepo = new ProblemRepository($conn);
    }

    public function submitProblem($userId, $orgId, $title, $desc) { //requests that the submitted problem data be entered into the database

        $errors = [];

        if (empty(trim($title))) $errors['title'] = "⚠️ Title cannot be empty";
        if (empty(trim($desc))) $errors['desc'] = "⚠️ Description cannot be empty";
        if (!empty($errors)) return ['success' => false, 'errors' => $errors];

        $problemId = $this->problemRepo->create($userId, $orgId, $title, $desc);

        # SECURITY FIX
        # Weakness ID: W3
        # Fix ID: F3 – Audit Logging
        # STRIDE: Repudiation
        # OWASP: A09 Security Logging and Alerting Failures
        # CWE: CWE-778
        # CIA: Integrity
        # ASVS: V16 – Security Logging and Error Handling
        # D3FEND: D3-AZET - Authorization Event Thresholding

        loggingService::log("PROBLEM_SUBMITTED, USER_ID = " . $_SESSION["user_id"] . ", PROBLEM_ID = " . $problemId);

        return ['success' => true, 'errors' => [], 'problem_id' => $problemId];
    }

    public function getProblems($userId, $orgId) {

        return $this->problemRepo->getProblemsByIds($userId, $orgId);
    }
}
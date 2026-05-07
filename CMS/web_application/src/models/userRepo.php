<?php

//problem repository class which retrieves requested user data from the database

class UserRepository {

    private $db;

    public function __construct() {

        $this->db = new SQLite3("C:\\xampp0\\database\\cms.db");
    }

    public function getAllUsers($orgId) { //retrieves all user data from the database

        $stmt = $this->db->prepare("SELECT * FROM users WHERE org_id = :org_id");
        $stmt->bindParam(':org_id', $orgId, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $users = [];

        while ($row = $result->fetchArray(SQLITE3_NUM)) {
            $users[] = $row;
        }

        return $users;
    }

    public function getUsersByEmail($email, $orgId) { //retrieves user data from the database using user email address
        
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email AND org_id = :org_id");
        $stmt->bindParam(':email', $email, SQLITE3_TEXT);
        $stmt->bindParam(':org_id', $orgId, SQLITE3_INTEGER);
        $result = $stmt->execute();

        $users = [];
        while ($row = $result->fetchArray(SQLITE3_NUM)) {
            $users[] = $row;
        }

        return $users;
    }

    public function verify($username, $password) { //verification process for user login

        $stmt = $this->db->prepare(
            "SELECT * FROM users WHERE username = :user"
        );

        $stmt->bindParam(':user', $username, SQLITE3_TEXT);
        $result = $stmt->execute();
        $user = $result->fetchArray(SQLITE3_ASSOC);

        # SECURITY FIX
        # Weakness ID: W4
        # Fix ID: F3 – Password Hashing
        # STRIDE: Spoofing
        # OWASP: A04 Cryptographic Failures
        # CWE: CWE-256
        # CIA: Confidentiality
        # ASVS: V6.2 – Password Security
        # D3FEND: D3-CH - Credential Hardening

        if ($user && password_verify($password, $user['password'])) {

            return $user;
        }

        return null;
    }   
}
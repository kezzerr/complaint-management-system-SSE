<?php

//problem repository class which submits/retrieves problem data from the database

class ProblemRepository {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }


    public function create($userId, $orgId, $title, $desc) { //inputs problem data to the database

        $stmt = $this->db->prepare("INSERT INTO problems (user_id, org_id, title, description) VALUES (:user_id, :org_id, :title, :desc)");
        $stmt->bindParam(':user_id', $userId, SQLITE3_INTEGER);
        $stmt->bindParam(':org_id', $orgId, SQLITE3_INTEGER);
        $stmt->bindParam(':title', $title, SQLITE3_TEXT);
        $stmt->bindParam(':desc', $desc, SQLITE3_TEXT);

        $stmt->execute();

        return $this->db->lastInsertRowID();
    }

    public function getProblemsByIds($userId, $orgId) { //retrieves problem data from the database using user id and org id

        # SECURITY FIX
        # Weakness ID: W1
        # Fix ID: F1 – Tenant-based access control
        # STRIDE: Information Disclosure/Elevation of Privilege
        # OWASP: A01 Broken Access Control
        # CWE: CWE-284, CWE-639
        # CIA: Confidentiality
        # ASVS: V8 - Authorisation
        # D3FEND: D3-AMED - Access Mediation

        $stmt = $this->db->prepare("SELECT * FROM problems WHERE user_id = :user_id AND org_id = :org_id");
        $stmt->bindParam(':user_id', $userId, SQLITE3_INTEGER);
        $stmt->bindParam(':org_id', $orgId, SQLITE3_INTEGER);
        $result = $stmt->execute();

        $problems = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $problems[] = $row;
        }

        return $problems;
    }

    public function getProblemByIds($id, $orgId) { //retrieves problem data from the database using problem id

        $stmt = $this->db->prepare("SELECT * FROM problems WHERE problem_id = :id AND org_id = :org_id");
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $stmt->bindValue(':org_id', $orgId, SQLITE3_INTEGER);
        $result = $stmt->execute();

        return $result->fetchArray(SQLITE3_ASSOC) ?: null;   
    }

}

?>
<?php

//login controller class which handles login functionality

require_once __DIR__ . '/../models/userRepo.php';
require_once __DIR__ . '/../services/loggingService.php';

class LoginController {

    private $userRepo;

    public function __construct() {
        
        require_once __DIR__ . '/../models/userRepo.php';
        $this->userRepo = new UserRepository();
    }

    public function handleLogin() {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        };

        if (!isset($_SESSION['attempts'])) {
            $_SESSION['attempts'] = 0;
        }

        if (!isset($_SESSION['lockout'])) {
            $_SESSION['lockout'] = 0;
        }

        $erroruser = "";
        $errorpass = "";
        $allFields = true;

        if (isset($_POST['submit'])) {

            if ($_SESSION['lockout'] > time()) {

                $errorpass = "⚠️ Too many failed login attempts, try again later";

                return [
                    "erroruser" => $erroruser,
                    "errorpass" => $errorpass
                    ];
            }

            if (empty($_POST['user'])) {
                $erroruser = "⚠️ Username is mandatory";
                $allFields = false;
            }

            if (empty($_POST['pass'])) {
                $errorpass = "⚠️ Password is mandatory";
                $allFields = false;
            }

            if ($allFields) {
                $user = $this->userRepo->verify($_POST['user'], $_POST['pass']);

                if ($user) {

                    $_SESSION['attempts'] = 0;
                    $_SESSION['lockout'] = 0;

                    session_regenerate_id(true);
                    $_SESSION["role"]  = $user["role"];
                    $_SESSION["name"]  = $user["username"];
                    $_SESSION["user_id"] = $user["user_id"];
                    $_SESSION["org_id"]  = $user["org_id"];
                    $_SESSION["login_time_stamp"] = time();

                    if ($user['role'] === 'consumer') {
                    header("Location: home.php");
                    } else if ($user['role'] === 'help desk agent') {
                    header("Location: home.php");
                    }

                    loggingService::log("LOGIN_SUCCESS, USER_ID = " . $user["user_id"]);

                } else {

                    # SECURITY FIX
                    # Weakness ID: W5
                    # Fix ID: F5 - Rate Limiting
                    # STRIDE: Spoofing/Denial of Service
                    # OWASP: A07 Authentication Failures
                    # CWE: CWE-307
                    # CIA: Confidentiality, Availability
                    # ASVS: V6.3 – General Authentication Security
                    # D3FEND: D3-ANET - Authentication Event Thresholding

                    $_SESSION['attempts']++;

                    if ($_SESSION['attempts'] >= 3) {

                        $_SESSION['lockout'] = time() + 60;
                        $errorpass = "⚠️ Too many failed login attempts, try again later";

                    } else {

                        $errorpass = "⚠️ Invalid username/password combination";
                    }

                    loggingService::log("LOGIN_FAILURE, USERNAME = " . $_POST['user']);
                    
                }
            }
        }

        return [
            "erroruser" => $erroruser,
            "errorpass" => $errorpass
        ];

    }
}
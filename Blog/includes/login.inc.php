<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        require_once 'dbh.inc.php';
        require_once 'login_model.inc.php'; 
        require_once 'login_contr.inc.php'; 

        $username = $_POST["username"];
        $password = $_POST["password"];

        $errors = [];

        if (is_input_empty($username, $password)) {
            $errors["empty_input"] = "Fill in all fields!";
        }

        $result = get_user($pdo, $username);

        if (is_username_wrong($result)) {
            $errors["login_incorrect"] = "Incorrect login info!";
        } else {
            if (is_password_wrong($password, $result["pw"])) {
                $errors["login_incorrect"] = "Incorrect login info!";
            }
        }

        if (!empty($errors)) {
            $_SESSION["errors_login"] = $errors;
            header("Location: ../index.php?page=login"); 
            exit();
        }

        $newSessionId = session_create_id();
        $sessionId = $newSessionId . "_" . $result["id"];
        session_id($sessionId);

        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_username"] = htmlspecialchars($result["username"]);

        $_SESSION["last_regeneration"] = time();

        header("Location: ../home.php?login=success");

        exit();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    exit();
}
?>

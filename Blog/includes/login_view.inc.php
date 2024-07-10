<?php

declare(strict_types=1);

function  check_login_errors() {
    echo $_SESSION["errors_login"];
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];
        echo "we have errors";


        echo "<br>";

        foreach ($errors as $error) {
            echo '<p>' . $error . '</p>';
        }

        unset($_SESSION["errors_login"]);
    } else if (isset($_GET["login"]) && $_GET["login"] === "success") {
        echo "Logged in successfully!";
    }
}
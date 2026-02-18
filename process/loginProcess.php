<?php
require "../db/connection.php";
session_start();

$email = $_POST["email"];
$password = $_POST["password"];
$remembarMe = isset($_POST["remembarMe"]) ? $_POST["remembarMe"] : false;

if (empty($email)) {
    echo "Please enter email address.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address";
} else if (empty($password)) {
    echo "Please enter the password.";
} else {

    $result = Database::search("SELECT `id`, `fname` , `lname`, `email`, `password_hash`, `active_account_type_id` FROM `user` WHERE `email` = ?", "s", [$email]);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password_hash"])) {

        $r = Database::search("SELECT `name` from `account_type` WHERE `id` = ?","i",[$user["active_account_type_id"]]);
        if ($r && $r->num_rows > 0) {
            $user_type_row = $r->fetch_assoc();
        }

            // Create session
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["fname"] . " " . $user["lname"];
            $_SESSION["user_email"] = $user["email"];
            $_SESSION["account_type_id"] = $user["active_account_type_id"];
            $_SESSION["active_account_type"] = $user_type_row["name"];
            $_SESSION["logged_in"] = true;


            if ($remembarMe == "true") {
                $rememberToken = bin2hex(random_bytes(32));
                $tokenHash = password_hash($rememberToken, PASSWORD_DEFAULT);

                $expiry = date("Y-m-d H:i:s", strtotime("+30 days"));
                Database::iud(
                    "INSERT INTO `remember_tokens` (`user_id` , `token_hash`, `expiry` ) VALUES (?,?,?)",
                    "iss",
                    [$user["id"], $tokenHash, $expiry]
                );
                setcookie("skillshop_remember", $rememberToken, strtotime("+30 days"), "/");
                setcookie("skillshop__user_id", $user["id"], strtotime("+30 days"), "/");
                setcookie("skillshop__user_email", $email, strtotime("+30 days"), "/");
            } else {
                setcookie("skillshop_remember", "", time() - 3600, "/");
                setcookie("skillshop__user_id", "", time() - 3600, "/");
                setcookie("skillshop__user_email", "", time() - 3600, "/");
            }

            echo "success";
        } else {

            echo "Invalid Password.";
        }
    } else {

        echo "Invalid Email.";
    }
}

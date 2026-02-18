<?php
require "../db/connection.php";

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];
$re_password = $_POST["re_password"];
$accountType = $_POST["account_type"];
$termsConditions = isset($_POST["termsConditions"]);

if (empty($fname)) {
    echo "Please enter first name.";
} else if (empty($lname)) {
    echo "Please enter last name.";
} else if (empty($email)) {
    echo "Please enter email address.";
} else if (strlen($email) >= 150) {
    echo "Email must be less than less 150 characters.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address";
} else if (empty($password)) {
    echo "Please enter the password.";
} else if ($password != $re_password) {
    echo "Passwords don't match.";
} else if (strlen($password) < 8 || strlen($password) > 20) {
    echo "Password length should be between 8 and 20";
} else if (empty($accountType)) {
    echo "Please select account type.";
} else if (!$termsConditions) {
    echo "Please read and check I agree to the Terms & Conditions";
} else {

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    //Check Account type from Database
    $result = Database::search("SELECT `id` FROM `account_type` WHERE `name`=?", "s", [$accountType]);

    if ($result && $row = $result->fetch_assoc()) {
        $accountTypeId = $row["id"];
    } else {
        echo "Invalid account type.";
        exit;
    }

    //Check Email
    $check = Database::search("SELECT `id` FROM `user` WHERE `email`=?", "s", [$email]);
    if ($check && $check->num_rows > 0) {
        echo "Email is Already Registered.";
        exit;
    } else {

        //Insert User
        $insertUser = Database::iud(
            "INSERT INTO `user` (`fname`, `lname`, `email`, `password_hash`, `active_account_type_id`) VALUES (?, ?, ?, ?, ?)",
            "ssssi",
            [$fname, $lname, $email, $passwordHash, $accountTypeId]
        );

        if ($insertUser) {

            //Get new user id
            $user_id = Database::getConnection()->insert_id;
            $insertRole = Database::iud(
                "INSERT INTO `user_has_account_type` (`user_id`, `account_type_id`) VALUES (?, ?)",
                "ii",
                [$user_id, $accountTypeId]
            );
            echo ($insertRole ? "success" : "Error assigning account type.");
        } else {
            echo "Error creating user account";
        }
    }
}

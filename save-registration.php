<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registering User</title>
</head>
<body>
<?php

    $email = $_POST['email'];
    $userName = $_POST['userName'];
    $ok = true;
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
//if we edit the previous data and we doesnot new password and it take previous one from database
if(!empty($_GET['email'])){
    $emailPicked = $_GET['email'];
    if (empty($password)) {

        require_once('db.php');
        $sql = "SELECT * FROM users
                 WHERE email = :emailPicked";
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':emailPicked', $emailPicked, PDO::PARAM_STR, 120);
        $cmd->execute();
        $user = $cmd->fetch();
        $password=$user['password'];
        $confirm=$user['password'];
    }
}

        //check if the passwords match
    if ($password != $confirm) {
            echo 'The passwords do not match <br />';
            $ok = false;
    }

    if (strlen($password) < 8) {
            echo 'The password is too short, must be 8 or more characters
                        <br />';
            $ok = false;
        }

        if (empty($email)) {
            echo 'You must enter an email address <br />';
            $ok = false;
        }

        //if the email and password are ok
        if ($ok) {

            //connect to the DB and setup the new user
            //Step 1 - connect to the DB
            require_once('db.php');
            //Step 2 - create the SQL command
            if (!empty($_GET['email'])) {


                $sql = "UPDATE users
                        SET email =:email,
                            userName=:userName,
                            password =:password
                            WHERE email = :emailPicked";
            } else {
                $sql = "INSERT INTO users VALUES (:email, :userName, :password)";
                //Step 2.5 - hash the password
                $password = password_hash($password, PASSWORD_DEFAULT);


            }

            //Step 3 - prepare and execute the SQL
            $cmd = $conn->prepare($sql);
            $cmd->bindParam(':email', $email, PDO::PARAM_STR, 120);
            $cmd->bindParam(':userName', $userName, PDO::PARAM_STR, 100);
            $cmd->bindParam(':password', $password, PDO::PARAM_STR, 255);
            if (!empty($_GET['email'])) {
                $cmd->bindParam(':emailPicked', $emailPicked, PDO::PARAM_STR, 120);
            }


            try {
                $cmd->execute();
            } catch (Exception $e) {
                echo $e->getMessage();
                if (strpos($e->getMessage(), 'Integrity constraint violation: 1062') == true) {
                    header('location:registration.php?errorMessage=email-already-exists');
                    $conn = null;
                    exit();
                }
            }

                //Step 4 - disconnect from the DB
                $conn = null;


                //Step 5 - redirect to the login page
                if (!empty($_GET['email'])) {

                    header('location:admins.php');
                } else {
                    header('location:login.php');
                }


        }
?>
</body>
</html>

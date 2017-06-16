<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $pageTitle ?></title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="css/styles.css">

</head>
<body>

<nav class="nav navbar-inverse">
    <ul class="nav navbar-nav">
        <li><a href="default.php" class="navbar-brand">Assignment</a></li>

        <?php
        session_start();

        //public (not logged in) links
        if (empty($_SESSION['email']))
        {
            echo '<li><a href="registration.php">Register</a></li>
                  <li><a href="login.php">Login</a></li>
                  <li><a href="admins.php">Admins</a></li></ul>';
        }

        //private / logged in links
        else
        {
            echo '<li><a href="admins.php">Admins</a></li>
                  <li><a href="logout.php">Logout</a></li></ul>';

            echo '<li><div class="navbar-text pull-right">' . $_SESSION['userName'] . '</div></li>';

                          }
        ?>
    </ul>


</nav>


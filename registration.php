<?php
$pageTitle = 'Registration';
require_once('header.php');
?>

<main class="container">


    <?php
    if (!empty($_GET['email']))
    {   $email = $_GET['email'];

    }
    else {
        $email = null;
    }
    $userName = null;






    if (!empty($email))
    {
        require('db.php');

        $sql = "SELECT * FROM users WHERE email=:email";
        $cmd = $conn->prepare($sql);
        $cmd->bindParam(':email', $email, PDO::PARAM_STR,120);
        $cmd->execute();
        $user = $cmd->fetch();
        $conn = null;


        $userName = $user['userName'];




    }
    ?>
<!--show an heading according to the condition like if we are edit page it show edit heading and on registration page it show registration heading -->
        <?php
            if (!empty($_GET['email'])){
                echo '<h1>Edit Admin</h1>';
            }
            else{
                echo '<h1>Admin Registration</h1>';
            }
            if (!empty($_GET['errorMessage']))
                echo '<div class="alert alert-danger" id="message">Email address already exists</div>';
            else if(!empty($_GET['email']))
                echo'<div class="alert alert-info" id="message">Edit the details of users</div>';
            else
                echo '<div class="alert alert-info" id="message">Please create your account</div>';
        ?>




<!--    in these we send the email with to recognise that we edit the data or enter the data on save registration page-->
<?php
if(!empty($_GET['email']))
{
    echo'<form method="post" action="save-registration.php?email='.$email.'">';
}
else
{
    echo '<form method="post" action="save-registration.php">';
}
?>
    <!--    if email is not get through link then it means we are at registration page otherwise it is at edit page.  -->
            <fieldset class="form-group">
                <label for="email" class="col-sm-2" >Email: *</label>
                <input name="email" id="email" type="email" required
                        placeholder="email@email.com"  value="<?php echo $email ?>"/>
            </fieldset>
            <fieldset class="form-group">
                <label for="userName" class="col-sm-2">User Name: </label>
                <input name="userName" id="userName" placeholder="your name" value="<?php echo $userName ?>"/>
            </fieldset>
<!--    if email is not get through link then it means we are at registration page otherwise it is at edit page.  -->
    <?php

    if(!empty($_GET['email']))
    {  echo '<fieldset class="form-group">
                <label for="password" class="col-sm-2">Password: </label>
                <input name="password" id="password" type="password" placeholder="Password" 
                        autofocus   />
                <span id="result"></span>
            </fieldset>
            <fieldset class="form-group">
                <label for="confirm" class="col-sm-2">Re-enter Password: </label>
                <input name="confirm" id="confirm" type="password" placeholder="Confirm Password"
                        />
            </fieldset>';
    }
    else
    {  echo '<fieldset class="form-group">
                <label for="password" class="col-sm-2">Password: </label>
                <input name="password" id="password" type="password" placeholder="Password" required
                        autofocus title="Passwords must contain uppercase, lowercase and numbers"  />
                <span id="result"></span>
            </fieldset>
            <fieldset class="form-group">
                <label for="confirm" class="col-sm-2">Re-enter Password: </label>
                <input name="confirm" id="confirm" type="password" placeholder="Confirm Password"
                        />
            </fieldset>';

    }
    ?>

                     <?php
                     if(!empty($_GET['email']))
                     {
                         echo'<button class="btn btn-success col-sm-offset-2">Save Changes</button>
                        </form>';
                     }
                     else{
                     echo' 
                    <button class="btn btn-success col-sm-offset-2 btnRegister">Register</button>
                    </form>';
                     }
                     ?>









    </main>


<?php require_once('footer.php') ?>

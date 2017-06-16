<?php
$pageTitle = 'Admin';
require_once('header.php');
?>

<main class="container">
    <h1>Admins</h1>
<?php



require_once('db.php');
$sql = "SELECT * FROM users";
$cmd = $conn->prepare($sql);

//step 4 - execute and store the results
$cmd->execute();
$users = $cmd->fetchAll();

//step 5 - disconnect from the DB
$conn = null;

//create a table and display the results
echo '<table class="table table-striped table-hover">
            <tr><th>User Name</th>
                <th>E-mail</th>';

if (!empty($_SESSION['email'])){
    echo '<th>Edit</th>
                  <th>Delete</th>';
}

echo '</tr>';

foreach($users as $user)
{
    echo '<tr><td>'.$user['userName'].'</td>
                      <td>'.$user['email'].'</td>';

    //only show the edit and delete links if these are valid, logged in users
    if (!empty($_SESSION['email'])){
        $emailPicked=$_SESSION['email'];
        echo '<td><a href="registration.php?email='.$user['email'].'"
                                class="btn btn-primary">Edit</a></td>';

                if($emailPicked !=$user['email']) {
                    echo '<td><a href="deleteAdmin.php?email='.$user['email'].'" 
                                class="btn btn-danger confirmation">Delete</a></td>';
                }
                else{
                    echo '<td></td>';
                }
    }
    echo '</tr>';
}

echo '</table></main>';

require_once ('footer.php');
?>



<?php  
if (file_exists('D:/xampp/htdocs/oops/thermoking/app/users.php')) {
    include_once('D:/xampp/htdocs/oops/thermoking/app/users.php');
} else {
    echo "File not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new Users();
    $user->name = htmlspecialchars(trim($_POST['name']));
    $user->email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $user->password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password

    if ($user->register()) {
        echo "User is registered successfully.";
    } else {
        echo "Unable to register.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration Form</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-6">
            <h2>Registration Form</h2>
            <form class="form-horizontal" action="register.php" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pwd">Password:</label>
                    <div class="col-sm-10">          
                        <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" required>
                    </div>
                </div>
                
                <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="login.php" class="btn btn-danger">Login</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

<?php  
session_start(); // ✅ Start session to manage user login state

if (file_exists('D:/xampp/htdocs/oops/thermoking/app/users.php')) {
    include_once('D:/xampp/htdocs/oops/thermoking/app/users.php');
} else {
    echo "File not found.";
    exit;
}

$user = new Users();

// ✅ Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = "";
$success = "";

// ✅ Handle Logout Request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    if ($user->logout()) {
        header("Location: login.php");
        exit;
    } else {
        $error = "Logout failed. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
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
            <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
            <p>Your email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>

            <!-- ✅ Error/Success Messages -->
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
            <?php endif; ?>

            <!-- ✅ Logout Form -->
            <form class="form-horizontal" action="dashboard.php" method="post">
                <div class="form-group">        
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="logout" class="btn btn-danger">Log out</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

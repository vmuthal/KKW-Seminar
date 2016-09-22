<head>
    <title>TODO Example with Plain PHP</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
    <?php
    session_start();
    $page = "login";
    include 'navbar.php';
    include 'config.php';

    
    $error = "";
    if (isset($_SESSION['simpleLoggedIn'])) {
        header('Location: index.php');
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $stmt = $dbh->prepare("SELECT * FROM users WHERE username=:username AND password=:password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $_SESSION['simpleLoggedIn'] = true;
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);            
            $_SESSION['simpleUserId'] = $users[0]['id'];            
            header('Location: index.php');
        } else {
            $error = "Invalid Username / Password.";
        }
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-md-offset-4">
                <form method="post">
                    <h3>Login to proceed</h3>                        
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-default">Login</button>
                    <div><?php echo $error; ?></div>
                </form>
            </div>
        </div>
    </div>    
</body>
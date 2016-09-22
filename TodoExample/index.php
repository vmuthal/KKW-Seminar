<?php
/**
 * Author : Vivek Muthal
 * Email : vmuthal.18@gmail.com
 * Description: A simple php todos application.
 */
?>
<head>
    <title>TODO Example with Plain PHP</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
    <?php
    session_start();
    $page = "home";
    include 'navbar.php';
    include 'config.php';
    ?>

    <div class="container">
        <div class="row">                        
            <h1>To Do's Example</h1>
            <?php
            if (isset($_SESSION['simpleLoggedIn'])) {
                $user_id = $_SESSION['simpleUserId'];
                $stmt = $dbh->prepare("SELECT * FROM todos WHERE user=:user");
                $stmt->bindParam(':user', $user_id);

                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $todos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $todos = [];
                }
                ?>
                <form method="post">                
                    <div class="form-group">
                        <label for="todo">TODO:</label>
                        <input type="text" class="form-control" id="username" name="todo">
                    </div>
                    <button type="submit" class="btn btn-default">Add</button>                
                </form>
                <h3>Pending Todos</h3>
                <form method="post" id='todos'>
                    <?php
                    foreach ($todos as $todo) {
                        if (!$todo['is_complete']) {
                            ?>

                            <div><label><input type='checkbox' value='<?php echo $todo['id']; ?>' name='todocomplete[]' onclick="document.getElementById('todos').submit();"> <?php echo $todo['todo']; ?></label></div>
                            <?php
                        }
                    }
                    ?>

                </form>
                <h3>Completed Todos</h3>
                <?php
                foreach ($todos as $todo) {
                    if ($todo['is_complete']) {
                        ?>

                        <div> <label> <?php echo $todo['todo']; ?></label></div>
                        <?php
                    }
                }
                ?>

                <?php
            } else {
                ?>
                <h3>Can't show your todo's. Login to see.</h3>
            <?php } ?>
        </div>
    </div>
</body>

<?php
if (isset($_SESSION['simpleLoggedIn'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['todo'])) {
            $todo = $_POST['todo'];
            $user_id = $_SESSION['simpleUserId'];
	    $is_complete = 0;
            if (!empty($todo)) {
                $stmt = $dbh->prepare("INSERT INTO todos (todo, is_complete, user) VALUES (:todo,:is_complete,:user)");
                $stmt->bindParam(':todo', $todo);
		$stmt->bindParam(':is_complete', $is_complete);
                $stmt->bindParam(':user', $user_id);
                $stmt->execute();
                header('Location: index.php');
            }
        }

        if (isset($_POST['todocomplete'])) {
            $todos = $_POST['todocomplete'];
            $user_id = $_SESSION['simpleUserId'];
            foreach ($todos as $todo_id) {
                $stmt = $dbh->prepare("UPDATE todos SET is_complete=true WHERE id=:id AND user=:user_id");
                $stmt->bindParam(':id', $todo_id);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();
                header('Location: index.php');
            }
        }
    }
}
?>
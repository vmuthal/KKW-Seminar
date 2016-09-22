<nav class="navbar navbar-default">
    <div class="container-fluid">                
        <div class="navbar-header">                    
            <a class="navbar-brand" href="index.php">TODO Example</a>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="<?php if($page == 'home'){ echo 'active'; } ?>"><a href="index.php">Home<span class="sr-only">(current)</span></a></li>                        
            </ul>                    
            <ul class="nav navbar-nav navbar-right">
                <?php                
                if (!isset($_SESSION['simpleLoggedIn'])) {
                    ?>                
                    <li class="<?php if($page == 'register'){ echo 'active'; } ?>"><a href="register.php">Register</a></li>
                    <li class="<?php if($page == 'login'){ echo 'active'; } ?>"><a href="login.php">Login</a></li>
                <?php } else { ?>
                    <li><a href="logout.php">Logout</a></li>
                <?php } ?>
            </ul>
        </div>            
    </div>
</nav>
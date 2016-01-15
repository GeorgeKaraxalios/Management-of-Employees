<html>
    <head></head>

    <body>
        
        <form action="validate.php" method="POST">
            <?php
                if(isset($_GET['error'])) echo "pare tin poutsa m.Eimai ninja";
            ?>
            <label for="username">Usename</label>
            <input type="text" id="username" name="username"/>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password"/>
            
            <input type="submit" value="Login" />
            
        </form>
    </body>
    
</html>

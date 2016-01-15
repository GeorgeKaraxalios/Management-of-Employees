<?php
    include './CheckForLogin/Check.php';
    $_SESSION["ProgrammThatUserClick"] = "Καταχώρηση";
    if ($_SESSION['Permissions'] == '0')
    {
        echo "<script type='text/javascript'>window.location.href='UserIndexPage.php';</script>";
    }
    if ($_SESSION['Permissions'] == '1')
    {
        echo "<script type='text/javascript'>window.location.href='AdminIndexPage.php';</script>"; 
    }
?>

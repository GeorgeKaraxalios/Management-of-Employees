<?php
    session_start();
    //Εάν δεν έχει οριστεί η μεταβλητή "username" (δηλαδή δεν έχει κάνει Login) τότε το πρόγραμμα αυτομάτος 'πηγαίνει' τον χρήση στην σελίδα
    //του Login για να πραγματοποιήσει την διαδικασία της σύνδεσης
    //www.anthropino-dinamiko.gr
    if(!isset($_SESSION['UserName']))
    {
        header('Location: ../LoginSystem');
    }
    else
    {
    }
?>


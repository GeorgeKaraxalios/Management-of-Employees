<?php
    include './CheckForLogin/Check.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="css/Input_Buttons.css" rel="stylesheet">
    </head>
    <body>
        <form action="UserIndexPage.php" method="post" class="form" style="text-align:center">
            <input type="submit" name="ProcessingSomeInfoOfEmployee" id="ProcessingSomeInfoOfEmployee" value="Επεξεργασία στοιχείων υπαλλήλου"><br>
            <input type="submit" name="KataxorisiSubmitButton" id="KataxorisiSubmitButton" value="Καταχώρηση προσωπικού"><br>
            <input type="submit" name="AnazitisiSubmitButton" id="AnazitisiSubmitButton" value="Αναζήτηση προσωπικού"><br>
            <input type="submit" name="EktiposiTheseonSubmitButton" id="EktiposiTheseonSubmitButton" value="Εκτύπωση θέσεων"><br>
            <input type="submit" name="EksodosApoTinefarmogiSubmitButton" id="EksodosApoTinefarmogiSubmitButton" value="Έξοδος από την εφαρμογή">
        </form>
        <?php
            if (isset($_POST['KataxorisiSubmitButton']))
            {
                $_SESSION['AntistoixoKoumpi'] = "Καταχώρηση";
                header("Location: KataxorisiProsopikou.php");
            }
            if (isset($_POST['AnazitisiSubmitButton']))
            {
                $_SESSION['AntistoixoKoumpi'] = "Αναζήτηση";
                header("Location: AmazitisiProsopikou.php");
            }
            if (isset($_POST['EktiposiTheseonSubmitButton']))
            {
                $_SESSION['AntistoixoKoumpi'] = "Εκτύπωση θέσεων";
                header("Location: InputNodeToPrint.php");
            }
            if (isset($_POST['ProcessingSomeInfoOfEmployee']))
            {
                $_SESSION['AntistoixoKoumpi'] = "Επεξεργασία στοιχείων";
                header("Location: GiveSomeFieldsToProcessing.php");
            }
            if (isset($_POST['EksodosApoTinefarmogiSubmitButton']))
            {
                header("Location: ../LoginSystem/Menu.php");
            }
            
            function Insert()
            {
                include './connector.php';
                $con = new Connector();
                //Το όνομα του χρήστη που κάνει σύνδεση
                $NameOfLogin = $_SESSION['NameOfLogin'];
                
                //Το επώνυμο του χρήστη που κάνει σύνδεση
                $SurnameOfLogin = $_SESSION['SurnameOfLogin'];
                
                //Το πρόγραμμα που επέλεξε να χρησιμοποιήσει ο χρήστης
                $ProgrammThatUserClick = $_SESSION["ProgrammThatUserClick"];
                $res = $con->prepare("INSERT INTO history VALUES('$NameOfLogin', '$SurnameOfLogin', '$ProgrammThatUserClick','null')");
            }
        ?>
    </body>
</html>

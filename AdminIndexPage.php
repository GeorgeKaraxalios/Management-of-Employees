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
        <form action="AdminIndexPage.php" method="post" class="form" style="text-align:center">
            <input type="submit" name="ProcessingSomeInfoOfEmployee" id="ProcessingSomeInfoOfEmployee" value="Επεξεργασία στοιχείων υπαλλήλου"><br>
            <input type="submit" name="KataxorisiSubmitButton" id="KataxorisiSubmitButton" value="Καταχώρηση προσωπικού"><br>
            <input type="submit" name="DiagrafiIpallilouSubmitButton" id="DiagrafiIpallilouSubmitButton" value="Διαγραφή υπαλλήλου"><br>
            <input type="submit" name="AnazitisiSubmitButton" id="AnazitisiSubmitButton" value="Αναζήτηση προσωπικού"><br>
            <input type="submit" name="EktiposiTheseonSubmitButton" id="EktiposiTheseonSubmitButton" value="Εκτύπωση θέσεων"><br>
            <input type="submit" name="EksodosApoTinefarmogiSubmitButton" id="EksodosApoTinefarmogiSubmitButton" value="Έξοδος από την εφαρμογή"><br>
            <input type="submit" name="EktiposiIstorikouSubmitButton" id="EktiposiIstorikouSubmitButton" value="Εκτύπωση ιστορικού"><br>
            <input type="submit" name="ProthikiPedionStinKataxorisiSubmitButton" id="ProthikiPedionStinKataxorisiSubmitButton" value="Προσθήκη επιπλέον πεδίων"><br>
        </form>
        <?php
            if (isset($_POST['EktiposiIstorikouSubmitButton']))
            {
                $_SESSION['AntistoixoKoumpi'] = "Εκτύπωση ιστορικού";
                header("Location: EktiposiIstorikou.php");
            }
            if (isset($_POST['ProthikiPedionStinKataxorisiSubmitButton']))
            {
                $_SESSION['AntistoixoKoumpi'] = "Προσθήκη πεδίων";
                header("Location: ProthikiPedion.php");
            }
            if (isset($_POST['DiagrafiIpallilouSubmitButton']))
            {
                $_SESSION['AntistoixoKoumpi'] = "Διαγραφή Υπαλλήλου";
                header("Location: DiagrafiIpallilou.php");
            }
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
                $NameOfLogin = $_SESSION['NameOfLogin'];
                $SurnameOfLogin = $_SESSION['SurnameOfLogin'];
                $ProgrammThatUserClick = $_SESSION['ProgrammThatUserClick'];
                $res = $con->prepare("INSERT INTO history VALUES('$NameOfLogin', '$SurnameOfLogin', '$ProgrammThatUserClick','null')");
            }
        ?>
    </body>
</html>

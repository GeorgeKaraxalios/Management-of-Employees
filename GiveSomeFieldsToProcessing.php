<?php
    include './CheckForLogin/Check.php';
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type='text/javascript' src='js/jquery.autocomplete.js'></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />
        <link href="css/Form_Style.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/StyleButtonTags.css" />
    </head>
    <body>
        <script type="text/javascript">            
            $(function()
            {
                $("#SurnameOfEmployeeText").autocomplete("get_course_list.php",
                {
                    width: 260,
                    matchContains: true,
                    selectFirst: false
                });
            });
        </script>
        
        <form name="InputInfoToProccessing" class="form" action="InputInfoToProccessing.php" method="post" enctype="multipart/form-data">
            <div id="main">
                <div id="first">
            <table>
                <tr>
                    <td>
                        <label  id="SurnameOfEmployee" name="SurnameOfEmployee"><strong>Δώσε τo επίθετο του υπαλήλου για επεξεργασία πληροφοριών</strong></label>
                    </td>
                    <td>
                        <input type="text" id="SurnameOfEmployeeText" name="SurnameOfEmployeeText" required>
                    </td>
                </tr>
            </table>
            <br />
            <label  id="LabelToAsk" name="LabelToAsk"><strong>Επιλέξτε ενα ή περισσότερα πεδία απο τα παρακάτω, ώστε να μπορείτε να το επεξεργαστείτε.</strong></label>
            <?php
                $TitleInGreek = null;
                $IndexArrayOfTiles = 0;
                $i = 0;
                $ArrayOfTitles = array();
                $FieldsForChanging = array();
                include 'connector.php';
                $con = new Connector();
                $result = $con->prepare("SHOW COLUMNS FROM kataxorisiuser");
                while($r = $result->fetch())
                {
                    if ($i >= 3)
                    {
                        $ArrayOfTitles[$IndexArrayOfTiles] = $r['Field'];
                        $IndexArrayOfTiles++;
                    }
                    $i++;
                }
                $i = 0;
                $f = 0;
                echo "<br>";
                $result = $con->prepare("SELECT * FROM nameoftext");
                while($r = $result->fetch())
                {
                    $TitleInGreek = $r['Name'];
                    ?>
                    <input type="checkbox" id="<?php echo $TitleInGreek; ?>" name="check_list[]" value="<?php echo $ArrayOfTitles[$i]."_".$TitleInGreek; ?>">
                    <?php $FieldsForChanging[$f] =  $ArrayOfTitles[$i];?>
                    <label for="<?php echo $TitleInGreek; ?>"><?php echo $TitleInGreek; ?></label>
                    <br/>
                    <?php
                    $i++;
                    $f++;
                }
                $_SESSION['FieldsForChanging'] = $FieldsForChanging;
            ?>
            <br />
            <input type="submit" name="submit" value="Αλλαγή στοιχείων"/><br />
            <button type="button" onclick="window.location.reload();">Επαναφόρτωση σελίδας</button><br />
            <button type="button" onclick="window.location.href='index.php'">Αρχική</button>
            </div>
                </div>
        </form>
        
        
    </body>
</html>

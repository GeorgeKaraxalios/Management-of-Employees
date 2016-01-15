<?php
    include './CheckForLogin/Check.php';
    //Εμφάνηση ώρα Ελλάδος
    date_default_timezone_set('Europe/Athens');
?>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type='text/javascript' src='js/jquery.autocomplete.js'></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />
    </head>
    
    <body>
        <script type="text/javascript">
            $(function()
            {
                $("#SurnameOfEmployeeTextForDelete").autocomplete("get_course_list.php",
                {
                    width: 260,
                    matchContains: true,
                    selectFirst: false
                });
            });
        </script>
        <form action="DiagrafiIpallilou.php" method="POST">
            <table>
                <tr>
                    <td>
                        <label id="SurnameOfEmployeeForDelete" name="SurnameOfEmployeeForDelete"><strong>Δώσε τo επίθετο του υπαλήλου για αναζήτηση και διαγραφή</strong></label>
                    </td>
                    <td>
                        <input class="typetext" type="text" id="SurnameOfEmployeeTextForDelete" name="SurnameOfEmployeeTextForDelete" onselect="CheckIfImageExist(this);">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="SubmitDeleteUser" id="SubmitDeleteUser" value="Διαγραφή">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="SubmitGoMainPage" id="SubmitGoMainPage" value="Αρχική">
                    </td>
                </tr>
            </table>
        </form>
        
        <?php
            include './connector.php';
            $Connector = new Connector();
            $Name = null;
            $Surname = null;
            $Situation = null;
            $Branch = null;
            
            $CheckStringForSpaceOrPaula = array();
            $SurnameAndNameArray = array();
            if (isset($_POST['SubmitGoMainPage']))
            {
                echo "<script type='text/javascript'>window.location.replace('index.php')</script>";
            }
            if (isset($_POST['SubmitDeleteUser']))
            {
                $CheckStringForSpaceOrPaula = str_split($_POST['SurnameOfEmployeeTextForDelete']);
                print_r($CheckStringForSpaceOrPaula);
                echo "<br>";
                for ($i = 0; $i < count($CheckStringForSpaceOrPaula); $i++)
                {
                    if ($CheckStringForSpaceOrPaula[$i] == " ")
                    {
                        $SurnameAndNameArray = explode(" ",$_POST['SurnameOfEmployeeTextForDelete']);
                        print_r($SurnameAndNameArray);
                        echo "<br>";
                        break;
                    }
                    if ($CheckStringForSpaceOrPaula[$i] == "-")
                    {
                        $SurnameAndNameArray = explode("-",$_POST['SurnameOfEmployeeTextForDelete']);
                        print_r($SurnameAndNameArray);
                        echo "<br>";
                        break;
                    }
                }
                
                $Name = $SurnameAndNameArray[1];//Όνομα Υπαλλήλου για διαγραφή
                $Surname = $SurnameAndNameArray[0];//Επώνυμο Υπαλλήλου για διαγραφή
                
                echo "O Υπάλληλος ".$Name." ".$Surname." θα διαγραφή από το σύστημα<br>";
                $result = $Connector->prepare("SELECT Situation, branch, Service FROM kataxorisiuser WHERE Name='$Name' AND Surname='$Surname'");
                $row = $result->fetch();
                
                $Situation = $row['Situation'];
                $Branch = $row['branch'];
                $Service = $row['Service'];
                echo $Situation."<br>".$Branch."<br>".$Service."<br>";
                
                if ($Situation == "Μετάταξη")
                {
                    //Εκτέλεση εντολής sql η οποία επιστρέφει το πεδίο "id" της Υπηρεσίας στηνοποία βρίσκεται ο υπάλληλος προς διαγραφή
                    $result = $Connector->prepare("SELECT id FROM services WHERE value='$Service'");
                    $row = $result->fetch();
                    
                    //Εκχώρηση του πεδίου "id" που διαβάζεται στην μεταβλητή ID
                    $ID = $row['id'];
                    echo "ID = ".$ID."<br>";
                    //
                    $result = $Connector->prepare("Select select_service_table.value AS 'value1', services.value AS 'value2' "
                                                 ."FROM select_service_table INNER JOIN services ON select_service_table.id=$ID");
                    $row = $result->fetch();
                    $ServicesTable = $row['value1'];
                    
                    $result = $Connector->prepare("SELECT value, piasmenes_thesis, eleutheres_thesis, sinolikes_thesis FROM $ServicesTable WHERE value='$Branch'");
                    while($row = $result->fetch())
                    {
                        $piasmenes_thesis = $row['piasmenes_thesis'];
                        $eleutheres_thesis = $row['eleutheres_thesis'];
                        $sinolikes_thesis = $row['sinolikes_thesis'];
                        
                        $eleutheres_thesis = (int)$eleutheres_thesis + 1;
                        $piasmenes_thesis = (int)$piasmenes_thesis - 1;
                        
                        echo "piasmenes_thesis AFTER delete employee = ".$piasmenes_thesis."<br>eleutheres_thesis AFTER delete employee = ".$eleutheres_thesis."<br>";
                        $result = $Connector->prepare("UPDATE $ServicesTable SET eleutheres_thesis='$eleutheres_thesis', piasmenes_thesis='$piasmenes_thesis' WHERE value='$Branch'");
                        $result = $Connector->prepare("DELETE FROM kataxorisiuser WHERE Name='$Name' AND Surname='$Surname'");
                    }       
                }
            }
            $NameOfLogin = $_SESSION['NameOfLogin'];
            $SurnameOfLogin = $_SESSION['SurnameOfLogin'];
            $ProgrammThatUserClick = $_SESSION['ProgrammThatUserClick'];
            $description = "Ο/Η χρήστης (ον) ".$_SESSION['NameOfLogin']." (επ) ".$_SESSION['SurnameOfLogin']." εκτέλεσε την λειτουργία "
                          ."".$_SESSION['AntistoixoKoumpi']." για τον υπάλληλο με (ον) ".$Name." και (επ) ".$Surname.""
                          .".Η ".$_SESSION['AntistoixoKoumpi']." πραγματοποιήθηκε στις ".ConvertEnglishDaysAndMonthToGreek(date("l jS \of F Y")).
                           " και ώρα ".date("h:i:s").". Ο χρήστης με (ον) ".$_SESSION['NameOfLogin']." και (επ) ".$_SESSION['SurnameOfLogin'].""
                          ." χαρακτιρίζεται ως ".CheckUser().".";
            $res = $con->prepare("INSERT INTO history VALUES('$NameOfLogin', '$SurnameOfLogin', '$ProgrammThatUserClick','$description')");

            function CheckUser()
                {
                    $User = null;
                    if ($_SESSION['Permissions'] == 0)
                    {
                        $User = "user";
                    }
                    if ($_SESSION['Permissions'] == 1)
                    {
                        $User = "admin";
                    }
                    if ($_SESSION['Permissions'] == 2)
                    {
                        $User = "topuser";
                    }
                    return $User;
                }


            function ConvertEnglishDaysAndMonthToGreek($date)
            {
                $DaysOfWeekInGeekArray = array(0=>"Δευτέρα",1=>"Τρίτη",2=>"Τετάρτη",3=>"Πέμπτη",4=>"Παρασκευή",5=>"Σάββατο",6=>"Κυριακή");
                $MonthOfYearInGeekArray = array(0=>"Ιανουαρίου",1=>"Φλεβάρη",2=>"Μαρτίου",3=>"Απριλίου",4=>"Μαϊου",5=>"Ιουνίου",6=>"Ιουλίου",7=>"Αυγούστου",8=>"Σεπτεμβρίου"
                                               ,9=>"Οκτωβρίου",10=>"Νοεμβρίου",11=>"Δεκεμβρίου");
                $DaysOfWeekInEnglishArray = array(0=>"Monday", 1=>"Tuesday",2=>"Wednesday",3=>"Thursday", 4=>"Friday", 5=>"Saturday", 6=>"Sunday");
                $MonthOfYearInEnglishArray = array(0=>"January",1=>"February",2=>"March",3=>"April",4=>"May",5=>"June",6=>"July",7=>"August",8=>"September"
                                                  ,9=>"October",10=>"November",11=>"December");

                $i = 0;
                $ArrayToConv = array();
                $ArrayToConv = explode(" ",$date); 
                for ($i = 0; $i< count($DaysOfWeekInEnglishArray); $i++)
                {
                    if ($DaysOfWeekInEnglishArray[$i] == $ArrayToConv[0])
                    {
                        $ArrayToConv[0] = $DaysOfWeekInGeekArray[$i];
                    }
                }

                for ($i = 0; $i< count($MonthOfYearInEnglishArray); $i++)
                {
                    if ($MonthOfYearInEnglishArray[$i] == $ArrayToConv[3])
                    {
                        $ArrayToConv[3] = $MonthOfYearInGeekArray[$i];
                    }
                }
                if ((strlen($ArrayToConv[1])) == 3)
                {
                    $ArrayToConv[1] = substr($ArrayToConv[1], 0,-1);
                }
                if ((strlen($ArrayToConv[1])) == 4)
                {
                    $ArrayToConv[1] = substr($ArrayToConv[1], 0,-2);
                }
                $new_day = $ArrayToConv[0]." ".$ArrayToConv[1]." ".$ArrayToConv[3]." ".$ArrayToConv[4];
                return $new_day;
            }
        ?>
    </body>
</html>

<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        
        
    </script>
    </head>
    <body>
        <?php
        //Εμφάνηση ώρα Ελλάδος
        date_default_timezone_set('Europe/Athens');
        error_reporting(0);
        include 'connector.php';
        $con = new Connector();
        session_start();
        /*--*/$ArrayKeys = array();
        /*--*/$varNameArray = array();
        $ArrayWithInfoOE = array();
//        $ArrayWithSelectTextOV = array();
        
        $ArrayWithOldValues = array();
        $ArrayOfTitles = array();
        
        $ExistService = false;
        $Existbranch = false;
        
        $IndexArrayOfTitles = 0;
        $i = 0;
        $j = 0;
        
        $ChangeService = null;
        $ChangeBranch = null;
        $ServiceThatUserEnter = null;
        
        
        $ΑρραυΐτηΑλλΨολθμ = array();
        $OldValueOfChangeBranchPiasmenesThesis = 0;
        $OldValueOfChangeBranchEleutheresThesis = 0;
        $OldValueOfChangeBranchSinolikesThesis = 0;
        $ValueOfBranchThatUserEnterEleutheresThesis = 0;
        $ValueOfBranchThatUserEnterPiasmenesThesis = 0;
        $ValueOfBranchThatUserEnterBranchSinolikesThesis = 0;
        $TableOfChangeService = null;
        $TableOfServiceThatUserEnter = null;
        $LengthOfArrayKeys = 0;
        $LengthOfArrayWithInfoOE = 0;
        $LengthArrayWithSelectTextOV = 0;
    if (isset($_POST['submitGiveSomeFieldsToProcessingPage']))
    {
        echo "<script type='text/javascript'>window.location.href='GiveSomeFieldsToProcessing.php'</script>";
    }
    if(isset($_POST['submit']))
    {
        $Surname = $_SESSION['SurnameOE'];
        $Name = $_SESSION['NameOE'];
        $ArrayKeys = array_keys($_POST);
        $LengthOfArrayKeys = count($ArrayKeys);




        $result = $con->prepare("SHOW COLUMNS FROM kataxorisiuser");
        while($r = $result->fetch())
        {
            $ArrayOfTitles[$IndexArrayOfTitles] = $r['Field'];
            $IndexArrayOfTitles++;
        }
//        echo "ArrayOfTitles: <br>";
//        print_r($ArrayOfTitles);
//        echo "<br><br>";

        $result = $con->prepare("SELECT * FROM kataxorisiuser WHERE Name='$Name' AND Surname='$Surname'");
        $row = $result->fetch();
        for ($i = 0; $i<$IndexArrayOfTitles; $i++)
        {
            $ArrayWithOldValues[$i] = $row[$ArrayOfTitles[$j]];
            $j++;
        }

        for ($i = 0; $i<$LengthOfArrayKeys; $i++)
        {
            if ($ArrayKeys[$i] == "Service")
            {
                $ExistService = true;
            }
            if ($ArrayKeys[$i] == "branch")
            {
                $Existbranch = true;
                $BranchThatUserEnter = $_POST['branch'];
            }
        }


        if (($ExistService == true) || ($Existbranch == true))
        {
            //Get Old value of Service and branch if user Select to change Service or branch
                $ServiceThatUserEnter = $_POST['Service'];
//                echo "ServiceThatUserEnter = ".$ServiceThatUserEnter."<br>";
            for ($i = 0; $i<$LengthOfArrayKeys; $i++)
            {
                if ($ArrayKeys[$i] == "Service")
                {
                    for ($j = 0; $j < $IndexArrayOfTitles; $j++)
                    {
                        if ($ArrayOfTitles[$j] == "Service")
                        {
                            $ChangeService = $ArrayWithOldValues[$j];
//                            echo "<br>ChangeService = ".$ChangeService."<br>";
                        }
                    }
                }
                if ($ArrayKeys[$i] == "branch")
                {
                    for ($j = 0; $j < $IndexArrayOfTitles; $j++)
                    {
                        if ($ArrayOfTitles[$j] == "branch")
                        {
                            $ChangeBranch = $ArrayWithOldValues[$j];
//                            echo "<br>ChangeBranch = ".$ChangeBranch
//                                    ."<br>";
                        }
                    }
                }
            }
            //Get Corresponding table of ChangeService and return
            $res = $con->prepare("SELECT id FROM services WHERE value=?",array($ChangeService));
            $r = $res->fetch();
            $IdOfChangeService = (int)$r['id'];

            $res = $con->prepare("SELECT services.value, select_service_table.value FROM services INNER JOIN select_service_table ON "
                                                . "services.id=select_service_table.id AND services.id=$IdOfChangeService");
            while($r3 = $res->fetch())
            {
                $TableOfChangeService = $r3['value'];
                $res = $con->prepare("SELECT * from ".$TableOfChangeService." WHERE value='$ChangeBranch'");
                while($r4 = $res->fetch())
                {
                    $OldValueOfChangeBranchEleutheresThesis = (int)$r4['eleutheres_thesis'];
                    $OldValueOfChangeBranchPiasmenesThesis = (int)$r4['piasmenes_thesis'];
                    $OldValueOfChangeBranchSinolikesThesis = (int)$r4['sinolikes_thesis'];
                }
            }
//            echo $TableOfChangeService."<br>";
    //        echo "ArrayWithSelectTextOV: <br>";
    //        print_r($ArrayWithSelectTextOV);
    //        echo "<br><br>";
        }

        //If user not select to change Service and Speciality
        for ($j=0; $j<$LengthOfArrayKeys; $j++)
        {
            for ($i = 0; $i<$IndexArrayOfTitles; $i++)
            {
                if ($ArrayOfTitles[$i] == $ArrayKeys[$j])
                {
//                    echo "true<br>";
                    $ArrayWithOldValues[$i] = $_POST[$ArrayKeys[$j]];
                }
                if (($ArrayOfTitles[$i] == "CardPOL") && (($ArrayKeys[$j] == "CardPOL") || ($ArrayKeys[$j] != "CardPOL")) && ($_SESSION['CardPOL'] == "Checked"))
                {
                    if ($_POST['CardPOL'] == null)
                    {
                        $ArrayWithOldValues[$i] = "Δεν έχει κάρτα POL";
                    }
                    else
                    {
                        $ArrayWithOldValues[$i] = "Έχει κάρτα POL";
                    }
                }
//                else
//                {
//                    $ArrayWithOldValues[$i] = "Δεν έχει κάρτα POL";
//                }
                if (($ArrayOfTitles[$i] == "DriveLicense") && (($ArrayKeys[$j] == "DriveLicense") || ($ArrayKeys[$j] != "DriveLicense")) && ($_SESSION['DriveLicense'] == "No checked"))
                {
                    if ($_POST['DriveLicense'] == null)
                    {
                        $ArrayWithOldValues[$i] = "Δεν έχει άδεια οδήγησης";
                    }
                    else
                    {
                        $ArrayWithOldValues[$i] = "Έχει άδεια οδήγησης";
                    }
                }
//                else
//                {
//                    $ArrayWithOldValues[$i] = "Δεν έχει άδεια οδήγησης";
//                }
            }
        }
//        echo "<br><br><br>";
//        print_r($ArrayWithOldValues);






//        for ($i = 0; $i <= $LengthOfArrayKeys - 1; $i++)
//        {
//               $result = $con->prepare("SELECT Service FROM kataxorisiuser WHERE Name='$Name' AND Surname='$Surname'");
//               $r1 = $result->fetch();
//               $ChangeService = $r1['Service'];
//
//                $result = $con->prepare("SELECT branch FROM kataxorisiuser WHERE Name='$Name' AND Surname='$Surname'");
//                $r2 = $result->fetch();
//                $ChangeBranch = $r2['branch'];
//
//            $result = $con->prepare("SELECT $ArrayKeys[$i] FROM kataxorisiuser WHERE Name='$Name' AND Surname='$Surname'");
//            $r = $result->fetch();
//        echo $_POST[$ArrayKeys[$i]]."<br>";
//            $ArrayWithSelectTextOV[$i] = $r[$ArrayKeys[$i]];
//        }
//       $result = $con->prepare("SELECT * FROM kataxorisiuser WHERE Name='$Name' AND Surname='$Surname'");
//       $row = $result->fetch();
//       for ($i = 0; $i <= $IndexArrayOfTitles - 1; $i++)
//       {
//           $ArrayWithInfoOE[$i] = $row[$ArrayOfTitles[$i]];
//       }
//       echo "ArrayWithInfoOE Before: <br>";
//       print_r($ArrayWithInfoOE);
//       echo "<br><br>";

//       $i = 0;
//       $k = 0;
//       $LengthOfArrayWithInfoOE = count($ArrayWithInfoOE);
//       $LengthArrayWithSelectTextOV = count($ArrayWithSelectTextOV) - 1;
//       for($j = 0; $j <=28; $j++)
//       {
//           if ($i >= $LengthArrayWithSelectTextOV)
//           {
//               continue;
//           }
//           if ($ArrayWithSelectTextOV[$i] == $ArrayWithInfoOE[$j])
//           {
//               $i++;
//               $ArrayWithInfoOE[$j] = $_POST[$ArrayKeys[$k]];
//               if ($ArrayWithInfoOE[$j] == "CardPOL")
//               {
//                   $ArrayWithInfoOE[$j] = "Έχει κάρτα POL";
//               }
//               else if ($ArrayWithInfoOE[$j] == "DriveLicense")
//               {
//                   $ArrayWithInfoOE[$j] = "Έχει άδεια οδήγησης";
//               }
//               $k++;
//           }
//           else
//           {
//               continue;
//           }
//       }
//       echo "ArrayWithInfoOE After: <br>";
//       print_r($ArrayWithInfoOE);
////       echo "<br><br>";


       include 'CheckTextBoxes.php';
       $CTB = new CheckTextBoxes();
       if ($ArrayOfTitles[0] == "id")
       {
       $CTB->CheckTextBox($ArrayWithOldValues[1],
                          $ArrayWithOldValues[2],
                          $ArrayWithOldValues[3],
                          $ArrayWithOldValues[4],
                          $ArrayWithOldValues[5],
                          $ArrayWithOldValues[6],
                          $ArrayWithOldValues[7],
                          $ArrayWithOldValues[8],
                          $ArrayWithOldValues[9],
                          $ArrayWithOldValues[10],
                          $ArrayWithOldValues[11],
                          $ArrayWithOldValues[12],
                          $ArrayWithOldValues[13],
                          $ArrayWithOldValues[14],
                          $ArrayWithOldValues[15],
                          $ArrayWithOldValues[16],
                          $ArrayWithOldValues[17],
                          $ArrayWithOldValues[18],
                          $ArrayWithOldValues[19],
                          $ArrayWithOldValues[20],
                          $ArrayWithOldValues[21],
                          $ArrayWithOldValues[22],
                          $ArrayWithOldValues[23],
                          $ArrayWithOldValues[24]
                        );
       }

       if ($CTB->failed == true)
                        {
                            echo '<span style="color:red;text-align:center;">Αποτυχία αποθήκευσης!!Οι λόγοι που συνέβαλαν στην εμφάνιση του προβλήματος αυτό είναι οι εξής:</span>'."<br>"."<br>";
                            if ($CTB->AgeFailed == true)
                            {
                                echo '<span style="color:red;text-align:center;">Το πεδίο Ηλικία πρέπει να είναι από 18 έως 80</span>'."<br>";
                            }
                            if ($CTB->EmailFormFailed == true)
                            {
                                echo '<span style="color:red;text-align:center;">Το πεδίο Email πρέπει να έχει οπωσδήποτε ένα σύμβολο "@" και "."</span>'."<br>";
                            }
                            if ($CTB->NumberIdentificationEmployeeFailed == true)
                            {
                                echo '<span style="color:red;text-align:center;">Το πεδίο Αριθμό μητρώου εργαζομένου πρέπει να είναι 6 ψηφία</span>'."<br>";
                            }
                            if ($CTB->NumberIdentificationIKAFailed == true)
                            {
                                echo '<span style="color:red;text-align:center;">Το πεδίο Α.Μ ΙΚΑ πρέπει να είναι 7 ψηφία</span>'."<br>";
                            }
                            if ($CTB->AFMfailed == true)
                            {
                                echo '<span style="color:red;text-align:center;">Το πεδίο Α.Φ.Μ πρέπει να έχει μήκος 9</span>'."<br>";
                            }
                            if ($CTB->AMKAfailed == true)
                            {
                                echo '<span style="color:red;text-align:center;">Το πεδίο Α.Μ.Κ.Α πρέπει να έχει μήκος 11</span>'."<br>";
                            }
                            if($CTB->PoliceIdfailed == true)
                            {
                               echo '<span style="color:red;text-align:center;">Το πεδίο Αστυνομική ταυτότητα πρέπει να έχει μήκος 7 ή 8, εκτονοπίον το 1 ή τα 2 πρώτο/α ψηφία</span>'."<br>";
                            }
                            if ($CTB->PoliceIdLengthFailed == true)
                            {
                                echo '<span style="color:red;text-align:center;">Το πεδίο Αστυνομική ταυτότητα πρέπει να έχει μήκος 7 ή 8, εκτονοπίον το 1 ή τα 2 πρώτο/α ψηφία </span>'."<br>";
                            }
                            if ($CTB->PhoneFailed == true)
                            {
                                echo '<span style="color:red;text-align:center;">Το πεδίο Τηλέφωνο πρέπει να έχει μήκος 10</span>'."<br>";
                            }
                            if ($CTB->PhoneStirngFailed == true)
                            {
                                echo '<span style="color:red;text-align:center;">Το πεδίο Τηλέφωνο πρέπει να είναι συμβολοσειρά</span>'."<br>";
                            }
                            if ($CTB->EmailFailed == true)
                            {
                                echo '<span style="color:red;text-align:center;">Εισάγετε ένα έγκυρο email</span>'."<br>";
                            }
                            echo "<br>";
                            ?>
                            <button type="submit" name="GiveSomeFieldsToProcessingPage" id="GoGiveSomeFieldsToProcessingPage" onclick="window.location.href='GiveSomeFieldsToProcessing.php'">Επιστροφή</button>
                            <?php
                            die("<br /><strong><font size='4'>Η εφαρμογή δεν μπορεί να συνεχίσει την λειτουργία της λόγω των παραπάνω προβλημάτων που παρουσιάστηκαν!Παρακαλώ για την σωστή λειτουργία της εφαρμογής πατήσε το κουμπί 'Επιστροφή' ώστε να επαναλάβετε την διαδικασία επεξεργασιας στοιχείων</font></strong>");
                        }
//                        for ($i = 0; $i <= $IndexArrayOfTitles; $i++)
//                        {
//                            $Res = $con->prepare("UPDATE kataxorisiuser SET $ArrayOfTitles[$i] ='$ArrayWithOldValues[$i]' WHERE Name='$Name' AND Surname='$Surname'");
//                            $Res->execute();
//                        }
                        for ($i = 0; $i <= $LengthOfArrayKeys; $i++){
                            $prosorini = $_POST[$ArrayKeys[$i]];
                            $result = $con->prepare("Update kataxorisiuser Set $ArrayKeys[$i]='$prosorini' Where Surname='$Surname' AND Name='$Name'");
                            $result->execute();
                        }

                        if (($ExistService == true) || ($Existbranch == true))
                        {
//                            echo "ServiceThatUserEnter: ".$ServiceThatUserEnter."<br>BranchThatUserEnter: ".$BranchThatUserEnter."<br>";
                            $res = $con->prepare("SELECT id FROM services WHERE value=?",array($ServiceThatUserEnter));
                            $r = $res->fetch();
                            $IdOfServiceThatUsetEnter = (int)$r['id'];

                            $res = $con->prepare("SELECT services.value, select_service_table.value FROM services INNER JOIN select_service_table ON "
                                                                . "services.id=select_service_table.id AND services.id='$IdOfServiceThatUsetEnter';");
                            while($r3 = $res->fetch())
                            {
                                $TableOfServiceThatUserEnter = $r3['value'];
                                $res = $con->prepare("SELECT * from ".$TableOfServiceThatUserEnter." WHERE value='$BranchThatUserEnter'");
                                while($r4 = $res->fetch())
                                {
                                    $ValueOfBranchThatUserEnterEleutheresThesis = (int)$r4['eleutheres_thesis'];
                                    $ValueOfBranchThatUserEnterPiasmenesThesis = (int)$r4['piasmenes_thesis'];
                                    $ValueOfBranchThatUserEnterBranchSinolikesThesis = (int)$r4['sinolikes_thesis'];
                                }
                            }
//                            echo "Table of Servise that user enter: ".$IdOfServiceThatUsetEnter."<br>";
//                            echo "Service that user enter: ".$ServiceThatUserEnter."<br>Branch that must change: ".$BranchThatUserEnter."<br>";
//                            echo "Free position: ".$ValueOfBranchThatUserEnterEleutheresThesis."<br>";
//                            echo "Take position: ".$ValueOfBranchThatUserEnterPiasmenesThesis."<br>";
//                            echo "Sum position: ".$ValueOfBranchThatUserEnterBranchSinolikesThesis."<br>";

                            if (($OldValueOfChangeBranchPiasmenesThesis == $OldValueOfChangeBranchSinolikesThesis)
                                || ($ValueOfBranchThatUserEnterPiasmenesThesis == $ValueOfBranchThatUserEnterBranchSinolikesThesis))
                            {
                            die("<br /><strong><font size='4'>Η εφαρμογή δεν μπορεί να συνεχίσει την λειτουργία της λόγω του ότι δεν υπάρχουν διαθέσιμες θέσεις κλάδο που επιλέξατε"
                               ."!Παρακαλώ για την σωστή λειτουργία της εφαρμογής πατήσε το κουμπί 'Επιστροφή' ώστε να επαναλάβετε την διαδικασία επεξεργασιας "
                               ."στοιχείων</font></strong>");
                                ?>
//                                    <button type="submit" name="GiveSomeFieldsToProcessingPage" id="GoGiveSomeFieldsToProcessingPage" onclick="window.location.href='GiveSomeFieldsToProcessing.php'">Επιστροφή</button>
                                <?php
                            }
                            $OldValueOfChangeBranchEleutheresThesis = $OldValueOfChangeBranchEleutheresThesis + 1;
                            $OldValueOfChangeBranchPiasmenesThesis = $OldValueOfChangeBranchPiasmenesThesis - 1;

                            $ValueOfBranchThatUserEnterEleutheresThesis = $ValueOfBranchThatUserEnterEleutheresThesis - 1;
                            $ValueOfBranchThatUserEnterPiasmenesThesis = $ValueOfBranchThatUserEnterPiasmenesThesis + 1;

//                            echo "<br>";
//                            echo "After calculation: "."<br>";
//                            echo "Table of Servise that must change position: ".$TableOfChangeService."<br>";
//                            echo "Service that must change: ".$ChangeService."<br>Branch that must change: ".$ChangeBranch."<br>";
//                            echo "Free position: ".$OldValueOfChangeBranchEleutheresThesis."<br>";
//                            echo "Take position: ".$OldValueOfChangeBranchPiasmenesThesis."<br>";
//                            echo "Sum position: ".$OldValueOfChangeBranchSinolikesThesis."<br><br>";
//
//                            echo "After calculation: "."<br>";
//                            echo "Table of Servise that user enter: ".$TableOfServiceThatUserEnter."<br>";
//                            echo "Service that user enter: ".$ServiceThatUserEnter."<br>Branch that must change: ".$BranchThatUserEnter."<br>";
//                            echo "Free position: ".$ValueOfBranchThatUserEnterEleutheresThesis."<br>";
//                            echo "Take position: ".$ValueOfBranchThatUserEnterPiasmenesThesis."<br>";
//                            echo "Sum position: ".$ValueOfBranchThatUserEnterBranchSinolikesThesis."<br>";
//                            echo "<strong><font size='4'>Η επεξεργασία πληροφοριών έγιναν με επιτυχία!!</font></strong><br>";

                            $res = $con->prepare("Update $TableOfChangeService Set piasmenes_thesis=$OldValueOfChangeBranchPiasmenesThesis, eleutheres_thesis=$OldValueOfChangeBranchEleutheresThesis, sinolikes_thesis=$OldValueOfChangeBranchSinolikesThesis Where value='$ChangeBranch'");
                            $res->execute();
                            $res1 = $con->prepare("Update $TableOfServiceThatUserEnter Set piasmenes_thesis=$ValueOfBranchThatUserEnterPiasmenesThesis, eleutheres_thesis=$ValueOfBranchThatUserEnterEleutheresThesis, sinolikes_thesis=$ValueOfBranchThatUserEnterBranchSinolikesThesis Where value='$BranchThatUserEnter'");
                            $res1->execute();
                        }
                        $NameOfLogin = $_SESSION['NameOfLogin'];
                        $SurnameOfLogin = $_SESSION['SurnameOfLogin'];
                        $ProgrammThatUserClick = $_SESSION['ProgrammThatUserClick'];
                        $description ="Ο/Η χρήστης (ον) ".$_SESSION['NameOfLogin']." (επ) ".$_SESSION['SurnameOfLogin']." εκτέλεσε την λειτουργία ".
                                      $_SESSION['AntistoixoKoumpi']." του υπαλλήλου με (ον) ".$Name." και (επ) ".$Surname." με την οποία ζήτησε την αλλαγή των εξής πεδίων: ";

                            for ($i=0; $i<$_SESSION['MetablitiGiaTaPosaPediaAllaxtikan']; $i++)
                            {
                                $description = $description.$_SESSION['PediaGiaAllagi'.$i].", ";
                            }
                            $description = substr($description, 0, -2);
                            $description = $description.". H ".$_SESSION['AntistoixoKoumpi']." πραγματοποιήθηκε στις ".ConvertEnglishDaysAndMonthToGreek(date("l jS \of F Y"))." "
                                                       ."και ώρα ".date("h:i:s").". Ο χρήστης (ον) ".$NameOfLogin." (επ) ".$SurnameOfLogin." χαρακτηρίζεται ως ".CheckUser().".";
                            $res = $con->prepare("INSERT INTO history VALUES('$NameOfLogin', '$SurnameOfLogin', '$ProgrammThatUserClick','$description')");
                    ?>
                        <button type="submit" name="MainPage" id="MainPage" onclick="window.location.href='index.php'">Αρχική</button>
                    <?php
                    }

    function domain_exists($email, $record = 'MX')
                    {
                        list($user, $domain) = split('@', $email);
                        return checkdnsrr($domain, $record);
                    }
    function check_email_address($email)
                    {
                        // First, we check that there's one @ symbol, and that the lengths are right
                        if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email))
                        {
                            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
                            return false;
                        }
                        // Split it into sections to make life easier
                        $email_array = explode("@", $email);
                        $local_array = explode(".", $email_array[0]);
                        for ($i = 0; $i < sizeof($local_array); $i++)
                        {
                            if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i]))
                            {
                                return false;
                            }
                        }
                        if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1]))
                        {
                            // Check if domain is IP. If not, it should be valid domain name
                            $domain_array = explode(".", $email_array[1]);
                            if (sizeof($domain_array) < 2)
                            {
                                return false; // Not enough parts to domain
                            }
                            for ($i = 0; $i < sizeof($domain_array); $i++)
                            {
                                if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i]))
                                {
                                    return false;
                                }
                            }
                        }
                        return true;
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
?>
    </body>
</html>

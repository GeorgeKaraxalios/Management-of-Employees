<?php
    echo 'add Fields<br>';
    include './connector.php';
    session_start();
    
    //Εμφάνηση ώρα Ελλάδος
    date_default_timezone_set('Europe/Athens');
    $Connector = new Connector();
    
    $NumOfFieldsToAdd = 0;
    $NameOfLogin = $_SESSION['NameOfLogin'];
    $SurnameOfLogin = $_SESSION['SurnameOfLogin'];
    $ProgrammThatUserClick = $_SESSION['ProgrammThatUserClick'];
    $description = "Ο/Η χρήστης (ον) ".$_SESSION['NameOfLogin']." (επ) ".$_SESSION['SurnameOfLogin']." εκτέλεσε την λειτουργία "
                  ."".$_SESSION['AntistoixoKoumpi']." με την οποία πρόσθεσε "./*Αριθμός των πεδίων*/$NumOfFieldsToAdd." πεδία. . Η ".$_SESSION['AntistoixoKoumpi']." πραγματοποιήθηκε στις "
                  ."".ConvertEnglishDaysAndMonthToGreek(date("l jS \of F Y"))." και ώρα ".date("h:i:s").""
                  .". Ο χρήστης με (ον) ".$_SESSION['NameOfLogin']." και (επ) ".$_SESSION['SurnameOfLogin']." χαρακτιρίζεται ως ".CheckUser().".";
    $res = $Connector->prepare("INSERT INTO history VALUES('$NameOfLogin', '$SurnameOfLogin', '$ProgrammThatUserClick','$description')");
    
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

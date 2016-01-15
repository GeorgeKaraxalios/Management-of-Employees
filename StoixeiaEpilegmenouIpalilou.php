
        <?php
            include 'connector.php';
            //Εμφάνηση ώρα Ελλάδος
            date_default_timezone_set('Europe/Athens');
            $doc = null;
            $UploadFile = null;
            $NewFileUpload = null;
            $TeamBlood = null;
            $ServerName = null;
            session_start();
            $con = new Connector();
            
            
            $NameAndSurnameOfEmployee = array();
            $NameAndSurnameOfEmployee = explode(" ", $_SESSION['WhomEmployee']);
            $UploadFileArray = array();
            
            $res = $con->prepare("SELECT PathOfEmployeeImageToSave,PathOfEmployeeImageToShow FROM kataxorisiuser "
                                 ."WHERE Surname=? AND Name=?",array($NameAndSurnameOfEmployee[0],$NameAndSurnameOfEmployee[1]));
            while($row = $res->fetch())
            {
                $UploadFle = $row['PathOfEmployeeImageToSave'];
                $UploaddFileToShow = $row['PathOfEmployeeImageToShow'];
            }
            $TeamBlood = $_COOKIE["TeamBlood"]; 
            $ServerName = $_SERVER['SERVER_NAME'];
            
//            echo "Upload file = ".$UploadFile."<br>";
//            echo "http://$ServerName/Kataxorisis/$UploaddFileToShow"."<br>";
            
            $CheckIfIndex = 0;
            $IndexArrayOfTilesInGreek = 0;
            $IndexArrayOfTiles = 0;
            
            $ArrayOfTitles = array();
            $ArrayOfTitlesInGreek = array();
            
            $result = $con->prepare("SHOW COLUMNS FROM kataxorisiuser");
            while($r = $result->fetch())
            {
                $ArrayOfTitles[$IndexArrayOfTiles] = $r['Field'];
                $IndexArrayOfTiles++;
            }
            $result = $con->prepare("SELECT * FROM nameoftext");
            while($r = $result->fetch())
            {
                $ArrayOfTitlesInGreek[$IndexArrayOfTilesInGreek] = $r['Name'];
                $IndexArrayOfTilesInGreek++;
            }
            $ArrayOfTitles[0] = $NameAndSurnameOfEmployee[1];
            $ArrayOfTitles[1] = $NameAndSurnameOfEmployee[0];
            
//            echo "ArrayOfTitles array"."<br>";
//            print_r($ArrayOfTitles);
//            echo "<br>ArrayOfTitlesInGreek array<br>";
//            print_r($ArrayOfTitlesInGreek);
            $_SESSION["SurnameOfEmployee"] = $ArrayOfTitles[1];
            $_SESSION["NameOfEmployee"] = $ArrayOfTitles[0];
            
            $con = new Connector();
            $result = $con->prepare("SELECT * FROM kataxorisiuser WHERE Surname=? AND Name=?",array($ArrayOfTitles[1],$ArrayOfTitles[0]));
            
            $doc = "<html>"
                            ."<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
                              <link href=\"css/Table_Style.css\" rel=\"stylesheet\">
                              <link href=\"css/Input_Buttons.css\" rel=\"stylesheet\">"
                        ."<body>"
                            ."<table border='1' style='border-collapse: collapse'>"
                                ."<tr>"
                                    ."<th colspan='2'>"
                                        ."<font size='4'>Στοιχεία Υπαλλήλου</font>"
                                    ."</th>"
                                    ."<th>"
                                        ."<font size='4'>Φωτογραφία υπαλλήλου</font>"
                                    ."</th>"
                                ."</tr>"
                                ."<tr>"
                                    ."<td>"
                                        ."<strong>Επώνυμο</strong>"
                                    ."</td>"
                                    ."<td>"
                                        .$ArrayOfTitles[1]
                                    ."</td>"
                                    ."<td style='text-align:center; vertical-align:middle;' rowspan=".count($ArrayOfTitles).">"
                                        ."<img align='center' src='http://$ServerName/Kataxorisis/$UploaddFileToShow' width='132' height='174' style='display:inline-block;'/>"
                                    ."</td>"
                                ."</tr>"
                                ."<tr>"
                                    ."<td>"
                                        ."<strong>Όνoμα</strong>"
                                    ."</td>"
                                    ."<td>"
                                        .$ArrayOfTitles[0]
                                    ."</td>"
                                ."</tr>";
            
            while ($row1 = $result->fetch()) 
            {
                for ($i = 3; $i <= 25; $i++)
                {
                     $doc = $doc
                          ."<tr>"
                                ."<td>"
                                    ."<strong>".$ArrayOfTitlesInGreek[$CheckIfIndex]."</strong>"
                                ."</td>"
                                ."<td>"
                                    .$row1[$ArrayOfTitles[$i]]
                                ."</td>"
                          ."</tr>";
                $CheckIfIndex++;
                }
            }
            
            $doc = $doc."</table></body></html>";
            
            echo $doc;
            
            if(isset($_POST['PrintInfoOfEmployee']))
            {
//                header("Locaton: StoixeiaEpilegmenouIpalilouWithoutCSS.php");
//                header("Content-Type: application/vnd.msword charset='utf-8'");
//                header("Expires: 0");//no-cache
//                header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//no-cache
//                header("content-disposition: attachment;filename=".$_SESSION["SurnameOfEmployee"]." ".$_SESSION["NameOfEmployee"].".doc");
                echo "<script type='text/javascript'>window.location.href='StoixeiaEpilegmenouIpalilouWithoutCSS.php';</script>";
            }
            $NameOfLogin = $_SESSION['NameOfLogin'];
            $SurnameOfLogin = $_SESSION['SurnameOfLogin'];
            $ProgrammThatUserClick = $_SESSION['ProgrammThatUserClick'];
            $description = "Ο/Η χρήστης (ον) ".$_SESSION['NameOfLogin']." (επ) ".$_SESSION['SurnameOfLogin']." εκτέλεσε την λειτουργία "
                          ."".$_SESSION['AntistoixoKoumpi']." για τον υπάλληλο με (ον) ".$_SESSION["NameOfEmployee"]." και (επ) ".$_SESSION['SurnameOfEmployee'].""
                          .".Η ".$_SESSION['AntistoixoKoumpi']." του επιλεγμένου υπαλλήλου, πραγματοποιήθηκε στις ".ConvertEnglishDaysAndMonthToGreek(date("l jS \of F Y")).
                           " και ώρα ".date("h:i:s").". Ο χρήστης με (ον) ".$_SESSION['NameOfLogin']." και (επ) ".$_SESSION['SurnameOfLogin'].""
                          ." χαρακτιρίζεται ως ".CheckUser().".";
            $res = $con->prepare("INSERT INTO history VALUES('$NameOfLogin', '$SurnameOfLogin', '$ProgrammThatUserClick','$description')");
            
            if (isset($_POST['GoPrintIdPage']))
            {
                $_SESSION['Ektiposikartas'] = "Εκτύπωση κάρτας";
                header('Location: AddExternalInfo.php');
            }
            if (isset($_POST['GoMainPage']))
            {
                header('Location: index.php');
            }
            if (isset($_POST['GoAmazitisiProsopikouPage']))
            {
                header('Location: AmazitisiProsopikou.php');
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
            
            function ConvertEncoding($StringToConvert)
            {
//                echo mb_detect_encoding($StringToConvert)."<br>";
                if (mb_detect_encoding($StringToConvert) == "ASCII")
                {
                    $NewFileUploadToShow = $StringToConvert;
//                    echo "NewFileUpload Inside Function = ".$NewFileUploadToShow."<br>";
                    return $NewFileUploadToShow;
                }
                if (mb_detect_encoding($StringToConvert) == "UTF-8")
                {
                    //print_r(iconv_get_encoding("all"));
                    $NewFileUpload = iconv("utf-8", "iso-8859-7", $StringToConvert);
//                    echo "NewFileUpload Inside Function = ".$NewFileUpload."<br>";
                    return $NewFileUpload;
                }
            }
            ?>
            <br />
            <form name="proposal_form" class="form" action="StoixeiaEpilegmenouIpalilou.php" method="post">
                <input type="submit" name="GoAmazitisiProsopikouPage" id="GoAmazitisiProsopikouPage" value="Επιστροφή" />
                <input type="submit" name="GoMainPage" id="GoMainPage" value="Αρχική">
                <input type="submit" name="GoPrintIdPage" id="GoPrintIdPage" value="Εκτύπωση κάρτας υπαλλήλου"/>
                <input type="submit" name="PrintInfoOfEmployee" id="PrintInfoOfEmployee" value="Αποθήκευση στοιχείων υπαλλήλου"/>
            </form>

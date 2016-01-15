<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        <link rel="stylesheet" href="css/StyleWithoutForm.css">
    </head>
    <body>
        <?php
include 'connector.php';
//Εμφάνηση ώρα Ελλάδος
date_default_timezone_set('Europe/Athens');
session_start();
$con = new Connector();
$FilenameOfFilePng = null;
$date = null;
$newDate = null;
$SurnameOfEmployee = null;
$NameOfEmployee = null;
$NewBranch = null;
$TeamBlood = null;
$UploadFile = null;
$UploadFilePNG = null;
$NewFileUpload = null;
$DetectEncodeOfUploadFile = null;
$PathToSaveForegroundImage = null;
$PathToSaveBackgroundImage = null;
$UploadFileΤοToShow = null;
$LengthTeamBlood = 0;
    $SurnameOfEmployee = $_SESSION["SurnameOfEmployee"];
    $NameOfEmployee = $_SESSION["NameOfEmployee"];
    
//    echo "Surname Of Employee is: ".$SurnameOfEmployee."<br>Name Of Employee is: ".$NameOfEmployee."<br><br>";
    
$UploadFileSplit = array();
$UploadFileΤοToShowArray = array();

$res = $con->prepare("SELECT PathOfEmployeeImageToSave, PathOfEmployeeImageToShow FROM kataxorisiuser WHERE Surname='$SurnameOfEmployee' AND Name='$NameOfEmployee'");
$row = $res->fetch();
    $TeamBlood = $_SESSION['TeamBlood'];
    $UploadFile = $row['PathOfEmployeeImageToSave'];
    $TypeOfFile = $_SESSION['TypeOfFile'];
    $UploadFileΤοToShow = $row['PathOfEmployeeImageToShow'];
    
//    echo "UploadFile is: ".$UploadFile."<br>";
//    echo "UploadFile to show is: ".$UploadFileΤοToShow."<br>";
//    print_r($UploadFileSplit);
//    echo "<br>";
    //echo strlen($TeamBlood);
    $BranchArray = array();
//	echo $SurnameOfEmployee." ".$NameOfEmployee."<br>";
    
    $OmadaAimatosGrammaKaiSimbolo = array();
    if (mb_detect_encoding($TeamBlood) == 'UTF-8')
    {
        $LengthTeamBlood = mb_strlen($TeamBlood);
        if ($LengthTeamBlood == 0)
        {
            $OmadaAimatosGrammaKaiSimbolo[0] = "";
            $OmadaAimatosGrammaKaiSimbolo[1] = "";
        }
        else
        {
            $OmadaAimatosGrammaKaiSimbolo[0] = mb_strcut($TeamBlood,1,  mb_strlen($TeamBlood, 'utf-8'), 'utf-8');
            $OmadaAimatosGrammaKaiSimbolo[1] = mb_strcut($TeamBlood,2,  mb_strlen($TeamBlood, 'utf-8'), 'utf-8');
        }
        
    }
    else
    {
        $LengthTeamBlood = strlen($TeamBlood);
        if ($LengthTeamBlood == 0)
        {
            $OmadaAimatosGrammaKaiSimbolo[0] = "";
            $OmadaAimatosGrammaKaiSimbolo[1] = "";
        }
        else
        {
            $OmadaAimatosGrammaKaiSimbolo = str_split($TeamBlood);
        }
    }
    
//    echo "UploadFile = ".$UploadFile."<br>";
    $UploadFileSplit = explode('.',ConvertEncoding($UploadFile));
    $UploadFileΤοToShowArray = explode('.',$UploadFileΤοToShow);
    $PathToSaveForegroundImage = $UploadFileSplit[0]."-Foreground.png";
    $PathToSaveBackgroundImage = $UploadFileSplit[0]."-Background.png";
    $ImageForMergeDST = imagecreatefrompng("images/tautotita_politikou_prosopikou_ypy_frantzeskakis_page_0.png");
    
    $ΒlackColorM = imagecolorallocate($ImageForMergeDST, 0,0,0);
    $font = "font/verdana.ttf";
    $x = 650;
    
    $ImageForMergeSRC = imagecreatefrompng(ConvertEncoding($UploadFile));
    $ImageWidth = imagesx($ImageForMergeSRC);
    $ImageHeight = imagesy($ImageForMergeSRC);

    imagettftext($ImageForMergeDST, 30, 0, 690, 322, $ΒlackColorM, $font, date("d.m.Y"));
    //Destination x and y are axes of 'ImageForMergeDST' image that begins merging with second image
    //Source x and y are axes of 'ImageForMergeSRC' image that start merging with first image and stop mergin until x=374 and y=497, which are height and weight of resizable image 
    //The two last parameters are widht and height of begin image 
    //This function fisrt resize 'ImageForMergeSRC' into desire height and weight if size of first image 
    //dont match with the size second, for this example 375x498, and second copy second image on specific location on the first image
    imagecopyresized($ImageForMergeDST, $ImageForMergeSRC, /*dst x axes*/87, /*dst y axes*/237, /*src x axes*/0, /*src y axes*/0, 374, 497, $ImageWidth, $ImageHeight);
    imagepng($ImageForMergeDST,$PathToSaveForegroundImage);//Save png image(foregroun of political identity) to path stored in variable "PathToSaveForegroundImage"

    $BackImage = imagecreatefrompng("images/tautotita_politikou_prosopikou_ypy_frantzeskakis_page_1.png");
    $ΒlackColor = imagecolorallocate($BackImage, 0,0,0);
//	if ($BackImage)
//	{
//		echo "ReadImage<br>";
//	}
//	else
//	{
//		echo "No Read Image<br>";
//	}

////    echo "Surname of employee: ".$SurnameOfEmployee." and his name is: ".$NameOfEmployee."<br>";
//    echo "SELECT * FROM kataxorisiuser Where Surname='$SurnameOfEmployee' AND Name='$NameOfEmployee'"."<br>";

    $result = $con->prepare("SELECT * FROM kataxorisiuser WHERE Surname='$SurnameOfEmployee' AND Name='$NameOfEmployee'");
    while($row = $result->fetch())
    {
        $Branch = $row['branch'];
		imagettftext($BackImage, 31, 0, $x, 137, $ΒlackColor, $font, $SurnameOfEmployee);
        imagettftext($BackImage, 31, 0, $x, 200, $ΒlackColor, $font, $NameOfEmployee);
        imagettftext($BackImage, 31, 0, $x, 266, $ΒlackColor, $font, $row['NameOfFather']);
        if(strpos($Branch,' - ')!=null)
        {
            $BranchArray = explode(" - ", GreekStringToUppercase($Branch));
            $NewBranch = $BranchArray[0]."-".$BranchArray[1];
        }
	else
        {
            $BranchArray = explode(" ", GreekStringToUppercase($Branch));
            $NewBranch = $BranchArray[0]." ".$BranchArray[1];
        }
        if (mb_strlen($NewBranch, "utf-8") <= 17)
        {
            imagettftext($BackImage, 30, 0, $x, 329, $ΒlackColor, $font, mb_strtoupper($NewBranch,"utf-8"));
        }
        else
        {
            imagettftext($BackImage, 30, 0, 450, 329, $ΒlackColor, $font, mb_strtoupper($NewBranch,"utf-8"));
        }
        imagettftext($BackImage, 30, 0, $x, 394, $ΒlackColor, $font, $row['DayOfBorn']);
        imagettftext($BackImage, 30, 0, $x, 459, $ΒlackColor, $font, $row['id']);
        imagettftext($BackImage, 30, 0, $x, 524, $ΒlackColor, $font, $row['NumberIdentificationEmployee']);
        imagettftext($BackImage, 30, 0, $x, 587, $ΒlackColor, $font, $row['PoliceID']);
        imagettftext($BackImage, 30, 0, $x, 653, $ΒlackColor, $font, $OmadaAimatosGrammaKaiSimbolo[0]);
        imagettftext($BackImage, 20, 0, ($x + 25), 634, $ΒlackColor, $font, $OmadaAimatosGrammaKaiSimbolo[1]);
    }
    imagepng($BackImage,$PathToSaveBackgroundImage);//Save png image(background of political identity) to path stored in variable "PathToSaveBackgroundImage"

//function ConvertEncoding($StringToConvert)
//{
//    echo mb_detect_encoding($StringToConvert)."<br>";
//    if (mb_detect_encoding($StringToConvert) == "ASCII")
//    {
//        $NewFileUpload = $StringToConvert;
//        echo "NewFileUpload Inside Function = ".$NewFileUpload."<br>";
//        return $NewFileUpload;
//    }
//    if (mb_detect_encoding($StringToConvert) == "UTF-8")
//    {
//        //print_r(iconv_get_encoding("all"));
//        $NewFileUpload = iconv("utf-8", "iso-8859-7", $StringToConvert);
//        echo "NewFileUpload Inside Function = ".$NewFileUpload."<br>";
//        return $NewFileUpload;
//    }
//}
$_SESSION['SaveImageToDocForeground'] = "$PathToSaveForegroundImage";
$_SESSION['SaveImageToDocBackground'] = "$PathToSaveBackgroundImage";
$NameOfLogin = $_SESSION['NameOfLogin'];
$SurnameOfLogin = $_SESSION['SurnameOfLogin'];
$ProgrammThatUserClick = $_SESSION['ProgrammThatUserClick'];
$description = "Ο/Η χρήστης (ον) ".$_SESSION['NameOfLogin']." (επ) ".$_SESSION['SurnameOfLogin']." εκτέλεσε την λειτουργία "
              ."".$_SESSION['Ektiposikartas']." για τον υπάλληλο με (ον) ".$_SESSION["NameOfEmployee"]." και (επ) ".$_SESSION['SurnameOfEmployee'].""
              .".Η ".$_SESSION['Ektiposikartas']." του επιλεγμένου υπαλλήλου, πραγματοποιήθηκε στις ".ConvertEnglishDaysAndMonthToGreek(date("l jS \of F Y")).
               " και ώρα ".date("h:i:s").". Ο χρήστης με (ον) ".$_SESSION['NameOfLogin']." και (επ) ".$_SESSION['SurnameOfLogin'].""
              ." χαρακτιρίζεται ως ".CheckUser().".";
$res = $con->prepare("INSERT INTO history VALUES('$NameOfLogin', '$SurnameOfLogin', '$ProgrammThatUserClick','$description')");

function GreekStringToUppercase($string) 
    {
        $string = strtoupper($string);

        $letters = array('α', 'β', 'γ', 'δ', 'ε', 'ζ', 'η', 'θ', 'ι', 'κ', 'λ', 'μ', 'ν', 'ξ', 'ο', 'π', 'ρ', 'σ', 'τ', 'υ', 'φ', 'χ', 'ψ', 'ω');
        $letters_accent = array('ά', 'έ', 'ή', 'ί', 'ό', 'ύ', 'ώ');
        $letters_upper_accent = array('Ά', 'Έ', 'Ή', 'Ί', 'Ό', 'Ύ', 'Ώ');
        $letters_upper_solvents = array('ϊ', 'ϋ');
        $letters_other = array('ς');

        $letters_to_uppercase = array('Α', 'Β', 'Γ', 'Δ', 'Ε', 'Ζ', 'Η', 'Θ', 'Ι', 'Κ', 'Λ', 'Μ', 'Ν', 'Ξ', 'Ο', 'Π', 'Ρ', 'Σ', 'Τ', 'Υ', 'Φ', 'Χ', 'Ψ', 'Ω');
        $letters_accent_to_uppercase = array('Α', 'Ε', 'Η', 'Ι', 'Ο', 'Υ', 'Ω');
        $letters_upper_accent_to_uppercase = array('Α', 'Ε', 'Η', 'Ι', 'Ο', 'Υ', 'Ω');
        $letters_upper_solvents_to_uppercase = array('Ι', 'Υ');
        $letters_other_to_uppercase = array('Σ');

        $lowercase = array_merge($letters, $letters_accent, $letters_upper_accent, $letters_upper_solvents, $letters_other);
        $uppercase = array_merge($letters_to_uppercase, $letters_accent_to_uppercase, $letters_upper_accent_to_uppercase, $letters_upper_solvents_to_uppercase, $letters_other_to_uppercase);

        $uppecase_string = str_replace($lowercase, $uppercase, $string);

        return $uppecase_string;
    }
    
    function ConvertEncoding($StringToConvert)
        {
//            echo mb_detect_encoding($StringToConvert)."<br>";
            if (mb_detect_encoding($StringToConvert) == "ASCII")
            {
                $NewFileUpload = $StringToConvert;
//                echo "NewFileUpload Inside Function = ".$NewFileUpload."<br>";
                return $NewFileUpload;
            }
            if (mb_detect_encoding($StringToConvert) == "UTF-8")
            {
                //print_r(iconv_get_encoding("all"));
                $NewFileUpload = iconv("utf-8", "iso-8859-7", $StringToConvert);
//                echo "NewFileUpload Inside Function = ".$NewFileUpload."<br>";
                return $NewFileUpload;
            }
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
?>
        <table border="1" align="center">
            <tr>
                <td align="center">
                    <h3>Προστινή όψη Ταυτότητας πρωσοπικού</h3>
                </td>
                <td align="center">
                    <h3>Οπίσθια όψη Ταυτότητας πρωσοπικού</h3>
                </td>
            </tr>
            <tr>
                <td>
                    <img src="<?php echo $UploadFileΤοToShowArray[0]; ?>-Foreground.png" width="363" height="242"/><br />
                </td>
                <td>
                    <img src="<?php echo $UploadFileΤοToShowArray[0]; ?>-Background.png" width="363" height="242"/><br />
                </td>
            <tr>
        </table>
        <br />
        <div align="center">
            <input type="submit" name="SaveImage" onclick="window.location.href = 'SaveImageToDoc.php'" value="Αποθήκευση εικόνας">
            <input type="submit" name="GoMainPage" onclick="window.location.href = 'index.php'" value="Αρχική">
            <input type="submit" name="GoToMenuPage" onclick="window.location.href = 'LoginSystem/Menu.php'" value="Έξοδος">
        </div>
    </body>
</html>


<?php
    include './CheckForLogin/Check.php';
?>
<html>
    <head>
        <title></title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />

        <script type="text/javascript" src="js/jquery.js"></script>
        <script type='text/javascript' src='js/jquery.autocomplete.js'></script>
        <link rel="stylesheet" type="text/css" href="css/jquery.autocomplete.css" />
        <link href="css/CssAnazitisiProsopikou.css" rel="stylesheet">
    </head>
    <body>
        <script type="text/javascript">
//            function configurator()
//            {
//                var x = document.getElementById("SurnameOfEmployeeText").value;
//                document.cookie="WhomEmployee="+x;
//                var UploadFile = document.getElementById('file').value;
//                document.cookie="UploadFile="+UploadFile;
//                var TeamBlood = document.getElementById('TeamBloodText').value;
//                alert(TeamBlood);
//                document.cookie="TeamBlood="+TeamBlood;
//                window.location.href = 'StoixeiaEpilegmenouIpalilou.php';
//            }
            function CheckIfImageExist(element)
            {
                var x = element.value;
                var x1 = x.split(" ");
                alert(x1);
            }
            
            $(function()
            {
            $('#UploadImageYesOrNo').click(function() 
            {
                if($(this).is(':checked'))
                {
                    $('#Upload').hide();
                    $('#file').hide();
                    $.ajax({
                        url: 'HideElement.php',
                        type: 'post',
                        success: function(){}                       
                    });
                }
                            
                else
                {
                    $('#Upload').show();
                    $('#file').show();
                }
            });
                $("#SurnameOfEmployeeText").autocomplete("get_course_list.php",
                {
                    width: 260,
                    matchContains: true,
                    selectFirst: false
                });
            });
        </script>
        <form name="AnazitisiProsopikou" action="AmazitisiProsopikou.php" method="post" class="form" enctype="multipart/form-data">
            <div id="main">
            <div id="first">
            <table>
                <tr>
                    <td>
                        <label  id="SurnameOfEmployee" name="SurnameOfEmployee"><strong>Δώσε τo επίθετο του υπαλήλου για αναζήτηση</strong></label>
                    </td>
                    <td>
                        <input class="typetext" type="text" id="SurnameOfEmployeeText" name="SurnameOfEmployeeText" onselect="CheckIfImageExist(this);">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label name="TeamBloodLabel" id="TeamBloodLabel"><strong>Ομάδα αίματος</strong></label>
                    </td>
                    <td>
                        <input class="typetext" type="text" name="TeamBloodText" id="TeamBloodText">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="checkbox" id="UploadImageYesOrNo" name="UploadImageYesOrNo" value="UploadImageYesOrNo">
                        <label for="UploadImageYesOrNo">Ανέβασμα εικόνας</label>
                    <td>
                </tr>
                <tr>
                    <td>
                        <label for="file" name="Upload" id="Upload"><strong>Filename:</strong></label>
                    </td>
                    <td>
                        <input type="file" name="file" id="file">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="SubmitAnazitisiYpalilou" id="SubmitAnazitisiYpalilou" value="Εμφάνιση στοιχείων υπαλλήλου">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="SubmitReloadPage" id="SubmitReloadPage" value="Επαναφόρτωση σελίδας">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="SubmitGoMainPage" id="SubmitGoMainPage" value="Αρχική">
                    </td>
                </tr>
            </table>
            </div>
            </div>
            </form>

        <?php
            include 'connector.php';
            $temp = array();
            $SurnameOfEmployeeArray = array();
            $CreateFileName = null;
            $UploadFile = null;
            $UploadFileΤοToShow = null;
            $RelativePathToSaveImage = null;
            $NameForFolderOfEmployee = null;
            $_SESSION['Hide'] = 0;
            $con = new Connector();
            if (isset($_POST['SubmitReloadPage']))
            {
                echo "<script>window.location.href = 'AmazitisiProsopikou.php'</script>";
            }
            if (isset($_POST['SubmitGoMainPage']))
            {
                echo "<script>window.location.href = 'index.php'</script>";
            }
        if (isset($_POST["SubmitAnazitisiYpalilou"]))
        {
            
            session_start();
//            echo "Hide: ". $_SESSION['Hide']."<br>";
            print_r($_FILES);
            $_SESSION['WhomEmployee'] = $_POST['SurnameOfEmployeeText'];
            $SurnameOfEmployeeArray = explode(" ", $_POST['SurnameOfEmployeeText']);
//            echo $SurnameOfEmployeeArray[0]."s";
//            echo "<br>";
//            echo $SurnameOfEmployeeArray[1]."s";
//            echo "<br>";
            $_SESSION['TeamBlood'] = $_POST['TeamBloodText'];
            $_SESSION['TypeOfFile'] = $_FILES['file']['type'];
            $allowedExts = array("gif", "jpeg", "jpg", "png");
            $temp = explode(".", $_FILES['file']['name']);
            $extension = end($temp);
            
            if ($_SESSION['Hide'] == 1)
            {
                echo "<script>window.location.href = 'StoixeiaEpilegmenouIpalilou.php'</script>";
            }
            
            if ((($_FILES['file']['type'] == "image/gif")
            || ($_FILES['file']['type'] == "image/jpeg")
            || ($_FILES['file']['type'] == "image/jpg")
            || ($_FILES['file']['type'] == "image/pjpeg")
            || ($_FILES['file']['type'] == "image/x-png")
            || ($_FILES['file']['type'] == "image/png"))
            && in_array($extension, $allowedExts))
            {
                
                $NameForFolderOfEmployee = iconv(mb_detect_encoding($_POST['SurnameOfEmployeeText']), "iso-8859-7", $_POST['SurnameOfEmployeeText']);
                if (!file_exists("images/".$NameForFolderOfEmployee))
                {
                    mkdir("images/".$NameForFolderOfEmployee);
                }
                else
                {
                    
                }
                
                if (strtoupper($extension))
                {
                    $extension = strtolower($extension);
                    $CreateFileName = ConvertEncoding($temp[0]).".".$extension;
                }
                else
                {
                    $CreateFileName = ConvertEncoding($temp[0]).".".$extension;
                }
                $RelativePathToSaveImage = "images/".$NameForFolderOfEmployee."/";
                if ($_FILES['file']['type'] != "image/png")
                {
                    if (file_exists($RelativePathToSaveImage.$CreateFileName))
                    {
                        echo '<span style="color:red;text-align:center;">Το αρχείο που προσπαθείτε να ανεβάσετε υπάρχει ήδη στον φάκελο images </span>'."<br>";
                        die();
                        exit;
                    }
                    move_uploaded_file($_FILES['file']['tmp_name'],$RelativePathToSaveImage.$CreateFileName);
                    imagepng(imagecreatefromstring(file_get_contents($RelativePathToSaveImage.$CreateFileName)), $RelativePathToSaveImage.ConvertEncoding($temp[0]).".png");

                    //$_SESSION['UploadFile'] = $RelativePathToSaveImage.ConvertEncoding($temp[0]).".png";
                    $UploadFile = $RelativePathToSaveImage.ConvertEncoding($temp[0]).".png";

                    $UploadFileToShow = str_replace(' ', '%20', "images/".$_POST['SurnameOfEmployeeText']."/".$_FILES['file']['name']);
//                    echo str_replace(' ', '%20', "images/".$_POST['SurnameOfEmployeeText']."/".$_FILES['file']['name']);

                    $UploadFileΤοToShow = $RelativePathToSaveImage.$_FILES['file']['name'];
//                    echo $UploadFile."<br>";
                    $res = $con->prepare("UPDATE kataxorisiuser SET PathOfEmployeeImageToSave=?, UploadImageTF=?,"
                                        ." PathOfEmployeeImageToShow=? "
                                        ."WHERE Surname=? AND Name=?",array("images/".$_POST['SurnameOfEmployeeText']."/".$temp[0].".png", 'true', $UploadFileToShow, $SurnameOfEmployeeArray[0], $SurnameOfEmployeeArray[1]));
                }

                else
                {
                    if (file_exists($RelativePathToSaveImage.$CreateFileName))
                    {
                        echo '<span style="color:red;text-align:center;">Το αρχείο που προσπαθείτε να ανεβάσετε υπάρχει ήδη στον φάκελο images </span>'."<br>";
                        exit;
                    }
                    move_uploaded_file($_FILES['file']['tmp_name'],$RelativePathToSaveImage.$CreateFileName);
                    //$_SESSION['UploadFile'] =$RelativePathToSaveImage.ConvertEncoding($temp[0]).".png";
                    $UploadFile = $RelativePathToSaveImage.$CreateFileName;
                    $UploadFileToShow = str_replace(' ', '%20', "images/".$_POST['SurnameOfEmployeeText']."/".$_FILES['file']['name']);
//                    echo str_replace(' ', '%20', "images/".$_POST['SurnameOfEmployeeText']."/".$_FILES['file']['name'])."<br>";
                    $UploadFileΤοToShow = $RelativePathToSaveImage.$_FILES['file']['name'];
//                    echo $UploadFile."<br>";
                    $res = $con->prepare("UPDATE kataxorisiuser SET PathOfEmployeeImageToSave=?, UploadImageTF=?,"
                                        ." PathOfEmployeeImageToShow=? "
                                        ."WHERE Surname=? AND Name=?",array("images/".$_POST['SurnameOfEmployeeText']."/".$temp[0].".png", 'true', $UploadFileToShow, $SurnameOfEmployeeArray[0], $SurnameOfEmployeeArray[1]));
                    if ($res)
                            {
                                echo "<strong><font size='4'>Επιτυχής καταχώρηση υπαλλήλου!!</font></strong>"."<br>";   
                            }
                            else
                            {
                                echo "<strong><font size='4'>Παρουσιάστηκε πρόβλημα με την καταχώρηση υπαλλήλου!!Παρακαλώ επικοινωνίστε με τον διαχειριστή για επίλυση του προβλήματος</font></strong>"."<br>";

                            }
                }
                
                
            }
            else
            {
                echo '<span style="color:red;text-align:center;">Ο τύπος αρχείου που ανεβάσετε δεν είναι ο επιθυμητός!Παρακαλώ ανεβάστε αρχείου τύπου εικόνας</span>'."<br>";
            }
            echo "<script>window.location.href = 'StoixeiaEpilegmenouIpalilou.php'</script>";
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
        ?>
    </body>
</html>

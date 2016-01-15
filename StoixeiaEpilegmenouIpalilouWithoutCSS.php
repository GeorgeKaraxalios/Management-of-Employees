<?php
include 'connector.php';
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
                            ."<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">"
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
            header("Content-Type: application/vnd.msword charset='utf-8'");
            header("Expires: 0");//no-cache
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//no-cache
            header("content-disposition: attachment;filename=".$_SESSION["SurnameOfEmployee"]." ".$_SESSION["NameOfEmployee"].".doc");
//            echo "<script type='text/javascript'>window.location.href='StoixeiaEpilegmenouIpalilou.php';</script>";
?>

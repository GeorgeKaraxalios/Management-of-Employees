<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=utf-8" />
        
        <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.js"></script>
    <link href="css/Form_Style.css" rel="stylesheet">
    <script type="text/javascript">
    $(document).ready(function()
    {
        $ServiceSelection = $("select[name='Service']");
        $NodeSelection = $("select[name='branch']");

        $ServiceSelection.change(function()
        {
            var id=$(this).val();
            var dataString = 'value='+ id;
            $.ajax
            ({
                type: "POST",
                url: "foo.php",
                data: dataString,
                cache: false,
                success: function(html)
                {
                    $NodeSelection.html(html);
                } 
             });
        });
        
        $("#DayOfBorn ").datepicker(
        {
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            yearRange: '1930:2099'
        });
        $("#DateOfUptake ").datepicker(
        {
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            yearRange: '1930:2099'
        });
    
        
    });
    </script>
    </head>
    <body>
        <?php
        session_start();
        include 'connector.php';
        $con = new Connector();
        $count = 1;
        $i = 0;
        $SurnameAndName = array();
        $SurnameAndName = explode(" ", $_POST['SurnameOfEmployeeText']);
        $_SESSION['SurnameOE'] = $SurnameAndName[0];
        $_SESSION['NameOE'] = $SurnameAndName[1];
        $SplitSelected = array();
        if(isset($_POST['submit']))
        {
            //to run PHP script on submit
            if(!empty($_POST['check_list']))
            {
                ?>
                <form action="UpdateInfo.php" class="form" method="post">
                    <div id="main">
                        <div id="first">
                            <table>
                            <?php
                            // Loop to store and display values of individual checked checkbox.
                            foreach($_POST['check_list'] as $selected)
                            {
                //                    echo $selected."</br>";
                                $SplitSelected = explode("_", $selected);
                                $_SESSION['PediaGiaAllagi'.$i] = $SplitSelected[1];
                                $i++;
//                                echo $SplitSelected[0]."<br>";
                                if ($SplitSelected[0] == "Situation")
                                {
                                    ?>
                                    <tr>
                                        <td>
                                            <label  id="Κατάσταση" name="Κατάσταση"><strong>Κατάσταση</strong></label>
                                        </td>
                                        <td>
                                            <select name="Situation" id="Situation">
                                                <?php
                                                $res = $con->prepare("SELECT * FROM selection_option");
                                                while ($r = $res->fetch())
                                                {
                                                    if ($r['Situation'] == "null")
                                                    {
                                                        continue;
                                                    }
                                                ?>
                                                        <option value="<?php echo $r['Situation']; ?>"><?php echo $r['Situation']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                else if ($SplitSelected[0] == "EmploymentRelationship")
                                {
                                    ?>
                                    <tr>
                                        <td>
                                            <label  id="Σχέση εργασίας" name="Σχέση εργασίας"><strong>Σχέση εργασίας</strong></label>
                                        </td>
                                        <td>
                                            <select name="EmploymentRelationship" id="EmploymentRelationship">
                                                <?php
                                                $res = $con->prepare("SELECT * FROM selection_option");
                                                while ($r = $res->fetch())
                                                {
                                                    if ($r['EmploymentRelationship'] == "null")
                                                    {
                                                        continue;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $r['EmploymentRelationship']; ?>"><?php echo $r['EmploymentRelationship']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                else if ((($SplitSelected[0] == "Service") || ($SplitSelected[0] == "branch")) && ($count == 1))
                                {
                                    $count++;
                                    ?>
                                    <tr>
                                        <td>
                                            <label  id="Υπηρεσία" name="Υπηρεσία"><strong>Υπηρεσία</strong></label>
                                        </td>
                                        <td>
                                            <select name="Service" id="Service">
                                                <?php
                                                $res = $con->prepare("SELECT * FROM selection_option");
                                                while ($r = $res->fetch())
                                                {                                           
                                                    if ($r['ServiceSelection'] == "null")
                                                    {
                                                        continue;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $r['ServiceSelection']; ?>"><?php echo $r['ServiceSelection']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <label  id="Κλάδος" name="Κλάδος"><strong>Κλάδος - Ειδικότητα</strong></label>
                                        </td>
                                        <td>
                                            <select name="branch" id="branch">
                                                <?php
                                                $res = $con->prepare("SELECT Service FROM kataxorisiuser WHERE Name='$SurnameAndName[1]' AND Surname='$SurnameAndName[0]'");
                                                $r = $res->fetch();
                                                $ServiceOE = $r['Service'];

                                                $res = $con->prepare("SELECT id FROM services WHERE value=?",array($ServiceOE));
                                                $r1 = $res->fetch();
                                                $IdOfServiceOE = (int)$r1['id'];

                                                $res = $con->prepare("SELECT services.value, select_service_table.value FROM services INNER JOIN select_service_table ON services.id=select_service_table.id AND services.id='$IdOfServiceOE';");
                                                while($r2 = $res->fetch())
                                                {
                                                    $res = $con->prepare("SELECT * from ".$r2['value']);
                                                    while($r3 = $res->fetch())
                                                    {
                                                        ?>
                                                        <option value="<?php echo $r3['value']; ?>"><?php echo $r3['value']; ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                 else if ($SplitSelected[0] == "Section")
                                {
                                    ?>
                                    <tr>
                                        <td>
                                            <label  id="Τμήμα" name="Τμήμα"><strong>Τμήμα</strong></label>
                                        </td>
                                        <td>
                                            <select name="Section" id="Section">
                                                <?php
                                                $res = $con->prepare("SELECT * FROM selection_option");
                                                while ($r = $res->fetch())
                                                {
                                                    if ($r['Section'] == "null")
                                                    {
                                                        continue;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $r['Section']; ?>"><?php echo $r['Section']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                 else if ($SplitSelected[0] == "Grade")
                                {
                                    ?>
                                    <tr>
                                        <td>
                                            <label  id="Βαθμός" name="Βαθμός"><strong>Βαθμός</strong></label>
                                        </td>
                                        <td>
                                            <select name="GradeSelection" id="GradeSelection">
                                                <?php
                                                $res = $con->prepare("SELECT * FROM selection_option");
                                                while ($r = $res->fetch())
                                                {
                                                    if ($r['GradeSelection'] == "null")
                                                    {
                                                        continue;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $r['GradeSelection']; ?>"><?php echo $r['GradeSelection']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                 else if ($SplitSelected[0] == "MK")
                                {
                                    ?>
                                    <tr>
                                        <td>
                                            <label id="Μ.Κ" name="Μ.Κ"><strong>Μ.Κ</strong></label>
                                        </td>
                                        <td>
                                            <select name="MK" id="MK">
                                                <?php
                                                $res = $con->prepare("SELECT * FROM selection_option");
                                                while ($r = $res->fetch())
                                                {
                                                    if ($r['MK'] == "null")
                                                    {
                                                        continue;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $r['MK']; ?>"><?php echo $r['MK']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                else if ($SplitSelected[0] == "Specialty")
                                {
                                    ?>
                                    <tr>
                                        <td>
                                            <label id="SpecialtyLabel" name="SpecialtyLabel"><strong>Κατηγορία</strong></label>
                                        </td>
                                        <td>
                                            <select name="Specialty" id="Specialty">
                                                <?php
                                                $res = $con->prepare("SELECT * FROM selection_option");
                                                while ($r = $res->fetch())
                                                {
                                                    if ($r['Specialty'] == "null")
                                                    {
                                                        continue;
                                                    }
                                                    ?>
                                                    <option value="<?php echo $r['Specialty']; ?>"><?php echo $r['Specialty']; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                else
                                {
                                    ?>
                                        <tr>
                                            <td>
                                                <label  id="<?php echo $SplitSelected[0]."_Label"; ?>" name="<?php echo $SplitSelected[0]."_Label"; ?>"><strong><?php echo $SplitSelected[1]; ?></strong></label> 
                                            </td>
                                            <td>
                                                <?php
                                                if ($SplitSelected[0] == "CardPOL")
                                                {
                                                    $_SESSION['CardPOL'] = "Checked";
                                                    $_SESSION['DriveLicense'] = "No checked";
                                                    ?>
                                                    <input type="checkbox" id="CardPOL" name="CardPOL" value="Έχει κάρτα POL">
                                                    <label for="CardPOL">Κάρτα POL</label>
                                                    <?php
                                                }
                                                else if ($SplitSelected[0] == "DriveLicense")
                                                {
                                                    $_SESSION['CardPOL'] = "No checked";
                                                    $_SESSION['DriveLicense'] = "Checked";
                                                    ?>
                                                    <input type="checkbox" id="DriveLicense" name="DriveLicense" value="Έχει άδεια οδήγησης">
                                                    <label for="DriveLicense">Άδεια οδήγησης οχήματος</label>
                                                    <?php
                                                }
                                                else
                                                {
                                                    $_SESSION['CardPOL'] = "No checked";
                                                    $_SESSION['DriveLicense'] = "No checked";
                                                    ?>
                                                    <input id="<?php echo $SplitSelected[0]; ?>" name="<?php echo $SplitSelected[0]; ?>">
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php
                                }
                            }
                            $_SESSION['MetablitiGiaTaPosaPediaAllaxtikan'] = $i;
                            ?>
                            </table>
                    <input type="submit" name="submit" value="Ενημέρωση στοιχείων"/><br />
                    <input type="submit" name="submitGiveSomeFieldsToProcessingPage" value="Επιστροφή"/>
                    </div>
                    </div>
                </form>
                    
                <?php
            }
        }
        ?>
    </body>
</html>

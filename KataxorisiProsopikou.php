<?php
    include './CheckForLogin/Check.php';
    //Εμφάνηση ώρα Ελλάδος
    date_default_timezone_set('Europe/Athens');
?>
<html>
<head>
    <meta charset="UTF-8">
    
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <link rel="stylesheet" href="css/jquery-ui.css">
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/jquery-ui.js"></script>
    <link href="css/Form_Style.css" rel="stylesheet">
    <link href="css/StyleButtonTags.css" rel="stylesheet">
    <script type="text/javascript">
    $(document).ready(function()
    {
        $ServiceSelection = $("select[name='ServiceSelection']");
        $NodeSelection = $("select[name='NodeSelection']");

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
        
        $("#DateOfBornΤext").datepicker(
        {
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd/mm/yy',
            yearRange: '1930:2099'
        });
        
        $("#DateOfUptakeText").datepicker(
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
            <form id="form1" name="form1" class="form" action="KataxorisiProsopikou.php" method="post" >
                <div id="main">
                <div id="first">
                <table>
                        <td colspan="4">
                            <h2>
                                    Καταχώρηση
                            </h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div>
                                <label  id="NameLabel" name="NameLabel"><strong>Όνομα</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" id="NameText" name="NameText" required>
                            </div>
                        </td>
                        <td>
                            <div>
                                <label id="PhoneLabel" name="PhoneLabel"><strong>Τηλέφωνο</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" name="PhoneΤext" id="PhoneΤext">
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div>
                                <label  id="SurNameLabel" name="SurNameLabel"><strong>Επώνυμο</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" name="SurNameText" id="SurNameText" required>
                            </div>
                        </td>
                        <td>
                            <div>
                                <label  id="EMAILLabel" name="EMAILLabel"><strong>Προσωπικό E-mail</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" name="EMAIL" id="EMAIL">
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div>
                                <label  id="NameOfFatherLabel" name="NameOfFatherLabel"><strong>Πατρώνυμο</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" name="NameOfFatherΤext" id="NameOfFatherΤext" required>
                            </div>
                        </td>
                        <td>
                            <div>
                                <label  id="SituationLabel" name="SituationLabel"><strong>Κατάσταση</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <select name="SituationSelection" form="form1" id="SituationSelection">
                                    <option value="Μετάταξη">Μετάταξη</option>
                                    <option value="Απόσπαση">Απόσπαση</option>
                                    <option value="Πρακτική άσκηση">Πρακτική άσκηση</option>
                                    <option value="Διορισμός">Διορισμός</option>
                                    <option value="Άλλο">Άλλο</option>
				</select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div>
                                <label  id="MothersNameLabel" name="MothersNameLabel"><strong>Μητρώνυμο</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" name="MothersNameΤext" id="MothersNameΤext">
                            </div>
                        </td>
                        <td>
                            <div>
                                <label id="ServiceLabel" name="ServiceLabel"><strong>Υπηρεσία</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <select name="ServiceSelection" class="SituationSelection" form="form1" id="ServiceSelection">
                                    <option value="Κεντρική Υπηρεσία">Κεντρική Υπηρεσία</option>
                                    <option value="ΚΕΠΥ Φυλακίου">ΚΕΠΥ Φυλακίου</option>
                                    <option value="ΚΕΠΥ Λέσβου">ΚΕΠΥ Λέσβου</option>
                                    <option value="Κινητή Μονάδα Α΄">Κινητή Μονάδα Α΄</option>
                                    <option value="Κινητή Μονάδα Β΄">Κινητή Μονάδα Β΄</option>
                                    <option value="Τίποτα">Τίποτα</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div>
                                <label id="DateLabel" name="DateLabel"><strong>Ημερομηνία Γέννησης</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" id="DateOfBornΤext" name="DateOfBornΤext" required>
                            </div>
                        </td>
                        <!--Prepei na paei --> 
                       <td>
                            <div>
                                <label id="SpecialtyLabel" name="SpecialtyLabel"><strong>Κατηγορία</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <select name="SpecialtyΤext" form="form1" id="SpecialtyΤext">
                                    <option value="ΠΕ">ΠΕ</option>
                                    <option value="ΤΕ">ΤΕ</option>
                                    <option value="ΔΕ">ΔΕ</option>
                                    <option value="Τίποτα">Τίποτα</option>
				</select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div>
                                <label id="PoliceIDLabel" name="PoliceIDLabel"><strong>Αστυνομική ταυτότητα</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" name="PoliceIDΤext" id="PoliceIDΤext" required>
                            </div>
                        </td>
                        <td>
                            <div>
                                <label id="NodeLabel" name="NodeLabel"><strong>Κλάδος - Ειδικότητα</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <select class="NodeSelection" name="NodeSelection" form="form1" id="NodeSelection">
                                    <option value="ΠΕ Διοικητικού - Οικονομικού">ΠΕ Διοικητικού - Οικονομικού</option>
                                    <option value="ΠΕ Πληροφορικής">ΠΕ Πληροφορικής</option>
                                    <option value="ΠΕ Επικοινωνίας & ΜΜΕ">ΠΕ Επικοινωνίας & ΜΜΕ</option>
                                    <option value="ΠΕ Ψυχολογίας">ΠΕ Ψυχολογίας</option>
                                    <option value="ΠΕ Νομικής">ΠΕ Νομικής</option>
                                    <option value="ΤΕ Πληροφορικής">ΤΕ Πληροφορικής</option>
                                    <option value="ΠΕ Κοινωνιολογίας">ΠΕ Κοινωνιολογίας</option>
                                    <option value="ΤΕ Κοινωνικών Λειτουργών">ΤΕ Κοινωνικών Λειτουργών</option>
                                    <option value="ΤΕ Διοικητικού Λογιστικού">ΤΕ Διοικητικού Λογιστικού</option>
                                    <option value="ΔΕ Διοικητικού Λογιστικού">ΔΕ Διοικητικού Λογιστικού</option>
                                    <option value="ΔΕ Οδηγών">ΔΕ Οδηγών</option>
                                    <option value="ΠΕ Ευρωπαϊκών & Διεθνών Σπουδών">ΠΕ Ευρωπαϊκών & Διεθνών Σπουδών</option>
                                    <option value="Ειδικό Επιστημονικό Προσωπικό">Ειδικό Επιστημονικό Προσωπικό</option>
                                    <option value="Τίποτα">Τίποτα</option>
				</select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div>
                                <label id="AFMLabel" name="AFMLabel"><strong>Α.Φ.Μ</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" name="AFMΤext" id="AFMΤext" required>
                            </div>
                        </td>
                        <td>
                            <div>
                               <label id="GradeLabel" name="GradeLabel"><strong>Βαθμός</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <select name="GradeSelection" form="form1" id="GradeSelection">
                                    <option value="Α">Α</option>
                                    <option value="Β">Β</option>
                                    <option value="Γ">Γ</option>
                                    <option value="Δ">Δ</option>
                                    <option value="Ε">Ε</option>
                                    <option value="ΣΤ">ΣΤ</option>
                                    <option value="Τίποτα">Τίποτα</option>
				</select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div>
                               <label id="AMKALabel" name="AMKALabel"><strong>Α.Μ.K.Α</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" name="AMKAΤext" id="AMKAΤext">
                            </div>
                        </td>
                        <td>
                            <div>
                               <label id="MKLabel" name="MKLabel"><strong>M.K</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <select name="NumsFor0To6" form="form1" id="NumsFor0To6">
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="Τίποτα">Τίποτα</option>
				</select>
                            </div>
                        </td>
                    </tr>
                                       
                    <tr>
                        <td>
                            <div>
                               <label id="AgeLabel" name="AgeLabel"><strong>Ηλικία</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" name="AgeText" id="AgeText">
                            </div>
                        </td>
                        <td>
                            <div>
                               <label id="AddressLabel" name="AddressLabel"><strong>Διεύθυνση κατοικίας</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" name="AddressText" id="AddressText">
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div>
                                <label  id="RelationshipOfWorkLabel" name="RelationshipOfWorkLabel"><strong>Σχεση εργασίας</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <select name="RelationshipOfWorkSelection" form="form1" id="RelationshipOfWorkSelection">
                                    <option value="Μόνιμος">Μόνιμος</option>
                                    <option value="ΙΔΑΧ">ΙΔΑΧ</option>
                                    <option value="Εκπαιδευόμενος">Εκπαιδευόμενος</option>
                                    <option value="Τίποτα">Τίποτα</option>
				</select>
                            </div>
                        </td>
                        <td>
                            <div>
                                <label  id="DateOfUptakeLabel" name="DateOfUptakeLabel"><strong>Ημερομηνία πρόσληψης</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input type="text" name="DateOfUptakeText" id="DateOfUptakeText" required>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <div>
                                <label  id="NumberIdentificationIKALabel" name="NumberIdentificationIKALabel"><strong>Α.Μ ΙΚΑ</strong></label>
                            </div>
                        </td>
                        <td>
                            <div>
                                <input  type="text" name="NumberIdentificationIKAText" id="NumberIdentificationIKAText" required>
                            </div>
                        </td>
                        <td>
                            <div>
                                <label  id="NumberIdentificationEmployeeLabel" name="NumberIdentificationEmployeeLabel"><strong>Α.Μ Εργαζομένου</strong></label>
                            </div>
                        </td>
                        <td>
                            <div align="center">
                                <input  type="text" name="NumberIdentificationEmployeeText" id="NumberIdentificationEmployeeText" required>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <label id="YAAPELabel" name="YAAPELabel"><strong>Υπόλοιπο άδειας από προηγούμενο έτος</strong></label>
                        </td>
                        <td>
                             <input type="text" name="YAAPEText" id="YAAPEText">
                        </td>
                        <td>
                            <label id="CaseinΥearLabel" name="CaseinΥearLabel"><strong>Υπόλοιπο άδειας από το τωρινό έτος</strong></label>
                        </td>
                        <td>
                            <input type="text" id="CaseinΥearText" name="CaseinΥearText">
                        </td>
                    </tr>
                    
                    
                    
                    <tr>
                        <td>
                            <label  id="SectionLabel" name="SectionLabel"><strong>Τμήμα</strong></label>
                        </td>
                        <td colspan="3" align="center">
                            <div>
                                <select name="SectionSelection" form="form1" id="SectionSelection"  style="width: 460px;">
                                    <option value="Τμήμα Στρατηγικού Σχεδιασμού, Διεθνούς και Ευρωπαϊκής Συνεργασίας">Τμήμα Στρατηγικού Σχεδιασμού, Διεθνούς και Ευρωπαϊκής Συνεργασίας</option>
                                    <option value="Τμήμα Λειτουργίας και Συντονισμού Επιχειρησιακών Δράσεων">Τμήμα Λειτουργίας και Συντονισμού Επιχειρησιακών Δράσεων</option>
                                    <option value="Τμήμα Ανθρώπινου Δυναμικού, Εκπαίδευσης και Διασφάλισης Πoιότητας">Τμήμα Ανθρώπινου Δυναμικού, Εκπαίδευσης και Διασφάλισης Πιότητας</option>
                                    <option value="Τμήμα Δομών Φιλοξενίας Αιτούντων Άσυλο και Ευάλωτων Ομάδων">Τμήμα Δομών Φιλοξενίας Αιτούντων Άσυλο και Ευάλωτων Ομάδων</option>
                                    <option value="Τμήμα Οικονομικού">Τμήμα Οικονομικού</option>
                                    <option value="Τίποτα">Τίποτα</option>
				</select>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td>
                            <div>
                                <input type="checkbox" id="CardPOLCB" name="CardPOLCB" value="CardPOL">
                                <label for="CardPOLCB">Κάρτα POL</label>
                            </div>
                        </td>
                        <td></td>
                        <td>
                            <div>
                                <input type="checkbox" id="DriveLicenseCB" name="DriveLicenseCB" value="DriveLicense">
                                <label for="DriveLicenseCB">Άδεια οδήγησης οχήματος</label>
                            </div>
                        </td>
                    </tr>
                                     
                    <tr>
                        <td colspan="4">
                            <div>
                                <input type="submit" name="Submit" value="Καταχώρηση">
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="4">
                            <button type="button" name="ReloadPage" id="ReloadPage" onclick="window.location.reload();">Επαναφόρτωση σελίδας</button>
                        </td>
                    </tr> 
                    <tr>
                    <td colspan="4">
                        <button type="button" name="GoMainPage" id="GoMainPage" onclick="window.location.href='index.php'">Αρχική</button>
                    </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <button type="button" name="GoToMenuPage" id="GoToMenuPage" onclick="window.location.href='../LoginSystem/Menu.php'">Έξοδος</button>
                        </td>
                    </tr>
                </table>
                </div>
                </div>

                 <?php
                 error_reporting(0);
                 include 'connector.php';
                 include './ConnectorForAdeies.php';
                 $con = new Connector();
                 $con2 = new ConnectorForAdeies();
                 $SplitEachCharacterOfname = array();
                 $SplitEachCharacterOfSurneme = array();
//                 $failed = false;
//                 $AgeFailed = false;
//                 $AFMfailed = false;
//                 $AMKAfailed = false;
//                 $PoliceIdfailed = false;
//                 $PoliceIdLengthFailed = false;
//                 $PhoneFailed = false;
//                 $PhoneStirngFailed = false;
//                 $EmailFailed = false;
//                 $NumberIdentificationIKAFailed = false;
//                 $EmailFormFailed = false;
                 $CountKenaOfVariableSurname = 0;
                 $CountKenaOfVariableName = 0;
                 $CoveredPositions = 0;
                 $FreePositions = 0;
                 $Flag = false;
                 $WhichTable = null;
//                 $CardPOL = false;
//                 $DriveLicense = false;
                 
                 $ServicesArray = array(0=>"Κεντρική Υπηρεσία",1=>"ΚΕΠΥ Φυλακίου",
                                       2=>"ΚΕΠΥ Λέσβου",3=>"Κινητή Μονάδα Α΄",
                                       4=>"Κινητή Μονάδα Β΄");
                 
                 
                 $NodeArray = array();
                 
                    if (isset($_POST['Submit']))
                    {
                        $name = $_POST['NameText'];
                        $surname = $_POST['SurNameText'];
                        $_SESSION['NameOfEmployee'] = $name;
                        $_SESSION['SurnameOfEmployee'] = $surname;
                        $PoliceID = $_POST['PoliceIDΤext'];
                        $NameOfFather = $_POST['NameOfFatherΤext'];
                        $NameOfMother = $_POST['MothersNameΤext'];
                        $DateOfBorn = $_POST['DateOfBornΤext'];
                        $Situation = $_POST['SituationSelection'];
                        $RelationshipOfWork = $_POST['RelationshipOfWorkSelection'];
                        $DateOfUptake = $_POST['DateOfUptakeText'];
                        $Specialty = $_POST['SpecialtyΤext'];
                        $Phone = $_POST['PhoneΤext'];
                        $AFM = $_POST['AFMΤext'];
                        $Service = $_POST['ServiceSelection'];
                        $AMKA = $_POST['AMKAΤext'];
                        $Age = $_POST['AgeText'];
                        $NumsFor0To6 = $_POST['NumsFor0To6'];
                        $GradeSelection = $_POST['GradeSelection'];
                        $Address = $_POST['AddressText'];
                        $Section = $_POST['SectionSelection'];
                        $Email = $_POST['EMAIL'];
//                        echo "Email: ".$Email."telos Email<br><br>";
                        $Node = $_POST['NodeSelection'];
                        $NumberIdentificationIKA = $_POST['NumberIdentificationIKAText'];
                        $NumberIdentificationEmployee = $_POST['NumberIdentificationEmployeeText'];
                        $CardPOL = $_POST['CardPOLCB'];
                        $DriveLicense = $_POST['DriveLicenseCB'];
                        $LengthOfServicesArray = count($ServicesArray);
//                        echo $DateOfBorn."<br>";
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////Έλεγχος για το πόσα κενά υπάρχουν στην μεταβλητή name
                        $SplitEachCharacterOfname = str_split($name) ;
                        for ($i=0; $i < count($SplitEachCharacterOfname); $i++)
                        {
                            if ($SplitEachCharacterOfname[$i] == " ")
                            {
                                $CountKenaOfVariableName++;
                            }
                            else
                            {
                                continue;
                            }
                        }
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////Έλεγχος για το πόσα κενά υπάρχουν στην μεταβλητή name
                        $SplitEachCharacterOfSurneme = str_split($surname) ;
                        for ($i=0; $i < count($SplitEachCharacterOfSurneme); $i++)
                        {
                            if ($SplitEachCharacterOfSurneme[$i] == " ")
                            {
                                $CountKenaOfVariableSurname++;
                            }
                            else
                            {
                                continue;
                            }
                        }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                        echo "Στην μεταβλητή 'name' βρέθηκαν ".$CountKenaOfVariableName." κενά<br>";
                        echo "Στην μεταβλητή 'surname' βρέθηκαν ".$CountKenaOfVariableSurname." κενά<br>";
                        
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////                        
//////////////////////////Έλεγχος για το εάν η μεταβλητή "name" και "surname" έχει το σύμβολο κενό
                        if ($CountKenaOfVariableName > 0)
                        {
                            for($i = 0; $i < $CountKenaOfVariableName; $i++)
                            {
                                $ProthikiKenonForVariableName = $ProthikiKenonForVariableName." ";
                            }
                        $name = str_replace($ProthikiKenonForVariableName, " - ", $name);
                        }
                        else
                        {
                            
                        }
                        
                        if ($CountKenaOfVariableSurname > 0)
                        {
                            for($i = 0; $i < $CountKenaOfVariableSurname; $i++)
                            {
                                $ProthikiKenonForVariableSurname = $ProthikiKenonForVariableSurname." ";
                            }
                        $surname = str_replace($ProthikiKenonForVariableSurname, " - ", $surname);
                        }
                        else
                        {
                            
                        }
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                        include 'CheckTextBoxes.php';
                        $CTB = new CheckTextBoxes();
                        $CTB->CheckTextBox($surname, $name, $NameOfFather, $NameOfMother, $Address, $Phone, $DateOfBorn, $Age, $PoliceID, $AMKA, $NumberIdentificationIKA, $AFM,
                                           $Situation, $RelationshipOfWork, $DateOfUptake, $Service, $Section, $Node, $Specialty, $GradeSelection, $NumsFor0To6, $Email, 
                                           $NumberIdentificationEmployee);
//                        echo "Κάρτα POL(Before): ".$CardPOL."<br>";
                        if ($CardPOL == "CardPOL")
                        {
                            $CardPOL = "Έχει κάρτα POL";
                        }
                        else
                        {
                            $CardPOL = "Δεν έχει κάρτα POL";
                        }
                        $DriveLicense = $_POST['DriveLicenseCB'];
//                        echo "Άδεια οδήγησης οχήματος(Before): ".$DriveLicense."<br>";
                        if ($DriveLicense == "DriveLicense")
                        {
                            $DriveLicense = "Έχει άδεια οδήγησης";
                        }
                        else
                        {
                            $DriveLicense = "Δεν έχει άδεια οδήγησης";
                        }
//                        echo "Άδεια οδήγησης οχήματος(After): ".$DriveLicense."<br>";
//                        echo "Κάρτα POL(After): ".$CardPOL."<br>";
////                        echo "Ημερομηνία πρόσληψης: ".$DateOfUptake."<br>";
//                        
////                        $FieldArray = array(0=>$name, 1=>$surname, 2=>$PoliceID, 3=>$NameOfFather,
////                                            4=>$NameOfMother, 5=>$DateOfBorn, 6=>$Situation, 7=>$RelationshipOfWork,
////                                            8=>$DateOfUptake, 9=>$Specialty, 10=>$Phone, 11=>$AFM, 12=>$Service,
////                                            13=>$AMKA, 14=>$Age, 15=>$NumsFor0To6, 16=>$GradeSelection, 17=>$Address,
////                                            18=>$Section, 19=>$Email, 20=>$Node);
////                        $LengthOfFieldArray = count($FieldArray);
//                        if ( (!is_numeric($NumberIdentificationEmployee)) || (strlen($NumberIdentificationEmployee) != 6) )
//                        {
//                            $failed = true;
//                            $NumberIdentificationEmployeeFailed = true;
//                        }
//                        if ( (!is_numeric($NumberIdentificationIKA)) || (strlen($NumberIdentificationIKA) != 7) )
//                        {
//                            $failed = true;
//                            $NumberIdentificationIKAFailed = true;
//                        }
//                        if ((is_numeric($Age) == false) || (($Age < 18) || ($Age > 80)))
//                        {
//                            $failed = true;
//                            $AgeFailed = true;
//                        }
//                        if ((is_numeric($AFM) == false) || (strlen($AFM) != 9))
//                        {
//                            $failed = true;
//                            $AFMfailed = true;
//                        }
//                        if (((is_numeric($AMKA) == false) || (strlen($AMKA) != 11)) && ($AMKA != null))
//                        {
//                            $failed = true;
//                            $AMKAfailed = true;
//                        }
//
//                        $PoliceIDLenght = mb_strlen($PoliceID, 'utf-8');
////                            echo  "<br> PoliceId: ".$PoliceID." PoliceIdLength: ".$PoliceIDLenght;
//                        if (($PoliceIDLenght == 7) || ($PoliceIDLenght == 8)) 
//                        {
//                            if ($PoliceIDLenght == 7)//Get length of label PoliceID and check if is 7
//                            {
//                                $Firstletter = mb_substr($PoliceID, 0, 1,"utf-8");//Put on variable '$Firstletter' first letter of PoliceId field
//                                $RestLetters = mb_substr($PoliceID, 1, $PoliceIDLenght, "utf-8");//Put on variable '$RestLetters' restt letters of PoliceId field
//                                if ((!is_string($Firstletter)) || (!is_numeric($RestLetters)))//Check if first letter is not a string, or rest letters is not nums 
//                                {
//                                    $failed = true;
//                                    $PoliceIdfailed = true;
//                                }
//                            }
//                            if ($PoliceIDLenght == 8)//Get length of label PoliceID and check if is 8
//                            {
//                                $First2letters = mb_substr($PoliceID, 0, 2,"utf-8");//Put on variable '$First2letters' first 2 letters of PoliceId field
//                                $RestLetters = mb_substr($PoliceID, 2, $PoliceIDLenght, "utf-8");//Put on variable '$RestLetters' restt letters of PoliceId field
//                                if ((!is_string($First2letters)) || (!is_numeric($RestLetters)))
//                                {
//                                    $failed = true;
//                                    $PoliceIdfailed = true;
//                                }
//                            }
//                        }
//                        else
//                        {
//                            $failed = true;
//                            $PoliceIdLengthFailed = true;
//                        }
//                        if ((strlen($Phone) != 10) && ($Phone != null)) //Check if Phone is not 10 nums OR is not numeric
//                        {
//                            $failed = true;
//                            $PhoneFailed = true;
//                        }
//                        else if ((!is_numeric($Phone)) && ($Phone != null))
//                        {
//                            $failed = true;
//                            $PhoneStirngFailed = true;
//                        }
//                        else if ($Phone == null)
//                        {
//
//                        }
//
//                        if( (check_email_address($Email) == true) && ($Email != null))
//                        {
//                            if(domain_exists($Email))
//                            {
//                            }
//                            else
//                            {
//                                $failed = true;
//                                $EmailFailed = true;
//                            }
//                        }
//                        else if($Email == null)
//                        {
//                            
//                        }
//                        else
//                        {
//                            $failed = true;
//                            $EmailFormFailed = true;
//                        }
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
                            
                            die("<strong><font size='4'>Η εφαρμογή δεν μπορεί να συνεχίσει την λειτουργία της λόγω των παραπάνω προβλημάτων πουπαρουσιάστηκαν!Παρακαλώ για την σωστή λειτουργία της εφαρμογής πατήσε το κουμπί 'Επαναφώρτωση σελίδας' και επαναλάβεται την διαδικασία καταχώρησης</font></strong>");
                        }
                        else
                        {
                            if (($Situation == "Μετάταξη") && ($Node != "Τίποτα") && ($Service != "Τίποτα"))
                            {
                            $IndexOfNodeArray=0;
                            for ($i=0; $i<$LengthOfServicesArray; $i++)
                            {
                                if ($Service == $ServicesArray[$i])
                                {
                                    $res = $con->prepare("SELECT * FROM services WHERE value=?",array($Service));
                                    while($row = $res->fetch())
                                    {
                                        $id = $row['id'];
                                        $res = $con->prepare("SELECT services.value, select_service_table.value FROM services INNER JOIN select_service_table ON "
                                                            . "services.id=select_service_table.id AND services.id='$id';");
                                        while($row1 = $res->fetch())
                                        {
                                            $WhichTable = $row1['value'];
                                            $res = $con->prepare("SELECT * from ".$WhichTable);
                                            while($row2 = $res->fetch())
                                            {
                                                $NodeArray[$IndexOfNodeArray] = $row2['value'];//Create array with Node for each Service users select
                                                $IndexOfNodeArray++;
                                            }
                                        }
                                    }
                                }
                            }
                            $LengthOfNodeArray = count($NodeArray);
                            for ($i = 0; $i<$LengthOfNodeArray; $i++)
                            {
                                if ($Node == $NodeArray[$i])
                                {
                                    $res = $con->prepare("SELECT piasmenes_thesis FROM ".$WhichTable." WHERE value='$Node'");
                                    while($row = $res->fetch())
                                    {
                                        $CoveredPositions = (int)$row['piasmenes_thesis'];
//                                        echo "CoveredPositions = ".$CoveredPositions."<br>";
                                    }
                                    $res = $con->prepare("SELECT eleutheres_thesis FROM ".$WhichTable." WHERE value='$Node'");
                                    while($row = $res->fetch())
                                    {
                                        $FreePositions = (int)$row['eleutheres_thesis'];
    //                                        echo "CoveredPositions = ".$FreePositions."<br>";
                                    }
                                }
                            }
                            if ($FreePositions > 0)
                            {
                                $FreePositions = $FreePositions - 1;
                                $CoveredPositions = $CoveredPositions + 1;

    //                            echo "FreePositions after insert = ".$FreePositions." and CoveredPositions after insert = ".$CoveredPositions."<br>"
                            $res = $con->prepare("UPDATE ".$WhichTable." SET eleutheres_thesis=? WHERE value=?",array($FreePositions,$Node));
                            $res->execute();

                            $res = $con->prepare("UPDATE ".$WhichTable." SET piasmenes_thesis=? WHERE value=?",array($CoveredPositions,$Node));
                            $res->execute();
                            }
                            else
                            {
                                echo '<span style="color:red;text-align:center;">Δεν υπάρχουν διαθέσιμες θέσεις για τον κλάδο που επιλέξατε</span>'."<br>";
                                die("<strong><font size='4'>Η εφαρμογή τερματίστηκε λόγω των παραπάνω λόγων!Παρακαλώ για την σωστή λειτουργία της εφαρμογής πατήσε το κουμπί 'Επαναφώρτωση σελίδας'</font></strong>");
                            }
                        } 
                        else
                        {

                        }
                        
                            $res = $con->prepare("INSERT INTO kataxorisiuser(Name,SurName,PoliceID,NameOfFather,NameOfMother,DayOfBorn,Situation,"
                                                . "EmploymentRelationship,DateOfUptake,"
                                                . "AFM,Specialty,Phone,Service,AMKA,NumberIdentificationIKA,Age,MK,Grade,Address,Section,email,branch,NumberIdentificationEmployee,CardPOL,DriveLicense) VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                                                array($name,$surname,$PoliceID,$NameOfFather,$NameOfMother,$DateOfBorn,$Situation,$RelationshipOfWork,$DateOfUptake,$AFM,$Specialty,
                                                      $Phone,$Service,$AMKA,$NumberIdentificationIKA,$Age,$NumsFor0To6,$GradeSelection,$Address,$Section,$Email,$Node,
                                                      $NumberIdentificationEmployee,$CardPOL,$DriveLicense));
                            $res = $con->prepare("INSERT INTO yaape_for_each_employee (name,Surname,YAAPE,YAAPE_HOURS,YAATE) VALUES(?,?,?,?,?)",array($name,$surname,$_POST['YAAPEText'],'0',$_POST['CaseinΥearText']));
                            $res = $con->prepare("INSERT INTO yaape_for_each_employee_backup (name,Surname,YAAPE,YAAPE_HOURS,YAATE) VALUES(?,?,?,?,?)",array($name,$surname,$_POST['YAAPEText'],'0',$_POST['CaseinΥearText']));
                            
                            $res2 = $con2->prepare("INSERT INTO kataxorisi_adeion (Name, Surname) VALUES('$name','$surname')");
                            $res2 = $con2->prepare("INSERT INTO kataxorisi_adeion_backup (Name, Surname) VALUES('$name','$surname')");
                            if ($res)
                            {
                                $NameOfLogin = $_SESSION['NameOfLogin'];
                                $SurnameOfLogin = $_SESSION['SurnameOfLogin'];
                                $ProgrammThatUserClick = $_SESSION['ProgrammThatUserClick'];
                                echo "<strong><font size='4'>Επιτυχής καταχώρηση υπαλλήλου!!</font></strong>"."<br>";   
                                $description ="Ο/Η χρήστης (ον) ".$_SESSION['NameOfLogin']." (επ) ".$_SESSION['SurnameOfLogin']." εκτέλεσε την λειτουργία ".
                                              $_SESSION['AntistoixoKoumpi']."με την οποία καταχώρησε τον/την υπάλληλο (ον) ".$name." (επ) "
                                              .$surname.". H ".$_SESSION['AntistoixoKoumpi']." πραγματοποιήθηκε στις ".ConvertEnglishDaysAndMonthToGreek(date("l jS \of F Y"))." "
                                              . "και ώρα ".date("h:i:s").". Ο χρήστης (ον) ".$NameOfLogin." (επ) ".$SurnameOfLogin." "
                                              . "χαρακτηρίζεται ως ".CheckUser().".";
                                $res = $con->prepare("INSERT INTO history VALUES('$NameOfLogin', '$SurnameOfLogin', '$ProgrammThatUserClick','$description')");
                            }
                            else
                            {
                                echo "<strong><font size='4'>Παρουσιάστηκε πρόβλημα με την καταχώρηση υπαλλήλου!!Παρακαλώ επικοινωνίστε με τον διαχειριστή για επίλυση του προβλήματος</font></strong>"."<br>";

                            }
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
                    
                    ?>
            </form>
        </body>
</html>

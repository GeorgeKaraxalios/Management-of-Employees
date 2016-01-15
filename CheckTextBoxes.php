<?php

class CheckTextBoxes 
{
    public $failed = false;
    public $AgeFailed = false;
    public $AFMfailed = false;
    public $AMKAfailed = false;
    public $PoliceIdfailed = false;
    public $PoliceIdLengthFailed = false;
    public $PhoneFailed = false;
    public $PhoneStirngFailed = false;
    public $EmailFailed = false;
    public $NumberIdentificationIKAFailed = false;
    public $EmailFormFailed = false;
    public $NumberIdentificationEmployeeFailed = false;
    
    public function CheckTextBox($surname, $name, $NameOfFather, $NameOfMother, $Address, $Phone, $DateOfBorn, $Age, $PoliceID, $AMKA, $NumberIdentificationIKA, $AFM,
                                 $Situation, $RelationshipOfWork, $DateOfUptake, $Service, $Section, $Node, $Specialty, $GradeSelection, $NumsFor0To6, $Email, 
                                 $NumberIdentificationEmployee)
    {
       
//                        echo "Άδεια οδήγησης οχήματος(After): ".$DriveLicense."<br>";
//                        echo "Κάρτα POL(After): ".$CardPOL."<br>";
//                        echo "Ημερομηνία πρόσληψης: ".$DateOfUptake."<br>";
                        
//                        $FieldArray = array(0=>$name, 1=>$surname, 2=>$PoliceID, 3=>$NameOfFather,
//                                            4=>$NameOfMother, 5=>$DateOfBorn, 6=>$Situation, 7=>$RelationshipOfWork,
//                                            8=>$DateOfUptake, 9=>$Specialty, 10=>$Phone, 11=>$AFM, 12=>$Service,
//                                            13=>$AMKA, 14=>$Age, 15=>$NumsFor0To6, 16=>$GradeSelection, 17=>$Address,
//                                            18=>$Section, 19=>$Email, 20=>$Node);
//                        $LengthOfFieldArray = count($FieldArray);
                        if ( (!is_numeric($NumberIdentificationEmployee)) || (strlen($NumberIdentificationEmployee) != 6) )
                        {
                            $this->failed = true;
                            $this->NumberIdentificationEmployeeFailed = true;
                        }
                        if ( (!is_numeric($NumberIdentificationIKA)) || (strlen($NumberIdentificationIKA) != 7) )
                        {
                            $this->failed = true;
                            $this->NumberIdentificationIKAFailed = true;
                        }
                        if ((is_numeric($Age) == false) || (($Age < 18) || ($Age > 80)))
                        {
                            $this->failed = true;
                            $this->AgeFailed = true;
                        }
                        if ((is_numeric($AFM) == false) || (strlen($AFM) != 9))
                        {
                            $this->failed = true;
                            $this->AFMfailed = true;
                        }
                        if (((is_numeric($AMKA) == false) || (strlen($AMKA) != 11)) && ($AMKA != null))
                        {
                            $this->failed = true;
                            $this->AMKAfailed = true;
                        }

                        $PoliceIDLenght = mb_strlen($PoliceID, 'utf-8');
//                            echo  "<br> PoliceId: ".$PoliceID." PoliceIdLength: ".$PoliceIDLenght;
                        if (($PoliceIDLenght == 7) || ($PoliceIDLenght == 8)) 
                        {
                            if ($PoliceIDLenght == 7)//Get length of label PoliceID and check if is 7
                            {
                                $Firstletter = mb_substr($PoliceID, 0, 1,"utf-8");//Put on variable '$Firstletter' first letter of PoliceId field
                                $RestLetters = mb_substr($PoliceID, 1, $PoliceIDLenght, "utf-8");//Put on variable '$RestLetters' restt letters of PoliceId field
                                if ((!is_string($Firstletter)) || (!is_numeric($RestLetters)))//Check if first letter is not a string, or rest letters is not nums 
                                {
                                    $this->failed = true;
                                    $this->PoliceIdfailed = true;
                                }
                            }
                            if ($PoliceIDLenght == 8)//Get length of label PoliceID and check if is 8
                            {
                                $First2letters = mb_substr($PoliceID, 0, 2,"utf-8");//Put on variable '$First2letters' first 2 letters of PoliceId field
                                $RestLetters = mb_substr($PoliceID, 2, $PoliceIDLenght, "utf-8");//Put on variable '$RestLetters' restt letters of PoliceId field
                                if ((!is_string($First2letters)) || (!is_numeric($RestLetters)))
                                {
                                    $this->failed = true;
                                    $this->PoliceIdfailed = true;
                                }
                            }
                        }
                        else
                        {
                            $this->failed = true;
                            $this->PoliceIdLengthFailed = true;
                        }
                        if ((strlen($Phone) != 10) && ($Phone != null)) //Check if Phone is not 10 nums OR is not numeric
                        {
                            $this->failed = true;
                            $this->PhoneFailed = true;
                        }
                        else if ((!is_numeric($Phone)) && ($Phone != null))
                        {
                            $this->failed = true;
                            $this->PhoneStirngFailed = true;
                        }
                        else if ($Phone == null)
                        {

                        }

                        if( (check_email_address($Email) == true) && ($Email != null))
                        {
                            if(domain_exists($Email))
                            {
                            }
                            else
                            {
                                $this->failed = true;
                                $this->EmailFailed = true;
                            }
                        }
                        else if(($Email == null) || ($Email = " "))
                        {
                            
                        }
                        else
                        {
                            $this->failed = true;
                            $this->EmailFormFailed = true;
                        } 
    }   
}
?>

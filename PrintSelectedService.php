
        <?php
        include 'connector.php';
        $con = new Connector();
	$Value = null;
        $doc_body = null;
        $SinolikesThesis = null;
        $SinolikesThesisINT = 0;
        $PiasmenesThesis = null;
        $PiasmenesThesisINT = 0;
        $ServiceSelectionTable = null;
        $EleutheresThesis = null;
        $EleutheresThesisINT = 0;
                $ServiceSelection = $_COOKIE['ServiceSelection'];//Set ServiceSelection from user choise
                echo $ServiceSelection;
                $result = $con->prepare("SELECT value FROM services");//Return rows with Services
                while($row = $result->fetch())
                {
                    if ($ServiceSelection == $row['value'])//if any Service is equal with Service from user choise then return who table is equal with that Service
                    {
                        $result1 = $con->prepare("SELECT services.value, select_service_table.value FROM services INNER JOIN select_service_table ON services.id=select_service_table.id "
                                                . "AND services.value='$ServiceSelection';");
                        while ($row1 = $result1->fetch())
                        {
                            $ServiceSelectionTable = $row1['value'];
                        }
                        $result2 = $con->prepare("SELECT * FROM ".$ServiceSelectionTable);
                        $doc_body ="<html>
                                        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                                        <body>
                                            <table border='1'>
                                                <tr>
                                                    <th colspan='4'>
                                                        <div align='cente'>
                                                            <h3><strong>".$ServiceSelection."</strong></h3>
                                                        </div>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <strong>Κλαδος</strong>
                                                    </td>
                                                    <td width='140' align='center'>
                                                        <strong>Σύνολο οργανικών θέσεων</strong>
                                                    </td>
                                                    <td width='125' align='center'>
                                                        <strong>Δεσμευμένες θέσεις</strong>
                                                    </td>
                                                    <td align='center'>
                                                        <strong>Κενές θέσεις</strong>
                                                    </td>
                                                </tr>";
                        
                        while($row2 = $result2->fetch())
                        {
                            $Value = $row2['value'];
                            $SinolikesThesis = $row2['sinolikes_thesis'];
                            $PiasmenesThesis = $row2['piasmenes_thesis'];
                            $EleutheresThesis = $row2['eleutheres_thesis'];
                            
                            $doc_body=$doc_body."<tr>"
                                                    ."<td>"
                                                        .$Value
                                                    ."</td>"
                                                    ."<td align='center'>"
                                                        .$SinolikesThesis
                                                    ."</td>"
                                                    ."<td align='center'>"
                                                        .$PiasmenesThesis
                                                    ."</td>"
                                                    ."<td align='center'>"
                                                        .$EleutheresThesis
                                                    ."</td>"
                                                ."</tr>";
                            
                            $SinolikesThesisINT = $SinolikesThesisINT + (int)$SinolikesThesis;
                            $PiasmenesThesisINT = $PiasmenesThesisINT + (int)$PiasmenesThesis;
                            $EleutheresThesisINT = $EleutheresThesisINT + (int)$EleutheresThesis;
                        }
                        
                        $doc_body=$doc_body."<tr>"
                                                ."<td>"
                                                    ."Συνολικές Θέσεις"
                                                . "</td>"
                                                ."<td align='center'>"
                                                    .$SinolikesThesisINT
                                                ."</td>"
                                                ."<td align='center'>"
                                                    .$PiasmenesThesisINT
                                                ."</td>"
                                                ."<td align='center'>"
                                                    .$EleutheresThesisINT
                                                ."</td>"
                                            ."</tr>";
                        $doc_body = $doc_body."</table></body></html>";
                        echo $doc_body;
                    header("Content-Type: application/vnd.msword charset='utf-8'");
                    header("Expires: 0");//no-cache
                    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");//no-cache
                    header("content-disposition: attachment;filename=".$ServiceSelection.".doc");
                    
                    //echo "<script type='text/javascript'>window.location.href='PrintSelectedService.php';</script>";
                    }
                }
            ?>

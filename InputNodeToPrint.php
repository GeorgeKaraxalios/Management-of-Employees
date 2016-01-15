<?php
    include './CheckForLogin/Check.php';
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="css/StyleWithoutForm.css" rel="stylesheet">
    </head>
    <body>
        <script type="text/javascript">
            function SetSeesionOption()
            {
                $("#ServiceSelection").change(function ()
                {
                    <?php $_SESSION['ServiceSelection']?> = $("#ServiceSelection").val();
                    alert(<?php $_SESSION['ServiceSelection']?>);
                }
            }
            function configurator() 
            { 
                var x = document.getElementById("ServiceSelection").value;
                document.cookie="ServiceSelection="+x;
                alert("ΟΚ");
                window.location.href='PrintSelectedService.php';
            }
        </script>
        <?php
//            //Intialize array that have two values
//            //index 1 value red
//            //index 2 value orange
//            $a = array(1=>"red",2=>"orange");
//            
//            //This function push in array $a two value 
//            //index 3 value blue
//            //index 4 value yellow
//            array_push($a,"blue","yellow");
//            print_r($a);
        include 'connector.php';
//        echo $_SESSION['AntistoixoKoumpi']."<br>";
        $description = null;
        $con = new Connector();
        $result = $con->prepare("SELECT value FROM services");
        ?>
            <div id="main">
                <div id="first">
                    <table>
                        <tr>
                            <td align="center">
                                <select name="ServiceSelection" id="ServiceSelection">
                                    <?php 
                                    while($row = $result->fetch())
                                    {
                                        $ValueOfServices = $row['value'];
                                        ?>
                                    <option value="<?php echo $ValueOfServices;?>"><?php echo $ValueOfServices;?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </td>

                            <td>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input type="submit" name="GoMainPage" id="GoMainPage" onclick="window.location.href='index.php'" value="Αρχική">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" name="Submit" onclick="var x = document.getElementById('ServiceSelection').value;
                                                                            document.cookie='ServiceSelection='+encodeURIComponent(x);
                                                                            window.location.href='PrintSelectedService.php';" 
                                        value="Εκτύπωση Διαθέσιμων θέσεων">
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
    </body>
</html>

<?php
class Connector{
        public $dbh;
        public $stmt;
        public function __construct(){
                $this->dbh=new PDO('mysql:dbname=kataxorisis;host=localhost','root','');
                $this->dbh -> exec("set names utf8");
//                $this->dbh -> exec("SET CHARACTER SET 'utf8'");
        }

        public function prepare($query,array $fields=null){
                $this->stmt = $this->dbh->prepare($query);
                if($fields!==null){
                        for($i=0;$i<sizeof($fields);$i++)
                                $this->stmt->bindParam($i+1,$fields[$i]);
                }
                $this->stmt->execute();
                return $this->stmt;
                }
        }

?>

<?php

class sql_crud{

    private $connection;

    // just creates a new connection of mySQL from sqli

    public function __construct($host,$user,$password,$database) {

        $this->connection = new mysqli($host,$user,$password,$database);

    }

//-------------------------------------------------------------------------------------------------------------------------


    // get the status of connection

    public function get_status(){

        if($this->connection){

            return true;

        }

        else{

            return false;

        }

    }

//-------------------------------------------------------------------------------------------------------------------------

    /*validates a password and username and returns

    0 invalid username

    1 valid username but invalid password

    2 valid username and password

    */

    public function validate_password($table,$name_col,$password_col,$name,$password){

        $q = "select ".$name_col." , ".$password_col." from ".$table." where ".$name_col." = '".$name."'";

        $result = $this->connection->query($q);

        if($result->num_rows > 0){

            if($row = $result-> fetch_assoc()){

                $_name=$row[$name_col];

                $_password=$row[$password_col];

                if($password == $_password){

                    return 2;

                }


                else{

                    return 1;

                }

            }
            
            else {

                return 0;

            }

        }

        else{

            return 0;

        }

    }

//---------------------------------------------------------------------------------------------------------------------------
 
/*

returns single line or the first line of a query as an array of strings

in the case of non existing lines the function will return an array of 2 null strings

*/

function get_line($q){

    $result = $this->connection->query($q);

    if($result->num_rows > 0){

        $line=$result->fetch_array(MYSQLI_NUM);

        return $line;

    }

    else {

        $null_line=array("","");

        return $null_line;

    }

}

//---------------------------------------------------------------------------------------------------------------------------------

/*

returns the full table of a query as a string matrix

in the case of non existing lines the function will return a matrix of 2x2 null strings

*/

    function get_table($q){

        $result = $this->connection->query($q);
    
        if($result->num_rows > 0){
    
            $table=$result->fetch_all(MYSQLI_NUM);
    
            return $table;
    
        }
    
        else {
    
            $null_table=array(array("",""),array("",""));

            return $null_table;
    
        }

    }

//------------------------------------------------------------------------------------------------------------------------------

/*

returns the selected cell as a string or the cell at index 0,0 of the query

or in the case of a null result the function returns a null string

*/ 

    public function get_cell($q){

        $result = $this->connection->query($q);

        if($result->num_rows > 0){

            $line=$result->fetch_array(MYSQLI_NUM);

            $cell=$line[0];
    
            return $cell;
    
        }

        else{

            return "";

        }

    }

/*

returns single column or the first column of a query as an array of strings

in the case of non existing lines the function will return an array of 2 null strings

*/

    function get_col($q){

        $result = $this->connection->query($q);
    


        if($result->num_rows > 0){
    
            $table=$result->fetch_all(MYSQLI_NUM);

            $s=sizeof($table);

            $col=array("","");

            for($i=0; $i<$s; $i++){

                $col[$i]=$table[$i][0];

            }

            return $col;
    
        }
    
        else {
    
            $null_col=array("","");

            return $null_col;
    
        }

    }

}

?>

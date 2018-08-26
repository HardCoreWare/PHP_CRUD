<?php

class pdo_crud{

    private $pdo;

    public function __construct($connection,$user,$password){
        
        try{
            
            $this->pdo= new PDO($connection,$user,$password);

        }
        
        catch(Exception $e){
            
            die($e);
        
        }
      
    }

    /*
    pdo object turns null
    */

    public function end(){

        $this->pdo=null;

    }

    /*
    validates username and password
    returns 2 when both are correct
    returns 1 when the user exists but the password is incorrect
    returns 0 when the user does not exist
    */
    public function validate_password($table,$user_col,$password_col,$user,$password){

        try{
        
            $user_query="SELECT ".$user_col." FROM ".$table." WHERE ".$user_col." = ?";
            $user_params = array($user);
            $user_result=$this->pdo->prepare($user_query);
            $user_result->execute($user_params);

            if($user_value=$user_result->fetch(PDO::FETCH_ASSOC)){

                if($user_value[$user_col]==$user){
                
                    $password_query="SELECT ".$password_col." FROM ".$table." WHERE ".$user_col." = ?";
                    $password_result=$this->pdo->prepare($password_query);
                    $password_result->execute($user_params);
                
                    if($password_value=$password_result->fetch(PDO::FETCH_ASSOC)){
                    
                        if($password_value[$password_col]==$password){

                            return 2;

                        }

                        else{

                            return 1;

                        }
                
                    }
                
                    else{
                    
                        return 1;
                
                    }

                }

                else{

                    return 0;

                }

            }

            else{

                return 0;

            }

        }

        catch(Exception $e){

            die($e);

        }

    }

    /*
    insert data associative array matrix inside a table
    */
    public function insert_block($table,$data){
        
        try{
    
            foreach ($data as $i => $line) {
        
                $columns=implode(", ",array_keys($line));
            
                $values=implode("', '",array_values($line));
               
                $sql="INSERT INTO ".$table."(".$columns.")"." VALUES("."'".$values."'".");";
 
                $this->pdo->query($sql);
                
            }

        }
        
        catch(Exception $e){
            
            die($e);
            
        }

    }

    /*
    insert data associative array single line inside a table
    */
    public function insert_line($table,$data){

        $columns=implode(", ",array_keys($data));
    
        $values=implode("', '",array_values($data));

        $sql="INSERT INTO ".$table."(".$columns.")"." VALUES("."'".$values."'".");";

        try{
    
            $this->pdo->query($sql);
        }
        
        catch(Exception $e){

            die($e);

        }

    }

    /*
    updates data as an associative array
    */
    public function update($table,$data,$targets){

        $changes = array();

        foreach ($data as $key => $value) {

            $change = $key." = '".$value."'";

            $changes[]=$change;

        }

        $changes = implode(", ",$changes);

        try{
        
            $sql = "UPDATE ".$table." SET ".$changes." WHERE ".$targets;

            $this->pdo->query($sql);

        }

        catch(Exception $e){

            die($e);

        }

    }
    
    public function select($table,$fields,$targets,$order){
        
        $field_pack=implode(", ",$fields);
    
        $sql="SELECT ".$field_pack." FROM ".$table." WHERE ".$targets." ORDER BY ".$order;
    

        try{

        
            $result=$this->pdo->query($sql,PDO::FETCH_ASSOC);
         
            $table=array();

            foreach($result as $i=>$row){
                
                $line=array();

                foreach($row as $key=>$value){
                    
                    $line[$key]=$value;
        
                }
        
                $table[$i]=$line;

            }
        
            return $table;

        }

        catch(Exception $e){

            die($e);

        }

    }

    public function delete($table,$targets){


        
        $sql="DELETE FROM ".$table." WHERE ".$targets;
            
        try{
            
            $this->pdo->query($sql);

        }

        catch(Exception $e){

            die($e);

        }

    }


}




?>





?>

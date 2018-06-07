<?php



Class Model_Base {



    protected $db;

    protected $table = array();

    private $dataResult;



    

    public function __construct($servername = "localhost", $username = "aksharso_user", $password = "Vipers*91", $dbname = "aksharso_inventory") {
        $dbObject = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $this->db = $dbObject;
    }



    public function getTableName() {
        return $this->table;
    }

    

    public function getmodelcolumn() {
        return $this->table;
    }

    

    public function getmodeltables() {
        return $this->table;
    }
	
	public static function phoneFormat($number) {
        // Allow only Digits, remove all other characters.
        $number = preg_replace("/[^\d]/", "", $number);

        // get number length.
        $length = strlen($number);

        // if number = 10
        if ($length == 10) {
            $number = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1 $2 $3", $number);
        }

        return $number;
    }




    public static function connectdb($servername = "localhost", $username = "aksharso_user", $password = "Vipers*91", $dbname = "aksharso_inventory") {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        return $conn;

    }



    public static function checkconnection() {
        try {
            $conn = self::connectdb();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

	
	public static function truncateAll($tablename) {

        $result = self::checkconnection()->query("TRUNCATE TABLE " . $tablename);

        if (!$result) {

            die("<h1>Error: An error occurred while removing </h1>");
        }
    }


    function getAllRows() {



        if (!isset($this->dataResult) OR empty($this->dataResult)) {



            $stmt = $this->db->query("SELECT * FROM $this->table");

            $this->dataResult = $stmt->fetchAll();

            $this->dataResult = $this->getList($this->dataResult);

        }



        return $this->dataResult;

    }



    function getRowById($id) {



        $stmt = $this->db->query("SELECT * from $this->table WHERE id = $id");



        $row = $stmt->fetchAll();

        if (empty($row)) {



            die("<h1> Id not found ! </h1>");

        }



        $row = $this->getList($row);

        return $row;

    }



    public static function insert_row($tablename, $columnvalue) {

       

       

        $keys = array_keys($columnvalue);

        $assignment = array_values($columnvalue);



        $mark = array();

        for ($i = 0; $i < count($columnvalue); $i++) {

            $mark[$i] = "?";

        }



        $q = "INSERT INTO `%s` (%s) VALUES (%s)";

        $q = sprintf($q, $tablename, implode(", ", $keys), implode(", ", $mark));

        $q = self::checkconnection()->prepare($q);
        
        

        $r = $q->execute($assignment);

        $q = null;





        return $r;

    }



    public static function query($query) {



        $objs = array();

        if ($result = self::checkconnection()->query($query)) {

            while ($obj = $result->fetchObject()) {

                $objs[] = $obj;

            }

            $result = null;

            return $objs;

        }

    }

    

    public static function where_stmt($arraycolumn) {





        $where = '';





        foreach ($arraycolumn as $key => $value) {

            foreach ($value as $akey => $val) {

                switch ($akey) {

                    case 'colm':

                        $where .= "`" . $value[$akey] . "`";

                        $where .= ' ';



                        break;



                    case 'val':

                        if (is_string($value[$akey])) {

                            $where .= "'" . $value[$akey] . "'";

                            $where .= ' ';

                        } else {

                            $where .= "$value[$akey]";

                            $where .= ' ';

                        }

                        break;



                    default:

                        $where .= $value[$akey];

                        $where .= ' ';

                        break;

                }

            }

        }

        return $where;

    }



    public static function update_rows($tablename,$columnvalue,$arraycolumn){

		$keys= array_keys($columnvalue);

		$set = 'Update '. $tablename . ' Set';

		$assignment = array_values($columnvalue); 

		$where=self::where_stmt($arraycolumn);

		$mark=array();

		for($i=0;$i<count($columnvalue);$i++){

			$mark[$i]="?";

		}

                foreach ($keys as $field) {

                        $set .= " `$field` = ?,";

                }

                $set = rtrim($set, ',');

                $set.=' Where '.$where;

                //print_r($set);exit();

                $q = self::checkconnection()->prepare($set);

                 

		$r = $q->execute($assignment);

               

		$q = null;

		return $r;

	}

    

    public static function delete_rows($tablename, $arraycolumn) {

		$where=self::where_stmt($arraycolumn);

		$q = " DELETE FROM %s WHERE %s";

		$q = sprintf($q, $tablename, $where);

		$q = self::checkconnection()->prepare($q);

		$r = $q->execute();

		$conn = null;

		return $r;

    }

    public static function gridshow($model, $data) {

        

                 $models = 'Model_'.$model;

                 $columnarray =  $models::grid_column();

                 $array = array_keys($columnarray["column"]);

                 htmltpl::gridcall($columnarray, $data,"body",$model);

                 

                 

		//return $r;

    }

    

     public static function joingridshow($model, $data) {

        

                 $models = 'Model_'.$model;

                 $columnarray =  $models::grid_column();

                 $array = array_keys($columnarray["column"]);

                 joinhtml::gridcall($columnarray, $data,"body",$model);

                 

                 

		//return $r;

    }

    

     

    

    public function save() {



        $arrayAllFields = array_keys($this->fieldsTable());

        $arrayData = array();



        foreach ($arrayAllFields as $field) {

            if (!empty($this->$field)) {



                $arrayData[] = $this->$field;

            } else {



                die("<h1>Error: You Must complete all fields</h1>");

            }

        }



        $forQueryFields = implode(', ', $arrayAllFields);

        $rangePlace = array_fill(0, count($arrayAllFields), '?');

        $forQueryPlace = implode(', ', $rangePlace);



        $stmt = $this->db->prepare("INSERT INTO $this->table ($forQueryFields) values ($forQueryPlace)");

        $result = $stmt->execute($arrayData);





        if (!$result) {



            die("<h1>Error: When data is written to the database error occurred</h1>");

        }

    }



    public function deleteById($var_id = 0) {

        if (empty($var_id)) {

            die("<h1>Error: Id is Empty!</h1>");

        }

        $result = $this->db->exec("DELETE FROM $this->table WHERE `id` = $var_id");

        if (!$result) {

            die("<h1>Error: An error occurred while removing </h1>");

        }

    }



    public function deleteAll() {

        $result = $this->db->exec("DELETE FROM $this->table WHERE true");

        if (!$result) {

            die("<h1>Error: An error occurred while removing </h1>");

        }

    }



    public function update($var_id = 0) {

        if (empty($var_id)) {

            die("<h1>Error: Id is Empty!</h1>");

        }

        $arrayAllFields = array_keys($this->fieldsTable());

        $arrayForSet = array();

        foreach ($arrayAllFields as $field) {

            if (!empty($this->$field)) {

                $arrayForSet[] = $field . ' = "' . $this->$field . '"';

            } else {

                die("<h1>Error: You Must complete all fields</h1>");

            }

        }



        $strForSet = implode(', ', $arrayForSet);

        $stmt = $this->db->prepare("UPDATE $this->table SET $strForSet WHERE `id` = $var_id");

        $result = $stmt->execute();

        if (!$result) {

            die("<h1>Error: Data not update</h1>");

        }

    }



    private function getList($var) {

        if (!empty($var)) {

            foreach ($var as $key_1 => $value) {

                foreach ($value as $key => $value) {

                    if (is_string($key)) {

                        $row[$key] = $value;

                    }

                }

                $rowss[$key_1] = $row;

            }

            if (isset($rowss)) {

                return $rowss;

            }

        }

        return null;

    }

    

    public static function columncount($query) {

		

		if ($result = self::checkconnection()->query($query)) {	

                    $objs = $result->columnCount();

                    return $objs;

                }

	}

    

    public static function columnname($query) {

            try {

                    if ($result = self::checkconnection()->query($query)) {	

                        $objs = $result->columnCount();

                        for ($i = 0; $i < $objs; $i++) {

                            $col = $result->getColumnMeta($i);

                            $columns[] = $col['name'];

                            

                        }

                        return $columns;

                    }

                } catch (Exception $e) {

                    return FALSE;

                }

	}

        

        public static function type($tablename){

                try {

                    if ($result = self::checkconnection()->query("SHOW COLUMNS FROM ".$tablename)) {

                        while ($obj = $result->fetchObject()) {

                            $objs[] = $obj;

                        }

                    }

                      return $objs;

                    

                } catch (Exception $e) {

                        return FALSE;

                    }

           }

           

        public static function joinmeta($query) {

            try {

                    if ($result = self::checkconnection()->query($query)) {	

                        $objs = $result->columnCount();

                        for ($i = 0; $i < $objs; $i++) {

                            $col = $result->getColumnMeta($i);

                            $type[]=$col['table'].".".$col['name'];

                        }

                        return $type;

                    }

                } catch (Exception $e) {

                    return FALSE;

                }

	}



}


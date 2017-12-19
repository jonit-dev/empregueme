<?php
class ConnectionFactory{

private static $factory;
public static function getFactory(){
    if (!self::$factory){
        self::$factory = new ConnectionFactory();
        $this->db = null;
    }
    return self::$factory;
}

private $db;

public function getConnection(){
    if (is_null($this->db))
        $this->db = new mysqli('localhost', 'empre941', 'Empre#12', 'empre941_redesocial');
        if ($this->db->connect_error){
            throw new Exception("Connect Error ("
                . $this->db->connect_errno
                . ") "
                . $this->db->connect_error
        );
    }
    return $this->db;
}


}
?>
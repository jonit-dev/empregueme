<?php

class ConnectionFactory {

    private static $factory;

    public static function getFactory() {
        if (!self::$factory) {
            self::$factory = new ConnectionFactory();
            $this->db = null;
        }
        return self::$factory;
    }

    private $db;

    public function getConnection() {
        if (is_null($this->db))
        //$this->db = new mysqli('localhost', 'root', '', 'empre941_empregueme');
            $this->db = new mysqli('localhost', 'empre941_user', 'Empre#12', 'empre941_rede');
        if ($this->db->connect_error) {
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
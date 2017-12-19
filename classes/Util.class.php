<?php


class Util{

    private $str; // str passada como par�metro
    private $data; // Data passada como par�metro
    private $ret; // Retorno do M�todo
    private $arr_data; //Array que recebe os elementos da data D-M-Y ou Y-M-D conforme m�todo 
    private $data_banco;
    private $strResult;
    private $rs;
    private $row;
    private $erro;
    private $horario;
    private $sql;

    public function AntiInjection($str) {
        $this->str = $str;
// remove palavras que contenham sintaxe sql
        $this->str = preg_replace("/( from |select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/", "", $this->str);
        $this->str = trim($this->str);
        $this->str = strip_tags($this->str);
        //$this->str = eregi_replace("(\"|\')", "", $this->str);
        $this->str = (get_magic_quotes_gpc()) ? $this->str : addslashes($this->str);

//return utf8_encode(strtoupper(utf8_decode($this->str)));
        return $this->str;
    }

    public function FormataDataBanco($data) {
        $this->data = trim($data);
        if (strlen($this->data) != 10) {
            $this->ret = "";
        } else {
            $this->arr_data = explode("/", $data);
            $this->data_banco = $this->arr_data[2] . "-" . $this->arr_data[1] . "-" . $this->arr_data[0];
            $this->ret = $this->data_banco;
        }
        return $this->ret;
    }

    public function GetDataBanco($data) {
        $this->data = trim($data);
        if (strlen($this->data) != 10) {
            $this->ret = "";
        } else {
            $this->arr_data = explode("-", $data);
            $this->data_banco = $this->arr_data[2] . "/" . $this->arr_data[1] . "/" . $this->arr_data[0];
            $this->ret = $this->data_banco;
        }
        return $this->ret;
    }

    public function FormataHorario($horario) {

        $this->horario = explode(":", $horario);
        $this->horario = $this->horario[0] . ":" . $this->horario[1];
        $this->horario = $this->horario;

        return $this->horario;
    }

}

?>
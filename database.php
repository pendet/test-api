<?php
require 'config.php';

class Database {
    private $_connection;
    public $table;
    public $fieldsData;
    public $condition;

    public function __construct() 
    {
        $this->_connection = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        if (mysqli_connect_error()) {
            trigger_error('Connection failed: ' . mysqli_connect_error(), E_USER_ERROR);
        }
    }

    private function __clone() { }

    public function getConnection()
    {
        return $this->_connection;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getFieldsData()
    {
        return $this->fieldsData;
    }

    public function insertDb() 
    {
        $fields = implode("`,`",array_keys($this->fieldsData));
        $data = implode("','", $this->fieldsData);

        $sql = <<<SQL
    INSERT INTO $this->table (`$fields`,`dis_created_at`) VALUES('$data', NOW());
SQL;

        if ($this->_connection->query($sql)) {
            echo "data berhasil disimpan \n";
        } else {
            echo 'Error: ' . $sql . "\n" . $this->_connection->error;
        }
        $this->_connection->close();
    }

    public function updateDb()
    {
        $setValue = implode(',', array_map(array($this, '_setString'), array_keys($this->fieldsData), $this->fieldsData));
        $sql = <<<SQL
        UPDATE $this->table SET $setValue,`dis_updated_at`=NOW() WHERE $this->condition;
SQL;
        if ($this->_connection->query($sql)) {
            $this->_connection->close();
            return true;
        } else {
            $this->_connection->close();
            echo 'Error: ' . $sql . "\n" . $this->_connection->error;
        }
    }

    private function _setString($k, $v)
    {
        return "`$k`='$v'";
    }

}
?>
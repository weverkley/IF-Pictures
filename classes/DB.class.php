<?php
class DB
{
    
    private $_conn;
    private $_host = "localhost";
    private $_username = "root";
    private $_password = "";
    private $_database = "test";
    /*echo DB::$counter;*/
    public static $counter = 0;
    

    public function __construct() {
        mysqli_report(MYSQLI_REPORT_STRICT);
        try {
            $this->_conn = new mysqli($this->_host, $this->_username, $this->_password, $this->_database);
        }
        catch(Exception $e) {
            echo "Error Code: " . $e->getCode();
            echo "<br>Error Message: " . $e->getMessage();
        }
    }
    
    public function __destruct() {
        if ($this->_conn) $this->disconnect();
    }
    
    public function query($query) {
        self::$counter++;
        $full_query = $this->_conn->query($query);
        if ($this->_conn->error) return false;
        else return true;
    }
    
    public function insert($table, $data = array()) {
        self::$counter++;
        if (empty($data)) return false;
        
        $sql = "INSERT INTO " . $table;
        $fields = array();
        $values = array();
        foreach ($data as $field => $value) {
            $fields[] = $field;
            $values[] = "'" . $value . "'";
        }
        $fields = ' (' . implode(', ', $fields) . ')';
        $values = '(' . implode(', ', $values) . ')';
        
        $sql.= $fields . ' VALUES ' . $values;
        $query = $this->_conn->query($sql);
        
        if ($this->_conn->error) return false;
        else return true;
    }
    
    public function select($table, $where = '', $cols = '*', $operand = 'AND', $orderBy = '', $limit = '', $like = false) {
        self::$counter++;
        if (trim($table) == '') {
            return false;
        }
        
        $query = "SELECT {$cols} FROM `{$table}` WHERE ";
        if (is_array($where) && $where != '') {
            foreach ($where as $key => $value) {
                if ($like) {
                    $query.= "`{$key}` LIKE '%{$value}%' {$operand} ";
                } 
                else {
                    $query.= "`{$key}` = '{$value}' {$operand} ";
                }
            }
            $query = substr($query, 0, -(strlen($operand) + 2));
        } 
        else {
            $query = substr($query, 0, -6);
        }
        if ($orderBy != '') {
            $query.= ' ORDER BY ' . $orderBy;
        }
        if ($limit != '') {
            $query.= ' LIMIT ' . $limit;
        }
        $result = $this->_conn->query($query);
        if ($this->_conn->error) {
            return false;
        } 
        else {
            
            $row = array();
            while ($r = $result->fetch_assoc()) {
                $row[] = $r;
            }
            return $row;
        }
    }
    public function update($table, $data = array(), $where = array(), $limit = '') {
        self::$counter++;
        if (empty($data)) return false;
        
        $sql = "UPDATE " . $table . " SET ";
        foreach ($data as $field => $value) {
            
            $updates[] = "`$field` = '$value'";
        }
        
        $sql.= implode(', ', $updates);
        
        if (!empty($where)) {
            foreach ($where as $field => $value) {
                $value = $value;
                $clause[] = "$field = '$value'";
            }
            $sql.= ' WHERE ' . implode(' AND ', $clause);
        }
        
        if (!empty($limit)) {
            $sql.= ' LIMIT ' . $limit;
        }
        $query = $this->_conn->query($sql);
        if ($this->_conn->error) return false;
        else return true;
    }
    
    public function delete($table, $where = array(), $limit = '') {
        self::$counter++;
        
        if (empty($where)) {
            return false;
        }
        
        $sql = "DELETE FROM " . $table;
        foreach ($where as $field => $value) {
            $value = $value;
            $clause[] = "$field = '$value'";
        }
        $sql.= " WHERE " . implode(' AND ', $clause);
        
        if (!empty($limit)) {
            $sql.= " LIMIT " . $limit;
        }
        
        $query = $this->_conn->query($sql);
        if ($this->_conn->error) return false;
        else return true;
    }
    
    public function num_rows($query) {
        self::$counter++;
        $num_rows = $this->_conn->query($query);
        if ($this->_conn->error) {
            return false;
        } 
        else {
            return $num_rows->num_rows;
        }
    }
    
    public function db_common($value = '') {
        if (is_array($value)) {
            foreach ($value as $v) {
                if (preg_match('/AES_DECRYPT/i', $v) || preg_match('/AES_ENCRYPT/i', $v) || preg_match('/now()/i', $v)) {
                    return true;
                } 
                else {
                    return false;
                }
            }
        } 
        else {
            if (preg_match('/AES_DECRYPT/i', $value) || preg_match('/AES_ENCRYPT/i', $value) || preg_match('/now()/i', $value)) {
                return true;
            }
        }
    }
    
    public function exists($table = '', $check_val = '', $params = array()) {
        self::$counter++;
        if (empty($table) || empty($check_val) || empty($params)) {
            return false;
        }
        $check = array();
        foreach ($params as $field => $value) {
            if (!empty($field) && !empty($value)) {
                
                if ($this->db_common($value)) {
                    $check[] = "$field = $value";
                } 
                else {
                    $check[] = "$field = '$value'";
                }
            }
        }
        $check = implode(' AND ', $check);
        $rs_check = "SELECT $check_val FROM " . $table . " WHERE $check";
        $number = $this->num_rows($rs_check);
        if ($number === 0) {
            return false;
        } 
        else {
            return true;
        }
    }
    
    public function disconnect() {
        $this->_conn->close();
    }
}
?>
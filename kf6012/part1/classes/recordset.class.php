<?php
/**
* abstract class that creates a database connection and returns a recordset
* Follows the recordset pattern
*
* @author Tom Hegarty
*/
abstract class RecordSet {
    protected $conn;
    protected $stmt;

    function __construct($dbname) {
        $this->conn = PDOdb::getConnection($dbname);
    }

    /**
     * This function will execute the query as a prepared statement if there is a
     * params array. If not, it executes as a regular statament. 
     *
     * @param string $query  The sql query for the recordset
     * @param array $params  unrequired assoc array to set up preprepared statments
     * @return PDO_STATEMENT
     */
    function getRecordSet($query, $params = null) {
        if (is_array($params)) {
          $this->stmt = $this->conn->prepare($query);
          $this->stmt->execute($params);
        } else {
          $this->stmt = $this->conn->query($query);
        }
        return $this->stmt;
    }
}
?>
<?php
/**
* Return a JSON recordset
* @author Tom Hegarty
*/
class JSONRecordSet extends RecordSet {
    /**
     * function to return a record set as an associative array
     * all calls to the database will be handled by thsi class
     * 
     * @param $query   string with sql to execute to retrieve the record set
     * @param $params  optional associative array of params for sql query 
     * @return string  a json documnent
     */
    function getJSONRecordSet($query, $params = null) {
        $stmt = $this->getRecordSet($query, $params);
        $recordSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $nRecords = count($recordSet);
        return json_encode(array("status"=>"200", "count"=>$nRecords, "data"=>$recordSet));                 
    }
  }
?>
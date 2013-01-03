<?php
/**
 * Created by JetBrains PhpStorm.
 * User: adurmaz
 * Date: 28.12.2012
 * Time: 15:15
 * To change this template use File | Settings | File Templates.
 */
namespace saint\db;
class oracle extends dbAbstract
{

    /**
     * @var resource|null
     */
    private $connection = null;

    protected function connect(){
        $this->connection = $this->getConnection($this->dbName);
        if($this->connection == null) {
            $ociConnection = oci_connect($this->options['userName'], $this->options['password'], '//'.$this->options['serverName'].'/'.$this->options['SID']);
            if(!$ociConnection) {
                $oracleError = oci_error();
                throw new \Exception ('Oracle Connection Error ('.htmlentities($oracleError['message'], ENT_QUOTES).') ');
            }
            $this->setConnection($ociConnection, $this->dbName);
            $this->connection = $this->getConnection($this->dbName);
        }
    }

    public function get($query, $fetchType, $cacheTime = 0)
    {
        $result = null;
        $record = $this->execute($query);
        if($record === null || $record === false){
            return $result;
        }

        switch($fetchType) {
            case 'assoc' :
                $result = oci_fetch_assoc($record);
                break;
            case 'assocArray' :
                while ($row = oci_fetch_assoc($record)){
                    $result[] = $row;
                }
                break;
            case 'object' :
                $result = oci_fetch_object($record);
                break;
            case 'objectArray' :
                while ($row = oci_fetch_object($record)){
                    $result[] = $row;
                }
                break;
            case 'one' :
                $result = oci_fetch_assoc($record);
                $result = $result[0];
                break;
            case 'oneArray' :
                while ($row = oci_fetch_assoc($record)){
                    $result[] = $row[0];
                }
                break;
            default :
                throw new Exception ('Undefined fetch mode');
                break;
        }
        return $result;
    }

    public function execute($query)
    {
        if(! $this->connection) {
            $this->connect();
        }
        $statement = oci_parse($this->connection, $query);
        @$status = oci_execute($statement);
        if(!$status){
            $oracleError = oci_error();
            //throw new \Exception ('Oracle Execute Error ('.htmlentities($oracleError['message'], ENT_QUOTES).') ');
            $trace = debug_backtrace();
            trigger_error('Oracle Execute Error :'.htmlentities($oracleError['message'], ENT_QUOTES).' in '.$trace[0]['file'].' on line '. $trace[0]['line'], E_USER_NOTICE);
            return false;
        }
        return $statement;
    }

    public function getLastInsertedID()
    {
        // TODO: Implement getLastInsertedID() method.
    }

    public function getAffectedRows()
    {
        // TODO: Implement getAffectedRows() method.
    }

    public function getLastError()
    {
        // TODO: Implement getLastError() method.
    }
}

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
            $ociConnection = oci_connect($this->options['userName'], $this->options['password'], $this->options['serverName']);
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
        if($record === null){
            return $result;
        }

        switch($fetchType) {
            case 'assoc' :
                $result = $record->fetch_assoc();
                break;
            case 'assocArray' :
                while ($row = $record->fetch_assoc()){
                    $result[] = $row;
                }
                break;
            case 'object' :
                $result = $record->fetch_object();
                break;
            case 'objectArray' :
                while ($row = $record->fetch_object()){
                    $result[] = $row;
                }
                break;
            case 'one' :
                $result = $record->fetch_assoc();
                $result = $result[0];
                break;
            case 'oneArray' :
                while ($row = $record->fetch_assoc()){
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
        $status = oci_execute($statement);
        if(!$status){
            $oracleError = oci_error();
            throw new \Exception ('Oracle Connection Error ('.htmlentities($oracleError['message'], ENT_QUOTES).') ');
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

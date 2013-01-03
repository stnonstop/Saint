<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 26.12.2012
 * Time: 00:57
 * To change this template use File | Settings | File Templates.
 */
namespace saint\db;
class mysql extends dbAbstract
{
    /**
     * @var mysqli|null
     */
    private $connection = null;

    protected function connect(){
        $this->connection = $this->getConnection($this->dbName);
        if($this->connection == null) {
            $this->setConnection(new mysqli($this->options['serverName'], $this->options['userName'], $this->options['password'], $this->options['dbSchemaName']), $this->dbName);
            $this->connection = $this->getConnection($this->dbName);
            if(mysqli_error($this->connection)) {
                throw new \Exception ('MySQL Connection Error ('.mysqli_errno($this->connection).') '.mysqli_error($this->connection));
            }
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
                throw new \Exception ('Undefined fetch mode');
                break;
        }
        return $result;
    }

    public function execute($query)
    {
        if(! $this->connection) {
            $this->connect();
        }
        $result = $this->connection->query($query);
        if(mysqli_error($this->connection)){
            $result = null;
            throw new \Exception('MySQL Query Error ('.mysqli_errno($this->connection).') '.mysqli_error($this->connection));
        }
        return $result;
    }

    public function getLastInsertedID()
    {
        return $this->connection->insert_id;
    }

    public function getAffectedRows()
    {
        return $this->connection->affected_rows;
    }

    public function getLastError()
    {
        // TODO: Implement getLastError() method.
    }
}

<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nevriyedurmaz
 * Date: 21.12.2012
 * Time: 22:36
 * To change this template use File | Settings | File Templates.
 */
namespace saint\db;
class mongo extends dbAbstract
{
    /**
     * @var \MongoDB
     */
    private $mongoDB = null;

    /**
     * @var \MongoId
     */
    private $mongoId = null;

    private $count = 0;
    private $totalCount = 0;

    protected function connect() {
        $this->mongoDB = $this->getConnection($this->dbName);
        if($this->mongoDB == null){
            $serverName = $this->options['serverName'];
            $serverPort = $this->options['serverPort'];
            try {
                $mongo = new \Mongo('mongodb://'.$serverName.':'.$serverPort);
                $mongoDB = $mongo->selectDB($this->options['dbSchemaName']);
            } catch ( \MongoConnectionException $e ) {
                throw new \Exception('Mongo Connection Error : ' . $e->__toString());
            }
            $this->setConnection($mongoDB, $this->dbName);
            $this->mongoDB = $this->getConnection($this->dbName);
        }
    }

    public function get($query, $fetchType, $cacheTime = 0)
    {
        if( ! $this->mongoDB) {
            $this->connect();
        }

        if(! isset($query['collection'])) {
            throw new \Exception ('Undefined mongo collection');
        }

        $collection = new \MongoCollection($this->mongoDB, $query['collection']);

        if(! isset($sql['fields'])) {
            $sql['fields'] = array();
        }

        $result = null;

        switch($fetchType) {
            case 'assoc' :
                $result = $collection->findOne($query['query'],$query['fields']);
                break;
            case 'assocArray' :
                $cursor = $collection->find($query['query'], $query['fields']);
                if(isset($sql['limit'])) {
                    $cursor = $cursor->limit($query['limit']);
                }
                if(isset($sql['skip'])) {
                    $cursor = $cursor->skip($query['skip']);
                }
                if(isset($sql['sort'])) {
                    $cursor = $cursor->sort($query['sort']);
                }
                foreach ($cursor AS $doc){
                    $result[] = $doc;
                }
                if(isset($sql['count']) == true) {
                    $this->count = $cursor->count(true);
                }
                if(isset($sql['totalCount']) == true) {
                    $this->totalCount = $cursor->count(false);
                }
                break;
            case 'one' :
                $result = $collection->findOne($sql['query'], $sql['fields']);
                $result = $result[0];
                break;
            case 'oneArray' :
                $cursor = $collection->find($sql['query'], $sql['fields']);
                if(isset($sql['limit'])) {
                    $cursor = $cursor->limit($sql['limit']);
                }
                if(isset($sql['skip'])) {
                    $cursor = $cursor->skip($sql['skip']);
                }
                if(isset($sql['sort'])) {
                    $cursor = $cursor->sort($sql['sort']);
                }
                foreach($cursor AS $doc) {
                    $result[] = $doc[0];
                }
                if(isset($sql['count']) == true) {
                    $this->count = $cursor->count(true);
                }
                if(isset($sql['totalCount']) == true) {
                    $this->totalCount = $cursor->count(false);
                }
                break;
            case 'distinct' :
                if(!isset($sql['distinctKey'])) {
                    throw new \Exception ('Undefined distinctKey for distinct fetch type');
                    break;
                }
                $distinct = array('distinct' => $sql['collection'], 'key' => $sql['distinctKey']);
                $cursor = $this->mongoDB->command($distinct);
                $result = $cursor['values'];
                break;
            case 'mapReduce' :
                if(!isset($sql['map']) || !isset($sql['reduce']) ) {
                    throw new \Exception ('Undefined map or reduce function for mapReduce fetch type');
                    break;
                }
                $mapReduce = array(
                    'mapreduce' => $sql['collection'],
                    'map'       => $sql['map'],
                    'reduce'    => $sql['reduce'],
                    'out'       => $sql['mapReduced'],
                    'verbose'   => true
                );
                if( isset($sql['query']) && count($sql['query']) > 0){
                    $mapReduce['query'] = $sql['query'];
                }
                $mapInfo = $this->mongoDB->command($mapReduce);
                $mapCollection = $this->mongoDB->selectCollection($mapInfo['result']);
                $cursor = $mapCollection->find();
                if(isset($sql['limit'])) {
                    $cursor = $cursor->limit($sql['limit']);
                }
                if(isset($sql['sort'])) {
                    $cursor = $cursor->sort($sql['sort']);
                }
                foreach($cursor AS $doc) {
                    $result[] = $doc;
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
        if(! $this->mongoDB) {
            $this->connect();
        }
        $collection = new \MongoCollection($this->mongoDB, $query['collection']);

        if(isset($query['update']) && $query['update'] == true) {
            try{
                $collection->update($query['query'], array('$set' =>$query['data']), array("multiple" => true));
            } catch(\MongoCursorException $e) {
                throw new \Exception ('Mongo Update Error : '. $e->__toString());
            }
        } else {
            try {
                $collection->insert($query['data']);
                $this->mongoId = $query['data']['_id'];
            } catch(\MongoCursorException $e){
                throw new \Exception ('Mongo Insert Error : '. $e->__toString());
            }
        }

    }

    public function getLastInsertedID()
    {
        return $this->mongoId;
    }

    public function getAffectedRows()
    {
        return array('count' => $this->count, 'totalCount' => $this->totalCount);
    }

    public function getLastError()
    {
        return $this->mongoDB->lastError();
    }
}

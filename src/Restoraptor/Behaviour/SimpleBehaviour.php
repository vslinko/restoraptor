<?php

namespace Restoraptor\Behaviour;

use Restoraptor\Filter\FilterManager;

use MongoDate,
    MongoDb,
    MongoId;

class SimpleBehaviour
{
    protected $db;
    protected $filter;
    protected $softDelete;

    public function __construct(MongoDb $db, FilterManager $filter, $softDelete = true)
    {
        $this->db = $db;
        $this->filter = $filter;
        $this->softDelete = $softDelete;
    }

    public function listCollection($collectionName)
    {
        $query = $this->filter->filter($collectionName);
        return $this->db->selectCollection($collectionName)->find($query);
    }

    public function dropCollection($collectionName)
    {
        return $this->db->selectCollection($collectionName)->drop();
    }

    public function createDocument($collectionName, $document)
    {
        $this->db->selectCollection($collectionName)->insert($document);
        return $document;
    }

    public function readDocument($collectionName, $id)
    {
        $query = $this->filter->filter($collectionName);
        $query = array_merge($query, ['_id' => new MongoId($id)]);

        return $this->db->selectCollection($collectionName)->findOne($query);
    }

    public function updateDocument($collectionName, $id, $fields)
    {
        $this->db->selectCollection($collectionName)->update(['_id' => new MongoId($id)], ['$set' => $fields]);
    }

    public function deleteDocument($collectionName, $id)
    {
        if ($this->softDelete) {
            $this->db->selectCollection($collectionName)->update(['_id' => new MongoId($id)], ['$set' => ['deleted-at' => new MongoDate()]]);
        } else {
            $this->db->selectCollection($collectionName)->remove(['_id' => new MongoId($id)]);
        }
    }
}

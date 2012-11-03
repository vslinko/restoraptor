<?php

namespace Restoraptor\Behaviour;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RestBehaviour extends SimpleBehaviour
{
    public function readDocument($collectionName, $id)
    {
        $document = parent::readDocument($collectionName, $id);

        if (!$document) {
            throw new NotFoundHttpException();
        }

        return $document;
    }

    public function updateDocument($collectionName, $id, $fields)
    {
        $this->readDocument($collectionName, $id);

        parent::updateDocument($collectionName, $id, $fields);
    }

    public function deleteDocument($collectionName, $id)
    {
        $this->readDocument($collectionName, $id);

        parent::deleteDocument($collectionName, $id);
    }
}

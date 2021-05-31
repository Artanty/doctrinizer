<?php

namespace App\Repositories;

use App\Dtos\TagDto\RequestDto\TagCreateDto;
use App\Dtos\TagDto\RequestDto\TagDeleteDto;
use App\Dtos\TagDto\RequestDto\TagUpdateDto;
use App\Entities\ProductTag\ProductTag;
use App\Entities\Tag\Tag;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\EntityManagerInterface;
use App\Exceptions\DatabaseException;
use App\Repositories\Contracts\TagRepositoryInterface;
use Throwable;

class DoctrineTagRepository implements TagRepositoryInterface
{
    protected $resultSetMapping;
    private $entityManager;

    public function __construct(ResultSetMapping $resultSetMapping, EntityManagerInterface $entityManager)
    {
        $this->resultSetMapping = $resultSetMapping;
        $this->entityManager = $entityManager;
    }

    public function find(int $id = null, int $customerId = null)
    {
        try {
            $params = [];
            if ($id != null) {
                $params["id"] = $id;
            }
            $params["customerId"] = $customerId;
            $queryString = 'SELECT t';
            $queryString = $queryString . ' FROM App\Entities\Tag\Tag t';
            $queryString = $queryString . ' WHERE t.removed IS NULL AND t.customerId = :customerId';
            $queryString = $queryString . ' AND ((t.timestampTo IS NULL) OR (t.timestampTo > CURRENT_TIMESTAMP()))';
            if ($id != null) {
                $queryString = $queryString . ' AND t.id = :id';
            }

            $query = $this->entityManager->createQuery($queryString)->setParameters($params);
            $tags = $query->getArrayResult();
            return $tags;
        } catch (Throwable $e) {
            throw new DatabaseException($e->getMessage());
        }
    }

    public function create(TagCreateDto $tag)
    {
        try {
            $this->resultSetMapping->addEntityResult(Tag::class, 'tag');
            $this->resultSetMapping->addFieldResult('tag', 'Id', 'id');
            $sql = 'SELECT * FROM "TagAdd"(:Value,:CustomerId,:TimestampTo)';
            $query = $this->entityManager->createNativeQuery($sql, $this->resultSetMapping);
            $query->setParameter("Value", $tag->value);
            $query->setParameter("CustomerId", $tag->customerId);
            $query->setParameter("TimestampTo", $tag->timestampTo);
            $tag = $query->getOneOrNullResult();
            return $tag;
        } catch (Throwable $e) {
            throw New DatabaseException($e->getMessage());
        }
    }

    public function update(TagUpdateDto $tag)
    {
        try {
            $this->resultSetMapping->addEntityResult(Tag::class, 'tag');
            $this->resultSetMapping->addFieldResult('tag', 'Result', 'id');
            $sql = 'SELECT * FROM "TagUpdate"(:Id,:Value,:CustomerId,:Removed,:TimestampTo)';
            $query = $this->entityManager->createNativeQuery($sql, $this->resultSetMapping);
            $query->setParameter("Id", $tag->id);
            $query->setParameter("CustomerId", $tag->customerId);
            $query->setParameter("Value", $tag->value);
            $query->setParameter("Removed", $tag->removed);
            $query->setParameter("TimestampTo", $tag->timestampTo);
            $result = $query->getOneOrNullResult();

            return $result;
        } catch (Throwable $e) {
            throw New DatabaseException($e->getMessage());
        }
    }

    public function delete(TagDeleteDto $tag)
    {
        try {
            $this->resultSetMapping->addEntityResult(Tag::class, 'tag');
            $this->resultSetMapping->addFieldResult('tag', 'Result', 'id');
            $sql = 'SELECT * FROM "TagRemove"(:Id,:CustomerId,:Removed)';
            $query = $this->entityManager->createNativeQuery($sql, $this->resultSetMapping);
            $query->setParameter("Id", $tag->id);
            $query->setParameter("CustomerId", $tag->customerId);
            $query->setParameter("Removed", $tag->removed);
            $result = $query->getOneOrNullResult();

            return $result;
        } catch (Throwable $e) {
            throw New DatabaseException($e->getMessage());
        }
    }
}

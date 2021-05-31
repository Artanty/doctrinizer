<?php

namespace App\Services;

use App\Dtos\TagDto\RequestDto\TagCreateDto;
use App\Dtos\TagDto\RequestDto\TagDeleteDto;
use App\Dtos\TagDto\RequestDto\TagSearchParamsDto;
use App\Dtos\TagDto\RequestDto\TagUpdateDto;
use App\Exceptions\DatabaseException;
use App\Exceptions\MessageException;
use App\Exceptions\ServiceException;
use App\Repositories\Contracts\TagRepositoryInterface;
use App\Repositories\Contracts\TopicItemRepositoryInterface;
use App\Repositories\Contracts\UnitOfWorkInterface;
use App\Services\Contracts\TagServiceInterface;
use App\Transformers\TagTransformers\TagTransformer;
use Doctrine\DBAL\DBALException;
use Throwable;

class TagService implements TagServiceInterface
{
    private $unitOfWork;
    private $tags;
    private $topicItems;
    private $tagTransformer;

    public function __construct(
        UnitOfWorkInterface $unitOfWork,
        TagRepositoryInterface $tags,
        TopicItemRepositoryInterface $topicItems,
        TagTransformer $tagTransformer
    ) {
        $this->unitOfWork = $unitOfWork;
        $this->tags = $tags;
        $this->topicItems = $topicItems;
        $this->tagTransformer = $tagTransformer;
    }

    /**
     *
     * Поиск хэштегов. Если передан идентификатор
     * будет возвращен один хэштег. Если не передан -
     * будут возвращены все хэштеги по заказчику.
     *
     */
    public function find(TagSearchParamsDto $searchParams)
    {
        try {
            $result = $this->unitOfWork->commitTransactional(function () use ($searchParams) {
                return $this->tags->find($searchParams->id, $searchParams->customerId);
            });

            return is_array($result) ? $this->tagTransformer->transform($result) : null;
        } catch (Throwable $e) {
            if ($e instanceof DBALException || $e instanceof DatabaseException) {
                throw new DatabaseException($e->getMessage());
            } else {
                throw new ServiceException($e->getMessage());
            }
        }
    }

    /**
     *
     * Создание хэштега
     *
     */
    public function create(TagCreateDto $tag)
    {
        try {
            $result = $this->unitOfWork->commitTransactional(function () use ($tag) {
                $newTag = $this->tags->create($tag);
                $tag->id = $newTag->getId();
                return $tag;
            });
            return ($result) ? $this->tagTransformer->transform($result) : null;
        } catch (Throwable $e) {
            if ($e instanceof DBALException || $e instanceof DatabaseException) {
                throw new DatabaseException($e->getMessage());
            } else {
                throw new ServiceException($e->getMessage());
            }
        }
    }

    /**
     *
     * Обновление хэштега
     *
     */
    public function update(TagUpdateDto $tag)
    {
        try {
            $result = $this->unitOfWork->commitTransactional(function () use ($tag) {
                $newTag = $this->tags->update($tag);
                $tag->id = $newTag->getId();
                return $tag;
            });
            return $result;
        } catch (Throwable $e) {
            if ($e instanceof DBALException || $e instanceof DatabaseException) {
                throw new DatabaseException($e->getMessage());
            } else {
                throw new ServiceException($e->getMessage());
            }
        }
    }

    /**
     *
     * Пометка хэштега неактивным
     *
     */
    public function delete(TagDeleteDto $tag)
    {
        try {
            $this->unitOfWork->commitTransactional(function () use ($tag) {
                $topicItems = $this->topicItems->findByTagId($tag->id, $tag->customerId);
                if (count($topicItems) > 0) {
                    throw new MessageException("Не возможно удалить тег. Необходимо удалить все связки.");
                }
                $newTag = $this->tags->delete($tag);
                $tag->id = $newTag->getId();
                return $tag;
            });
            return true;
        } catch (Throwable $e) {
            if ($e instanceof DBALException || $e instanceof DatabaseException) {
                throw new DatabaseException($e->getMessage());
            } else if ($e instanceof MessageException) {
                throw new MessageException($e->getMessage());
            } else {
                throw new ServiceException($e->getMessage());
            }
        }
    }
}

<?php

namespace App\Repositories\Contracts;

use App\Dtos\TagDto\RequestDto\TagCreateDto;
use App\Dtos\TagDto\RequestDto\TagDeleteDto;
use App\Dtos\TagDto\RequestDto\TagUpdateDto;

interface TagRepositoryInterface
{
    public function find(int $id = null, int $customerId = null);

    public function create(TagCreateDto $tag);

    public function update(TagUpdateDto $tag);

    public function delete(TagDeleteDto $tag);
}

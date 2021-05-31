<?php

namespace App\Services\Contracts;

use App\Dtos\TagDto\RequestDto\TagCreateDto;
use App\Dtos\TagDto\RequestDto\TagDeleteDto;
use App\Dtos\TagDto\RequestDto\TagSearchParamsDto;
use App\Dtos\TagDto\RequestDto\TagUpdateDto;

interface TagServiceInterface
{
    public function find(TagSearchParamsDto $searchParams);

    public function create(TagCreateDto $updateParams);

    public function update(TagUpdateDto $updateParams);

    public function delete(TagDeleteDto $tag);
}

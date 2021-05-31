<?php

namespace App\Dtos\TagDto\RequestDto;

class TagSearchParamsDto
{
    public ?int $id;
    public ?string $value;
    public int $customerId;
    public ?int $removed;
}

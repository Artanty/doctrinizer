<?php

namespace App\Dtos\TagDto\RequestDto;

class TagUpdateDto
{
    public int $id;
    public string $value;
    public int $customerId;
    public ?string $timestampTo;
}

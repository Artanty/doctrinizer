<?php

namespace App\Dtos\TagDto\RequestDto;

class TagCreateDto
{
    public ?int $id;
    public ?string $value;
    public int $customerId;
    public ?int $removed = null;
    public ?string $timestampTo;
}

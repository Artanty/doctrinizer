<?php

namespace App\Dtos\TagDto\RequestDto;

class TagDeleteDto
{
    public int $id;
    public string $value;
    public int $customerId;
    public ?int $removed = null;
}

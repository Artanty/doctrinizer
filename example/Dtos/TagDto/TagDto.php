<?php

namespace App\Dtos\TagDto;

class TagDto
{
    public int $id;
    public string $value;
    public int $customerId;
    public ?int $removed = null;
    public ?string $timestampTo = null;
}

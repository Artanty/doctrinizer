<?php

namespace App\Transformers\TagTransformers;

use App\Dtos\TagDto\RequestDto\TagCreateDto;
use App\Dtos\TagDto\TagDto;
use AutoMapperPlus\AutoMapper;
use AutoMapperPlus\Configuration\AutoMapperConfig;
use AutoMapperPlus\MappingOperation\Operation;

class TagTransformer
{

    private $autoMapper;

    public function __construct()
    {
        $this->autoMapper = AutoMapper::initialize(function (AutoMapperConfig $config) {
            $config->registerMapping('array', TagDto::class);
            $config->registerMapping(TagCreateDto::class, TagDto::class);
        });
    }

    public function transform($tags)
    {   if (is_array($tags)) {
            return $this->autoMapper->mapMultiple($tags, TagDto::class);
        }
        if ($tags instanceof TagCreateDto) {
            return $this->autoMapper->map($tags, TagDto::class);
        }
    }
}

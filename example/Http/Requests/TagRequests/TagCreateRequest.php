<?php

namespace App\Http\Requests\TagRequests;

use App\Dtos\TagDto\RequestDto\TagCreateDto;
use Illuminate\Foundation\Http\FormRequest;

class TagCreateRequest extends FormRequest
{
    private $createTagDto;

    public function __construct(TagCreateDto $createTagDto)
    {
        $this->createTagDto = $createTagDto;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'value' => 'required'
        ];
    }

    public function messages()
    {
        return [
            '*.required' => 'Value required..',
        ];
    }

    public function data()
    {
        $this->createTagDto->id = null;
        $this->createTagDto->value = $this->value;
        $this->createTagDto->removed = $this->removed ?? null;
        $this->createTagDto->timestampTo = $this->timestampTo ?? null;
        $this->createTagDto->customerId = $this->user()->getCustomerId();
        return $this->createTagDto;
    }
}

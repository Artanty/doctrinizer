<?php

namespace App\Http\Requests\TagRequests;

use App\Dtos\TagDto\RequestDto\TagUpdateDto;
use Illuminate\Foundation\Http\FormRequest;

class TagUpdateRequest extends FormRequest
{
    private $updateTagDto;

    public function __construct(TagUpdateDto $updateTagDto)
    {
        $this->updateTagDto = $updateTagDto;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required',
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
        $this->updateTagDto->id = $this->id;
        $this->updateTagDto->value = $this->value;
        $this->updateTagDto->removed = $this->removed ?? 0;
        $this->updateTagDto->timestampTo = $this->timestampTo ?? null;
        $this->updateTagDto->customerId = $this->user()->getCustomerId();
        return $this->updateTagDto;
    }
}

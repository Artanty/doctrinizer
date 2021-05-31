<?php

namespace App\Http\Requests\TagRequests;

use App\Dtos\TagDto\RequestDto\TagDeleteDto;
use Illuminate\Foundation\Http\FormRequest;

class TagDeleteRequest extends FormRequest
{
    private $deleteTagDto;

    public function __construct(TagDeleteDto $deleteTagDto)
    {
        $this->deleteTagDto = $deleteTagDto;
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
        $this->deleteTagDto->id = $this->id;
        $this->deleteTagDto->value = $this->value;
        $this->deleteTagDto->removed = $this->removed ?? null;
        $this->deleteTagDto->customerId = $this->user()->getCustomerId();
        return $this->deleteTagDto;
    }
}

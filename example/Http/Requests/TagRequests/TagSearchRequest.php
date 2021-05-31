<?php

namespace App\Http\Requests\TagRequests;

use App\Dtos\TagDto\RequestDto\TagSearchParamsDto;
use Illuminate\Foundation\Http\FormRequest;

class TagSearchRequest extends FormRequest
{
    private $searchTagDto;

    public function __construct(TagSearchParamsDto $searchTagDto)
    {
        $this->searchTagDto = $searchTagDto;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
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
        $this->searchTagDto->id = $this->id;
        $this->searchTagDto->value = $this->value;
        $this->searchTagDto->removed = $this->removed;
        $this->searchTagDto->customerId = $this->user()->getCustomerId();
        return $this->searchTagDto;
    }
}

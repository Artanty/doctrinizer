<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequests\TagCreateRequest;
use App\Http\Requests\TagRequests\TagDeleteRequest;
use App\Http\Requests\TagRequests\TagSearchRequest;
use App\Http\Requests\TagRequests\TagUpdateRequest;
use App\Services\Contracts\TagServiceInterface;

class TagController extends Controller
{
    public $tagService;

    public function __construct(TagServiceInterface $tagService)
    {
        $this->tagService = $tagService;
    }

    public function create(TagCreateRequest $request)
    {
        $data = $request->data();
        $result = $this->tagService->create($data);
        return response()->json(["errorCode" => 0, "errorMessage" => "", "data" => $result], 200);
    }

    public function update(TagUpdateRequest $request)
    {
        $data = $request->data();
        $result = $this->tagService->update($data);
        return response()->json(["errorCode" => 0, "errorMessage" => "", "data" => $result], 200);
    }

    public function delete(TagDeleteRequest $request)
    {
        $data = $request->data();
        $result = $this->tagService->delete($data);
        return response()->json(["errorCode" => 0, "errorMessage" => "", "data" => $result], 200);
    }

    public function search(TagSearchRequest $request)
    {
        $data = $request->data();
        $result = $this->tagService->find($data);
        return response()->json(["errorCode" => 0, "errorMessage" => "", "data" => $result], 200);
    }
}

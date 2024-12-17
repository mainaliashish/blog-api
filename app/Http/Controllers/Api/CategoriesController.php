<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoriesController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return $this->sendResponse(CategoryResource::collection($categories), 'Categories retrieved successfully.');
    }
}

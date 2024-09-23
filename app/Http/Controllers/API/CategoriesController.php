<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $response = Categories::all();

            return jsonResponse($response, 200, 'Successfully retrieved the list of category!');
        } catch (Exception $e) {
            return jsonResponse(null, Response::HTTP_NO_CONTENT, $e->getMessage());
        }
    }

}
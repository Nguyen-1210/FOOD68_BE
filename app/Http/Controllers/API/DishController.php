<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CategoryDish;
use App\Models\Dish;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class DishController extends Controller
{
    public function index()
    : JsonResponse {
        try {
            $dish = Dish::orderBy('status', 'ASC')->paginate(10);

            return jsonResponse($dish, 200, 'Get dish list was successful!');
        } catch (Exception $e) {
            return jsonResponse(null, 500, $e->getMessage());
        }
    }

    public function getListDishWithCategory(Request $request): JsonResponse
    {
        try {
            $categoryDish = CategoryDish::with('dish')
                ->where('category_id', $request->query('category_id'))
                ->get();
                // dd($categoryDish);
            $currentPage = Request::get('page', 1);
            $response = $categoryDish->map(function ($dish) {
                return [
                    'id' => $dish->dish->id,
                    'name' => $dish->dish->name,
                    'original_price' => $dish->dish->original_price,
                    'note' => $dish->dish->note,
                    'thumbnail' => $dish->dish->thumbnail,
                    'status' => $dish->dish->status,
                ];
            })->forPage($currentPage, 10)->sortBy('status')->values();

            return jsonResponse($response, 200, 'Get dish list was successful!');
        } catch (Exception $e) {
            return jsonResponse(null, 500, $e->getMessage());
        }
    }
}
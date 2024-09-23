<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KitchenController extends Controller
{
    public function getOrderDish(): JsonResponse
    {
        try {
            $data = OrderDetail::where('accept', OrderDetail::ACCEPTED)
                ->whereDate('updated_at', Carbon::today())
                ->where('updated_at', '<', Carbon::now())
                ->orderBy('priority', 'desc')
                ->orderBy('created_at', 'asc')
                ->orderBy('status', 'asc')->get();

            return jsonResponse($data, 200, 'Get order successfully');
        } catch (Exception $e) {
            return jsonResponse(null, Response::HTTP_NO_CONTENT, $e->getMessage());
        }
    }

    public function handleDishCooking(Request $request): JsonResponse
    {
        try {
            $dataRequest = $request->validate([
                'dishs' => 'required|array',
                'dishs.*.dish_id' => 'required|integer|exists:order_detail,dish_id',
            ]);
            foreach ($dataRequest['dishs'] as $dish) {
                OrderDetail::where('dish_id', $dish['dish_id'])->update([
                    'status' => OrderDetail::STATUS_COOKING,
                ]);
            }
            return jsonResponse(null, 200, 'Update status successfully');
        } catch (Exception $e) {
            return jsonResponse(null, Response::HTTP_NO_CONTENT, $e->getMessage());
        }
    }

    public function handleDishDone(Request $request): JsonResponse
    {
        try {
            $dataRequest = $request->validate([
                'dishs' => 'required|array',
                'dishs.*.dish_id' => 'required|integer|exists:order_detail,dish_id',
            ]);
            foreach ($dataRequest['dishs'] as $dish) {
                OrderDetail::where('dish_id', $dish['dish_id'])->update([
                    'status' => OrderDetail::STATUS_DONE,
                ]);
            }
            return jsonResponse(null, 200, 'Update status successfully');
        } catch (Exception $e) {
            return jsonResponse(null, Response::HTTP_NO_CONTENT, $e->getMessage());
        }
    }
}
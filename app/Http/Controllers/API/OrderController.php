<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dish;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\TableOrder;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{
    public function orderDish(Request $request): JsonResponse
    {
        try {
            $dataRequest = $request->validate([
                'table_order_id' => 'required|integer|exists:table_order,id',
                'note' => 'nullable',
                'staff_id' => 'required|integer|exists:users,id',
                'items' => 'required|array',
                'items.*.dish_id' => 'required|integer|exists:dishs,id',
                'items.*.priority' => 'nullable|integer',
                'items.*.quantity' => 'required|integer',
                'items.*.note' => 'nullable',
                'items.*.status' => 'nullable|integer',
            ]);
            $dish = null;
            DB::beginTransaction();
            try {
                if (isset($dataRequest['items']) && is_array($dataRequest['items'])) {
                    $data = Order::create([
                        'note' => $dataRequest['note'],
                        'table_order_id' => $dataRequest['table_order_id'],
                    ]);
                    TableOrder::where('id', $dataRequest['table_order_id'])->update([
                        'status' => TableOrder::DISHES_ARE_ON,
                    ]);
                    $itemsGrouped = collect($dataRequest['items'])->groupBy('dish_id');
                    foreach ($itemsGrouped as $dishId => $groupedItems) {
                        $dish = Dish::find($dishId);
                        
                        foreach ($groupedItems as $item) {
                            OrderDetail::updateOrCreate([
                                'staff_id' => $dataRequest['staff_id'],
                                'order_id' => $data->id,
                                'priority' => $item['priority'] ?? '0',
                                'dish_id' => $item['dish_id'],
                                'price' => $dish->original_price,
                                'quantity' => $item['quantity'],
                                'note' => $item['note'],
                                'status' => $item['status'] ?? OrderDetail::STATUS_PENDING,
                            ]);
                        }
                    }
                }
                DB::commit();
                return jsonResponse($data, 200, 'Order successfully');
            } catch (Throwable $e) {
                DB::rollBack();
                return jsonResponse($e->getMessage(), 400, 'Error');
            }

        } catch (Exception $e) {
            return jsonResponse(null, 500, $e->getMessage());
        }
    }

    public function handleTotalPrice(Request $request): JsonResponse
    {
        try {
            $dataRequest = $request->validate([
                'table_order_id' => 'required|integer|exists:table_order,id',
            ]);
            $orders = $this->getTotalAcceptedPrice($dataRequest['table_order_id']);

            return jsonResponse($orders, 200, 'Get total price successfully');
        } catch (Exception $e) {
            return jsonResponse(null, 500, $e->getMessage());
        }
    }

    public function getTotalAcceptedPrice($tableOrderId)
    {
        $orders = Order::with(['orderDetail' => function ($query) {
            $query->where('accept', OrderDetail::ACCEPTED);
        }])->where('table_order_id', $tableOrderId)->get();
    
        foreach ($orders as $order) {
            $totalPrice = 0;
            foreach ($order->orderDetail as $detail) {
                $totalPrice += $detail->price * $detail->quantity;
            }
            $order->update([
                'total_price' => $totalPrice,
            ]);
        }
    
        return $orders;
    }

    public function getOrder(Request $request): JsonResponse
    {
        try {
            $tableOrderId = TableOrder::where('table_id', $request->query('table_id'))->where('status', TableOrder::DISHES_ARE_ON)->pluck('id')->first();
            if (!$tableOrderId) {
                throw new Exception('Table order not found');
            }
            $orders = Order::with([
                'orderDetail',
                'tableOrder',
            ])->where('table_order_id', $tableOrderId)->get();

            $response = $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'id_table' => $order->tableOrder->table->id,
                    'flood_name' => $order->tableOrder->table->floor->name,
                    'table_name' => $order->tableOrder->table->name,
                    'customer_name' => $order->tableOrder->customer->user_name,
                    'customer_phone' => $order->tableOrder->customer->phone,
                    'dish_item' => $order->orderDetail->map(function ($item) {
                        $price_dish = $item->dish->original_price * $item->quantity;
                        return [
                            'dish_id' => $item->dish_id,
                            'dish_name' => $item->dish->name,
                            'dish_price' => $item->dish->original_price,
                            'dish_quantity' => $item->quantity,
                            'dish_thumbnail' => $item->dish->thumbnail,
                            'dish_price_total' => $price_dish,
                            'dish_order_note' => $item->note,
                        ];
                    }),
                ];
            });

            return jsonResponse($response, 200, 'Get order detail successfully');
        } catch (Exception $e) {
            return jsonResponse(null, 500, $e->getMessage());
        }
    }

    public function handleAcceptDish(Request $request): JsonResponse
    {
        try {
            $dataRequest = $request->validate([
                'table_order_id' => 'required|integer|exists:table_order,id',
                'items' => 'required|array',
                'items.*.dish_id' => 'required|integer|exists:order_detail,dish_id',
            ]);
            $itemsGrouped = collect($dataRequest['items'])->groupBy('dish_id');
            $tableOrder = TableOrder::find($dataRequest['table_order_id']);
            if (!$tableOrder) {
                throw new Exception('Table order not found');
            }
            foreach ($itemsGrouped as $dishId => $groupedItems) {
                foreach ($groupedItems as $item) {
                    OrderDetail::where('dish_id', $item['dish_id'])->update([
                        'accept' => OrderDetail::ACCEPTED,
                    ]);
                }
            }
            return jsonResponse(null, 200, 'Update status successfully');

        } catch (Exception $e) {
            return jsonResponse(null, 500, $e->getMessage());
        }
    }

}
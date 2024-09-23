<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TableRequestOrder;
use App\Models\Customers;
use App\Models\SettingSystem;
use App\Models\Table;
use App\Models\TableOrder;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TableController extends Controller
{
    public function getListTableWithFloor(Request $request): JsonResponse
    {
        try {
            $data = Table::where('floor_id', $request->query('floor_id'))
                ->with(['table_order' => function ($query) {
                    $query->whereRaw('NOW() > DATE_SUB(order_date, INTERVAL ' . $this->getHourTable() . '  HOUR)')
                        ->where('order_date', '>', now())
                        ->orderBy('order_date');
                }])
                ->where('active', 0)
                ->get();

            return jsonResponse($data, Response::HTTP_OK, 'Get table list was successful!');
        } catch (Exception $e) {

            return jsonResponse(null, Response::HTTP_NO_CONTENT, $e->getMessage());
        }
    }

    public function orderTable(TableRequestOrder $request)
    : JsonResponse {
        try {
            $dataRequest = $request->validated();

            $timeOpenSetting = Carbon::parse(SettingSystem::getHourOpen());
            $timeCloseSetting = Carbon::parse(SettingSystem::getHourClose());

            $timeOrder = Carbon::parse($dataRequest['order_date'])->format('H:i:s');

            if (Carbon::parse($timeOrder)->lessThan($timeOpenSetting)) {
                return jsonResponse(null, Response::HTTP_BAD_REQUEST, 'Giờ đặt bàn phải sau giờ mở cửa');
            } elseif (Carbon::parse($timeOrder)->greaterThan($timeCloseSetting)) {
                return jsonResponse(null, Response::HTTP_BAD_REQUEST, 'Giờ đặt bàn phải trước giờ đóng cửa');
            } else {
                $customer = Customers::where('phone', $dataRequest['phone'])->first();
                if (!$customer) {
                    $customer = $this->storeCustomer($dataRequest);
                } else {
                  // dd($customer);
                    $customer->update([
                        'user_name' => $dataRequest['user_name'],
                    ]);
                }

                $tableOrders = TableOrder::where('table_id', $dataRequest['table_id'])
                    ->orderBy('order_date', 'desc')
                    ->get();
                $table = new TableOrder();
                if ($tableOrders->isNotEmpty()) {
                    $orderTimes = [];
                    foreach ($tableOrders as $order) {
                        $orderTimes[] = Carbon::parse($order->order_date);
                    }

                    $newOrderDate = Carbon::parse($dataRequest['order_date']);

                    foreach ($orderTimes as $previousOrderDate) {
                        $hoursDifference = $newOrderDate->diffInHours($previousOrderDate);

                        if ($hoursDifference <= $this->getHourTable()) {
                            return jsonResponse(null, Response::HTTP_BAD_REQUEST, 'Bàn đã được đặt');
                        }
                    }
                }
            }

            $table = TableOrder::create([
                'table_id' => $dataRequest['table_id'],
                'customer_id' => $customer->id,
                'order_date' => $dataRequest['order_date'],
            ]);

            return jsonResponse($table, 200, 'Đặt bàn thành công');
        } catch (Exception $e) {
            return jsonResponse(null, 500, 'Đặt bàn thất bại');
        }
    }

    public function storeCustomer($dataRequest)
    {
        return Customers::create([
            'user_name' => $dataRequest['user_name'],
            'phone' => $dataRequest['phone'],
        ]);
    }

    public function getHourTable()
    {
        $timeSetting = SettingSystem::getHourTable();
        $hours = substr($timeSetting, 0, 2);
        $minutes = substr($timeSetting, 3, 2);
        $seconds = substr($timeSetting, 6, 2);

        $totalHours = (int) $hours + ((int) $minutes / 60) + ((int) $seconds / 3600);
        return $totalHours;
    }
}
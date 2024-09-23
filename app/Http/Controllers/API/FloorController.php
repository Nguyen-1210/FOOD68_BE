<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class FloorController extends Controller
{
  public function index(): JsonResponse
  {
      try {
          $floor = Floor::orderBy('ordering', 'ASC')->get();

          return jsonResponse($floor, Response::HTTP_OK,
              'Successfully retrieved the list of floors!');
      } catch (Exception $e) {
          return jsonResponse(null, Response::HTTP_NO_CONTENT, $e->getMessage());
      }
  }
}
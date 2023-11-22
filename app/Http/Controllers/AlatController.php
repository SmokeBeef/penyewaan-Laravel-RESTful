<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\alat\AlatCreateRequest;
use App\Http\Requests\alat\AlatUpdateRequest;
use App\Models\Alat;
use App\Services\Alat\AlatService;
use App\Services\Alat\AlatServiceImplement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AlatController extends Controller
{
    private string $keyRedis = "alatList";
    private $alatSerive;
    public function __construct(AlatService $alatSerive)
    {
        $this->alatSerive = $alatSerive;
    }
    public function create(AlatCreateRequest $req): JsonResponse
    {
        $payload = $req->validated();

        $this->alatSerive->create($payload);

        return response()->json([
            "message" => "success",
        ], 201);
    }
    public function findAll(): JsonResponse
    {

        $alat = $this->alatSerive->getAll();
        return response()->json([
            "message" => "success",
            "data" => $alat
        ]);

    }
    public function update(AlatUpdateRequest $req, $id): JsonResponse
    {
        $payload = $req->validated();
        if (!$payload) {
            return response()->json([
                "errors" => "nothing to update"
            ], 400);
        }

        $alat = $this->alatSerive->update($id, $payload);
        if (!$alat) {
            return response()->json([
                "errors" => "id " . $id . " not found",
            ], 404);
        }
        
        return response()->json([
            "message" => "success",
            "data" => $alat
        ]);
    }
    public function destroy($id): JsonResponse
    {
        $alat = $this->alatSerive->destroy($id);
        if (!$alat) {
            return response()->json([
                "errors" => "id " . $id . " not found",
            ], 404);
        }

        return response()->json([
            "message" => "success",
            "data" => $alat
        ]);
    }
}


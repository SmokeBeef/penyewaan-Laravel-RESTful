<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\alat\AlatCreateRequest;
use App\Http\Requests\alat\AlatUpdateRequest;
use App\Models\Alat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AlatController extends Controller
{
    private string $keyRedis = "alatList";
    public function create(AlatCreateRequest $req): JsonResponse
    {
        $payload = $req->validated();
        $alat = new Alat($payload);
        $alat->save();
        Redis::del($this->keyRedis);
        return response()->json([
            "message" => "success",
        ], 201);
    }
    public function findAll(): JsonResponse
    {
        if (Redis::exists($this->keyRedis)) {
            return response()->json([
                "message" => "success",
                "data" => json_decode(Redis::get($this->keyRedis)),
            ]);
        }

        $alat = Alat::all();
        Redis::set($this->keyRedis, $alat);
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
        $alat = Alat::find($id);
        if (!$alat) {
            return response()->json([
                "errors" => "id " . $id . " not found",
            ], 404);
        }
        $alat->update($payload);
        Redis::del($this->keyRedis);
        return response()->json([
            "message" => "success",
            "data" => $alat
        ]);
    }
    public function destroy($id): JsonResponse
    {
        $alat = Alat::find($id);
        if (!$alat) {
            return response()->json([
                "errors" => "id " . $id . " not found",
            ], 404);
        }
        $alat->delete();
        Redis::del($this->keyRedis);
        return response()->json([
            "message" => "success",
            "data" => $alat
        ]);
    }
}


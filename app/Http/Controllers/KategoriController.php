<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\kategori\KategoriCreateRequest;
use App\Models\Kategori;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Nette\Utils\Strings;

class KategoriController extends Controller
{
    public function create(KategoriCreateRequest $req): JsonResponse
    {
        $payload = $req->validated();


        if (Kategori::where("nama", $payload["nama"])->exists()) {
            return response()->json([
                "errors" => ["nama kategori sudah tersedia"],
            ], 400);
        }

        $kategori = new Kategori($payload);
        $kategori->save();

        return response()->json([
            "message" => "success",
            "data" => $kategori,
        ], 201);
    }

    public function findAll(Request $req): JsonResponse
    {
        $kategori = Kategori::all();

        return response()->json([
            "message" => "success",
            "data" => $kategori,
        ], 200);
    }
    public function update(KategoriCreateRequest $req, $id): JsonResponse
    {
        $payload = $req->validated();


        $kategori = Kategori::find(+$id);
        if (!$kategori) {
            return response()->json([
                "errors" => ["id " . $id . " tidak ditemukan"],
            ], 404);
        }
        if (Kategori::where("nama", $payload["nama"])->exists()) {
            return response()->json([
                "errors" => ["nama kategori sudah tersedia"],
            ], 409);
        }
        $kategori->update($payload);
        $kategori->save();
        return response()->json([
            "message" => "success",
            "data" => $kategori,
        ], 200);

    }
    public function destroy($id): JsonResponse
    {
        $kategori = Kategori::find(+$id);
        if (!$kategori) {
            return response()->json([
                "errors" => ["id " . $id . " tidak ditemukan"],
            ], 404);
        }
        $kategori->delete();
        return response()->json([
            "message" => "success",
            "data" => $kategori
        ], 200);
    }
}

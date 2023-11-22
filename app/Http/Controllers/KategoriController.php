<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\kategori\KategoriCreateRequest;
use App\Models\Kategori;
use App\Services\Kategori\KategoriService;
use Illuminate\Http\Client\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Nette\Utils\Strings;

class KategoriController extends Controller
{
    private $kategoriService;
    public function __construct(KategoriService $kategoriService)
    {
        $this->kategoriService = $kategoriService;
    }
    public function create(KategoriCreateRequest $req): JsonResponse
    {
        $payload = $req->validated();

        $kategori = $this->kategoriService->create($payload);

        return response()->json([
            "message" => "success",
            "data" => $kategori,
        ], 201);
    }

    public function findAll(): JsonResponse
    {
        $kategori = $this->kategoriService->getAll();

        return response()->json([
            "message" => "success",
            "data" => $kategori,
        ], 200);
    }
    public function findKategoriAlat($id): JsonResponse
    {
        $kategori = $this->kategoriService->getByIdJoin($id);
        if (!$kategori) {
            return response()->json(["errors" => "id " . $id . " not found"], 404);
        }
        return response()->json([
            "message" => "success",
            "data" => $kategori
        ], 200);
    }

    public function update(KategoriCreateRequest $req, $id): JsonResponse
    {
        $payload = $req->validated();


        $kategori = $this->kategoriService->update($id, $payload);
        if (!$kategori) {
            return response()->json([
                "errors" => ["id " . $id . " tidak ditemukan"],
            ], 404);
        }
        return response()->json([
            "message" => "success",
            "data" => $kategori,
        ], 200);

    }
    public function destroy($id): JsonResponse
    {
        $kategori = $this->kategoriService->destroy($id);
        if (!$kategori) {
            return response()->json([
                "errors" => "id " . $id . " tidak ditemukan",
            ], 404);
        }
        return response()->json([
            "message" => "success",
            "data" => $kategori
        ], 200);
    }
}

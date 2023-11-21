<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Http\Requests\pelanggan\PelangganCreateRequest;
use App\Http\Requests\pelanggan\PelangganDataCreateRequest;
use App\Http\Requests\pelanggan\PelangganUpdateRequest;
use App\Models\Pelanggan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller
{
    private int $DEFAULT_LIMIT;
    private $MAX_LIMIT;

    public function __construct()
    {
        $this->DEFAULT_LIMIT = env("DEFAULT_LIMIT", 10);
        $this->MAX_LIMIT = env("MAX_LIMIT", 10);
    }
    public function create(PelangganCreateRequest $req, PelangganDataCreateRequest $reqData): JsonResponse
    {
        $payload = $req->validated();
        $data = $reqData->validated();

        $currentTimeStamp = time();
        $photo = $req->file("file");
        $filename = Str::uuid() . "-" . $photo->getClientOriginalName();
        $path = "foto-pelanggan/" . $filename;
        
        Storage::disk("public")->put($path, file_get_contents($photo));
        $data["file"] = "storage/".$path;


        $pelanggan = Pelanggan::create($payload);
        // dd($pelanggan);
        $pelanggan->pelanggan_data()->create($data);

        $pelanggan->push();
        return response()->json([
            "message" => "success",
            "data" => $pelanggan
        ]);
    }

    public function findAll(Request $req): JsonResponse
    {
        $limit = $this->DEFAULT_LIMIT;
        $offset = 0;
        if ($req->has("item")) {
            $limit = $req->query("item");
        }
        if ($req->has("page")) {
            $offset = +$req->query("page") == 0 ? 0 : (+$req->query("page") - 1) * ($limit);
        }

        $pelanggans = Pelanggan::limit($limit)->offset($offset)->get();
        $totalPelanggan = Pelanggan::count();
        return response()->json([
            "message" => "success",
            "data" => $pelanggans,
            "meta" => [
                "total_data" => $totalPelanggan,
                "total_page" => ceil($totalPelanggan / $limit),
                "data_per_page" => $limit,
                "current_page" => $offset == 0 ? 1 : $offset / $limit,
            ]
        ]);
    }
    public function findAllFull(Request $req): JsonResponse
    {
        $limit = $this->DEFAULT_LIMIT;
        $offset = 0;
        if ($req->has("item")) {
            $limit = $req->query("item");
        }
        if ($req->has("page")) {
            $offset = +$req->query("page") == 0 ? 0 : (+$req->query("page") - 1) * ($limit);
        }

        $pelanggans = Pelanggan::with("pelanggan_data")->limit($limit)->offset($offset)->get();
        // DB::select("SELECT p.*, pd.jenis as data, pd.file as data FROM pelanggans as p LEFT JOIN pelanggan_datas as pd on p.id = pd.pelanggan_id");
        // dd($pelanggans);
        $totalPelanggan = Pelanggan::count();
        return response()->json([
            "message" => "success",
            "data" => $pelanggans,
            "meta" => [
                "total_data" => $totalPelanggan,
                "total_page" => ceil($totalPelanggan / $limit),
                "data_per_page" => $limit,
                "current_page" => $offset == 0 ? 1 : $offset / $limit,
            ]
        ]);
    }

    public function findOneFull($id): JsonResponse
    {
        $pelanggans = Pelanggan::with("pelanggan_data")->find(+$id);
        if (!$pelanggans) {
            return response()->json([
                "errors" => "id " . $id . " not found",
            ], 404);
        }
        return response()->json([
            "message" => "success",
            "data" => $pelanggans
        ]);
    }

    public function update(PelangganUpdateRequest $req, $id): JsonResponse
    {
        $data = $req->validated();

        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return response()->json([
                "errors" => "id " . $id . " tidak di temukan",
            ], 404);
        }
        $pelanggan->update($data);
        return response()->json([
            "message" => "success",
            "data" => $data
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $pelanggan = Pelanggan::find($id);
        if (!$pelanggan) {
            return response()->json([
                "errors" => "id " . $id . " tidak ditemukan",
            ], 404);
        }
        $pelanggan->delete();
        return response()->json([
            "message" => "success",
            "data" => $pelanggan
        ]);
    }

}

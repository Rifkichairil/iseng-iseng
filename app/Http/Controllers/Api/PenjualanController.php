<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PenjualanCollection;
use App\Http\Resources\PenjualanResource;
use App\Models\Barang;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    //
    public function index()
    {
        $data = Penjualan::with('customer')->get();
        if (!$data) {
            return response()->json([
                'message' => 'No Content'
            ], 204);
        }
        return response()->json([
            'data' => PenjualanCollection::collection($data)
        ]);
    }

    public function detail($id)
    {
        $data = Penjualan::with('customer', 'barang')->whereid($id)->first();
        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }
        return response()->json([
            'data' => new PenjualanResource($data)
        ]);
    }

    public function update(Request $request, $id)
    {
        $data   = Penjualan::with('customer', 'barang')->whereid($id)->first();
        $barang = Barang::whereId($data->barang_id)->first();

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        if ($request->qty > $barang->stock) {
            return response()->json([
                'message' => 'Stok Barang tidak mencukupi'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $data->update([
                'qty' => $request->qty
            ]);

            if ($request->qty > $data->qty) {
                # code...
                $total = $request->qty - $data->qty;
                $barang->stock = ($request->qty + $barang->stock) - ($total);
            }

            if ($request->qty < $data->qty) {
                # code...
                $total = $data->qty - $request->qty;
                $barang->stock = ($request->qty + $barang->stock) + ($total);
            }

            $barang->save();


        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();
        return response()->json([
            'message' => 'Berhasil update data!'
        ], 200);
    }

    public function publish($id)
    {
        $data = Penjualan::whereId($id)->first();

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan!'
            ], 404);
        }

        if ($data->is_publish == 1) {
            return response()->json([
                'message' => 'Data sudah anda publish!'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $data->update([
                'is_publish' => 1
            ]);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        DB::commit();
        return response()->json([
            'message' => 'Berhasil publish data!'
        ], 200);
    }

}

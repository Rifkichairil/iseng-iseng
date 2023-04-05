<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PenjualanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'kode_barang' => $this->barang->kode_barang,
            'nama_barang' => $this->barang->nama_barang,
            'qty'         => $this->qty,
            'price'       => $this->barang->price,
            'total'       => $this->barang->price * $this->qty,
            'publish'     => $this->is_publish
        ];
    }
}

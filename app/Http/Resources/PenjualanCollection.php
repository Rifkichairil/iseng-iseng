<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PenjualanCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'no_faktur' => $this->no_faktur,
            'tanggal_faktur' => $this->tanggal_faktur,
            'total_item' => $this->total_item,
            'total_faktur' => $this->total_faktur,
            'qty' => $this->qty,
            'customer' => $this->customer->nama_customer,
        ];
    }
}

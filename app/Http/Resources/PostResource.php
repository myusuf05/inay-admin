<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = 4 * 4;
        return [
            'id Santri' => $this->id_santri,
            'nama' => $this->nama,
            'whatEver' => $data
        ];
    }
    /*
    open resource berfungsi menentukan data apa saja yang mau ditampilkan pada api resource yang berada pada tabel atau database 
    */
}

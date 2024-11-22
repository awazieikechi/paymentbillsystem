<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'balance' => number_format($this->balance, 2),
            'transactions' => $this->transactions()->count(),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),

        ];
    }
}

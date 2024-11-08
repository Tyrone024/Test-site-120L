<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserspaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'workspace_id' => $this->workspace_id,
            'is_admin' => $this->is_admin,
            'request' => $this->request
        ];
    }
}
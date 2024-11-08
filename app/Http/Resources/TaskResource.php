<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'detail' => $this->detail,
            'is_completed' => $this->is_completed,
            'workspace_id' => $this->workspace_id
        ];
    }
}
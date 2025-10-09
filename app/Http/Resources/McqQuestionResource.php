<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class McqQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'question' => $this->title,
            'options' => $this->options,
            'allows_attachments' => $this->allows_attachments,
            'requires_attachment' => $this->requires_attachment,
            'score' => $this->score,
            'sort_order' => $this->sort_order,
            'category' => $this->category,
        ];
    }
}

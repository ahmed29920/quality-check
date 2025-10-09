<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderAnswerResource extends JsonResource
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
            'provider_id' => $this->provider_id,
            'question_id' => $this->question_id,
            'answer' => $this->answer,
            'attachment' => $this->attachment,
            'attachment_url' => $this->attachment_url,
            'score' => $this->score,
            'is_correct' => $this->is_correct,
            'is_evaluated' => $this->is_evaluated,
            'submitted_at' => $this->submitted_at?->format('Y-m-d H:i:s'),
            'evaluated_at' => $this->evaluated_at?->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),

            // Relationships
            'provider' => $this->whenLoaded('provider', function () {
                return [
                    'id' => $this->provider->id,
                    'name' => $this->provider->name,
                    'slug' => $this->provider->slug,
                ];
            }),
            'question' => $this->whenLoaded('question', function () {
                return [
                    'id' => $this->question->id,
                    'title' => $this->question->title,
                    'score' => $this->question->score,
                    'allows_attachments' => $this->question->allows_attachments,
                    'requires_attachment' => $this->question->requires_attachment,
                ];
            }),
        ];
    }
}

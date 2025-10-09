<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProviderResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'slug' => $this->slug,
            'image' => $this->image,
            'pdf' => $this->pdf,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'address' => $this->address,
            'website_link' => $this->website_link,
            'established_date' => $this->established_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'is_active' => $this->is_active,
            'is_verified' => $this->is_verified,
            'attachment_url' => $this->attachment_url,
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),

            // Relationships
            'category' => $this->whenLoaded('category', function () {
                return [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                ];
            }),
            'badge' => $this->whenLoaded('badge', function () {
                return [
                    'id' => $this->badge->id,
                    'name' => $this->badge->name,
                ];
            }),
        ];
    }
}

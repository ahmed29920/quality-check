<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => [
                'en' => $this->getTranslation('name', 'en'),
                'ar' => $this->getTranslation('name', 'ar'),
            ],
            'description' => [
                'en' => $this->getTranslation('description', 'en'),
                'ar' => $this->getTranslation('description', 'ar'),
            ],
            'slug' => $this->slug,
            'image_url' => $this->image_url,
            'is_active' => $this->is_active,
            'has_pricable_services' => $this->has_pricable_services,
            'monthly_subscription_price' => $this->monthly_subscription_price,
            'yearly_subscription_price' => $this->yearly_subscription_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Include relationships when loaded
            'questions_count' => $this->whenLoaded('questions', function () {
                return $this->questions->count();
            }),
            'services_count' => $this->whenLoaded('services', function () {
                return $this->services->count();
            }),
            
            'services' => ServiceResource::collection($this->whenLoaded('services')),
        ];
    }
}
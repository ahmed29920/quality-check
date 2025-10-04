<?php

namespace App\Services;

use App\Repositories\ServiceRepository;
use App\Models\Service;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceService
{
    protected $serviceRepository, $categoryRepository;

    public function __construct(ServiceRepository $repository, CategoryRepository $categoryRepository)
    {
        $this->serviceRepository = $repository;
        $this->categoryRepository = $categoryRepository;
    }

    public function all()
    {
        return $this->serviceRepository->all();
    }
    public function allWithTrashed()
    {
        return $this->serviceRepository->allWithTrashed();
    }

    public function getQuery()
    {
        return $this->serviceRepository->getQuery();
    }

    public function active($limit)
    {
        return $this->serviceRepository->active($limit);
    }


    public function findById($id)
    {
        return $this->serviceRepository->findById($id);
    }
    public function findBySlug($slug)
    {
        return $this->serviceRepository->findBySlug($slug);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {

            if (isset($data['image'])) {
                $imagePath = $data['image']->store('services', 'public');
                $data['image'] = $imagePath;
            }

            $data['slug'] = Str::slug($data['name']['en']);

            $category = $this->categoryRepository->findById($data['category_id']);
            $data['is_pricable'] = $category->has_pricable_services ?? false;

            $service = $this->serviceRepository->create($data);

            return $service;
        });
    }

    public function update(array $data, Service $service)
    {
        return DB::transaction(function () use ($data, $service) {

            if (isset($data['image'])) {

                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }

                $imagePath = $data['image']->store('services', 'public');
                $data['image'] = $imagePath;
            }


            $data['slug'] = Str::slug($data['name']['en']);
            $service = $this->serviceRepository->update($data, $service);



            return $service;
        });
    }


    public function delete(Service $service)
    {
        return $this->serviceRepository->delete($service);
    }

    public function restore($slug)
    {
        $service = $this->serviceRepository->findWithTrashedBySlug($slug);
        return $this->serviceRepository->restore($service);
    }

    public function forceDelete($slug)
    {
        $service = $this->serviceRepository->findWithTrashedBySlug($slug);

        return $this->serviceRepository->forceDelete($service);
    }

    public function filter(array $filters)
    {
        return $this->serviceRepository->filter($filters);
    }
    
}

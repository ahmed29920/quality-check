<?php 

namespace App\Services;

use App\Repositories\BadgeRepository;
use App\Models\Badge;

class BadgeService
{
    protected $badgeRepository;

    public function __construct(BadgeRepository $repository)
    {
        $this->badgeRepository = $repository;
    }

    public function all()
    {
        return $this->badgeRepository->all();
    }

    public function find($id)
    {
        return $this->badgeRepository->find($id);
    }

    public function create(array $data)
    {
        return $this->badgeRepository->create($data);
    }

    public function update(array $data, Badge $badge)
    {
        return $this->badgeRepository->update($data, $badge);
    }

    public function delete($id)
    {
        return $this->badgeRepository->delete($id);
    }
}

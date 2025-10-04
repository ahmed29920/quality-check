<?php

namespace App\Repositories;

use App\Models\Badge;

class BadgeRepository
{
    public function all()
    {
        return Badge::get();
    }

    public function find($id)
    {
        return Badge::findOrFail($id);
    }

    public function create(array $data)
    {
        return Badge::create($data);
    }

    public function update(array $data,Badge $badge)
    {
        return $badge->update($data);
    }

    public function delete(Badge $badge)
    {
        return $badge->delete();
    }

}

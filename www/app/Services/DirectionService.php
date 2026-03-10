<?php

namespace App\Services;

use App\Models\Direction;

class DirectionService
{
    public function getFilteredDirections(array $filters, int $perPage = 10)
    {
        $query = Direction::query()->select([
            'id',
            'organization_id',
            'code',
            'name',
            'degree'
        ]);

        if (!empty($filters['search_code'])) {
            $query->where('code', 'like', '%'.$filters['search_code'].'%');
        }

        if (!empty($filters['search_name'])) {
            $query->where('name', 'like', '%'.$filters['search_name'].'%');
        }

        if (!empty($filters['search_degree'])) {
            $query->where('degree', $filters['search_degree']);
        }

        return $query->paginate(min($perPage, 100))->withQueryString();
    }

    public function createDirection(array $data)
    {
        return Direction::create($data);
    }

    public function updateDirection(Direction $direction, array $data)
    {
        return $direction->update($data);
    }

    public function deleteDirection(Direction $direction)
    {
        return $direction->delete();
    }
}

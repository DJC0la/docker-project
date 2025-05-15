<?php

namespace App\Services;

use App\Models\Program;

class ProgramService
{
    public function getFilteredPrograms(array $filters, int $perPage = 10)
    {
        $query = Program::query()->with('direction');

        if (!empty($filters['search_name'])) {
            $query->where('name', 'like', '%'.$filters['search_name'].'%');
        }

        if (!empty($filters['search_direction'])) {
            $query->whereHas('direction', function($q) use ($filters) {
                $q->where('name', 'like', '%'.$filters['search_direction'].'%');
            });
        }

        return $query->paginate(min($perPage, 100))->withQueryString();
    }

    public function createProgram(array $data)
    {
        return Program::create($data);
    }

    public function updateProgram(Program $program, array $data)
    {
        return $program->update($data);
    }

    public function deleteProgram(Program $program)
    {
        return $program->delete();
    }
}

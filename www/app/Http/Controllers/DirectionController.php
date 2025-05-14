<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DirectionStoreRequest;
use App\Http\Requests\DirectionUpdateRequest;
use App\Models\Direction;
use App\Services\DirectionService;
use App\Enums\TypesRole;

class DirectionController extends Controller
{
    public function __construct(
        protected DirectionService $directionService
    ) {}

    public function index(Request $request)
    {
        $showUserTable = auth()->user()->hasRole(TypesRole::ADMIN);

        $directions = $showUserTable
            ? $this->directionService->getFilteredDirections(
                $request->only(['search_code', 'search_name', 'search_degree']),
                $request->input('perPage', 10)
            )
            : Direction::query()->paginate($request->input('perPage', 10));

        return view('direction', [
            'directions' => $directions,
            'showUserTable' => $showUserTable
        ]);
    }

    public function store(DirectionStoreRequest $request)
    {
        $this->directionService->createDirection($request->validated());

        return redirect()->route('direction')
            ->with('success', 'Direction created successfully.');
    }

    public function update(DirectionUpdateRequest $request, Direction $direction)
    {
        $this->directionService->updateDirection($direction, $request->validated());

        return redirect()->route('direction')
            ->with('success', 'Direction updated successfully.');
    }

    public function destroy(Direction $direction)
    {
        $this->directionService->deleteDirection($direction);

        return redirect()->route('direction')
            ->with('success', 'Direction deleted successfully.');
    }
}

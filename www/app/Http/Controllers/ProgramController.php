<?php

namespace App\Http\Controllers;

use App\Http\Requests\FiltrationRequest;
use App\Http\Requests\ProgramStoreRequest;
use App\Http\Requests\ProgramUpdateRequest;
use App\Models\Program;
use App\Models\Direction;
use App\Services\ProgramService;
use App\Services\DirectionService;
use App\Enums\TypesRole;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function __construct(
        private ProgramService $programService,
        private DirectionService $directionService
    ) {}

    public function index(FiltrationRequest $request)
    {
        $showUserTable = auth()->user()->is_hasRole(TypesRole::ADMIN);

        $programs = $showUserTable
            ? $this->programService->getFilteredPrograms(
                [
                    $validated['search_name'] ?? null,
                    $validated['search_email'] ?? null,
                ],
                $validated['perPage'] ?? 10
            )
            : Program::with('direction')->paginate($request->input('perPage', 10));

        return view('program', [
            'programs' => $programs,
            'directions' => $this->directionService->getAllIds(),
            'showUserTable' => $showUserTable
        ]);
    }

    public function store(ProgramStoreRequest $request)
    {
        $this->programService->createProgram($request->validated());

        return redirect()->route('program')
            ->with('success', 'Program created successfully.');
    }

    public function update(ProgramUpdateRequest $request, Program $program)
    {
        $this->programService->updateProgram($program, $request->validated());

        return redirect()->route('program')
            ->with('success', 'Program updated successfully');
    }

    public function destroy(Program $program)
    {
        $this->programService->deleteProgram($program);

        return redirect()->route('program')
            ->with('success', 'Program deleted successfully.');
    }
}

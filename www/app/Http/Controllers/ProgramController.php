<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgramStoreRequest;
use App\Http\Requests\ProgramUpdateRequest;
use App\Models\Program;
use App\Models\Direction;
use App\Services\ProgramService;
use App\Enums\TypesRole;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function __construct(
        protected ProgramService $programService
    ) {}

    public function index(Request $request)
    {
        $showUserTable = auth()->user()->hasRole(TypesRole::ADMIN);

        $programs = $showUserTable
            ? $this->programService->getFilteredPrograms(
                $request->only(['search_name', 'search_direction']),
                $request->input('perPage', 10)
            )
            : Program::with('direction')->paginate($request->input('perPage', 10));

        $directions = Direction::all();

        return view('program', [
            'programs' => $programs,
            'directions' => $directions,
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

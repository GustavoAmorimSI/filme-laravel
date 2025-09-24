<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; 
class ExerciseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Exercise::where('user_id', $user->id);
        
        if ($request->filled('data_inicio')) {
            $dataInicio = Carbon::parse($request->data_inicio)->startOfDay();
            $query->where('data', '>=', $dataInicio);
        }
        
        if ($request->filled('data_fim')) {
            $dataFim = Carbon::parse($request->data_fim)->endOfDay();
            $query->where('data', '<=', $dataFim);
        }
        
        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
        
        $exercises = $query->orderBy('data', 'desc')->paginate(10);
        
        return view('exercises.index', compact('exercises'));
    }

    public function create()
    {
        return view('exercises.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'duracao' => 'required|integer|min:1',
            'calorias_gastas' => 'required|integer|min:0',
            'data' => 'required|date',
        ]);

        $data['user_id'] = Auth::id();
        $data['data'] = Carbon::parse($data['data']); 
        
        Exercise::create($data);

        return redirect()->route('exercises.index')
                         ->with('success', 'Exercício criado com sucesso.');
    }

    public function show(Exercise $exercise)
    {
        if ($exercise->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('exercises.show', compact('exercise'));
    }

    public function edit(Exercise $exercise)
    {
        $this->authorize('update', $exercise);
        
        return view('exercises.edit', compact('exercise'));
    }

    public function update(Request $request, Exercise $exercise)
    {
        $this->authorize('update', $exercise);

        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'duracao' => 'required|integer|min:1',
            'calorias_gastas' => 'required|integer|min:0',
            'data' => 'required|date',
        ]);

        $data['data'] = Carbon::parse($data['data']);
        
        $exercise->update($data);

        return redirect()->route('exercises.index')
                         ->with('success', 'Exercício atualizado com sucesso.');
    }

    public function destroy(Exercise $exercise)
    {
        $this->authorize('delete', $exercise);

        $exercise->delete();

        return redirect()->route('exercises.index')
                         ->with('success', 'Exercício removido com sucesso.');
    }
}
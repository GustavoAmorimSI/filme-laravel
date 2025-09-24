<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        if ($request->filled('data_inicio') && $request->filled('data_fim')) {
            $query->whereBetween('data', [$request->data_inicio, $request->data_fim]);
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
            'nome' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u' // Aceita apenas letras, espaços e hífens
            ],
            'duracao' => 'required|integer|min:1',
            'calorias_gastas' => 'required|integer|min:0',
            'data' => 'required|date|before_or_equal:today',
        ], [
            'nome.regex' => 'O nome da atividade deve conter apenas letras, espaços e hífens. Não são permitidos números ou caracteres especiais.',
            'data.before_or_equal' => 'A data não pode ser maior que hoje.',
        ]);

        $data['user_id'] = Auth::id();
        Exercise::create($data);

        return redirect()->route('exercises.index')
                         ->with('success', 'Exercício criado com sucesso.');
    }

    public function edit(Exercise $exercise)
    {
        if ($exercise->user_id !== Auth::id()) {
            abort(403);
        }
        return view('exercises.create', compact('exercise'));
    }

    public function update(Request $request, Exercise $exercise)
    {
        if ($exercise->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'nome' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s\-]+$/u' // Aceita apenas letras, espaços e hífens
            ],
            'duracao' => 'required|integer|min:1',
            'calorias_gastas' => 'required|integer|min:0',
            'data' => 'required|date|before_or_equal:today',
        ], [
            'nome.regex' => 'O nome da atividade deve conter apenas letras, espaços e hífens. Não são permitidos números ou caracteres especiais.',
            'data.before_or_equal' => 'A data não pode ser maior que hoje.',
        ]);

        $exercise->update($data);

        return redirect()->route('exercises.index')
                         ->with('success', 'Exercício atualizado com sucesso.');
    }

    public function destroy(Exercise $exercise)
    {
        if ($exercise->user_id !== Auth::id()) {
            abort(403);
        }

        $exercise->delete();

        return redirect()->route('exercises.index')
                         ->with('success', 'Exercício removido com sucesso.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->custom_authorize('browse_animals');

        return view('parameters.animals.browse');
    }

    public function list(){

        $search = request('search') ?? null;
        $paginate = request('paginate') ?? 10;

        $data = Animal::query()
            // El método when() hace lo mismo que tu "if($search)"
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('id', $search)
                      ->orWhere('name', 'like', "%$search%")
                      ->orWhere('observation', 'like', "%$search%");
                });
            })
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->paginate($paginate);

        return view('parameters.animals.list', compact('data'));
    }

    public function show($id)
    {
        $this->custom_authorize('read_animals');

        $item = Animal::where('id', $id)
            ->where('deleted_at', null)
            ->first();

        return view('parameters.animals.read', compact('item'));
    }
}

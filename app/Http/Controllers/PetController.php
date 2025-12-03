<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public $storageController;
    public function __construct()
    {
        $this->middleware('auth');
        $this->storageController = new StorageController();
    }

    public function index()
    {
        $this->custom_authorize('browse_pets');

        return view('administrations.pets.browse');
    }

    public function list(){

        $search = request('search') ?? null;
        $paginate = request('paginate') ?? 10;

        $data = Pet::query()
            ->with(['person', 'animal', 'race'])
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhereHas('person', function($query) use ($search) {
                          $query->where('first_name', 'like', "%$search%")
                                ->orWhere('last_name', 'like', "%$search%")
                                ->orWhere(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%$search%");
                      })
                      ->orWhereHas('animal', function($query) use ($search) {
                          $query->where('name', 'like', "%$search%");
                      })
                      ->orWhereHas('race', function($query) use ($search) {
                          $query->where('name', 'like', "%$search%");
                      });
                });
            })
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->paginate($paginate);

        return view('administrations.pets.list', compact('data'));
    }

    public function create()
    {
        $this->custom_authorize('add_pets');
        return view('administrations.pets.edit-add');
    }

    public function store(Request $request)
    {
        $this->custom_authorize('add_pets');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'person_id' => 'required|exists:people,id',
            'animal_id' => 'required|exists:animals,id',
            'race_id' => 'required|exists:races,id',
            'gender' => 'required|string',
            'color' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('voyager.pets.create')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $pet = new Pet($request->all());
            $pet->status = 1; // O 'active'

            if ($request->hasFile('image')) {
                $pet->image = $this->storageController->store_image($request->file('image'), 'pets');
            }

            $pet->save();

            DB::commit();
            return redirect()->route('voyager.pets.index')->with(['message' => 'Mascota registrada exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al registrar mascota: ' . $e->getMessage());
            return redirect()->route('voyager.pets.create')->with(['message' => 'Ocurrió un error al registrar la mascota.', 'alert-type' => 'error'])->withInput();
        }
    }
}

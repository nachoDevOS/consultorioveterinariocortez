<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use App\Models\Pet;
use App\Models\Race;
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

        $data = Pet::with(['person', 'animal', 'race'])
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhereHas('person', function($query) use ($search) {
                          $query->where('first_name', 'like', "%$search%")
                                ->orWhere('paternal_surname', 'like', "%$search%")
                                ->orWhere('maternal_surname', 'like', "%$search%")
                                ->orWhere(DB::raw("CONCAT(first_name, ' ', COALESCE(paternal_surname, ''), ' ', COALESCE(maternal_surname, ''))"), 'like', "%$search%");
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

        // dump($data);

        // return $data;

        return view('administrations.pets.list', compact('data'));
    }

    public function create()
    {
        $this->custom_authorize('add_pets');
        $animals = Animal::where('deleted_at', null)->get();
        return view('administrations.pets.edit-add', compact('animals'));
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

    public function show($id)
    {
        $this->custom_authorize('read_pets');
        $pet = Pet::with(['person', 'animal', 'race'])->findOrFail($id);

        return view('administrations.pets.read', compact('pet'));
    }

    public function edit($id)
    {
        $this->custom_authorize('edit_pets');
        $pet = Pet::with(['person'])->findOrFail($id);
        $animals = Animal::whereNull('deleted_at')->get();
        $races = Race::where('animal_id', $pet->animal_id)->whereNull('deleted_at')->get();

        return view('administrations.pets.edit-add', compact('pet', 'animals', 'races'));
    }

    public function update(Request $request, $id)
    {
        $this->custom_authorize('edit_pets');

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'person_id' => 'required|exists:people,id',
            'animal_id' => 'required|exists:animals,id',
            'race_id' => 'nullable|exists:races,id',
            'gender' => 'required|string',
            'color' => 'nullable|string|max:255',
            'birthdate' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('voyager.pets.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        try {
            $pet = Pet::findOrFail($id);
            $pet->fill($request->all());

            if ($request->hasFile('image')) {
                // Eliminar imagen anterior si existe
                if ($pet->image) {
                    $this->storageController->delete($pet->image);
                }
                $pet->image = $this->storageController->store_image($request->file('image'), 'pets');
            }

            $pet->save();

            DB::commit();
            return redirect()->route('voyager.pets.index')->with(['message' => 'Mascota actualizada exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar mascota: ' . $e->getMessage());
            return redirect()->route('voyager.pets.edit', $id)->with(['message' => 'Ocurrió un error al actualizar la mascota.', 'alert-type' => 'error'])->withInput();
        }
    }

    public function destroy($id)
    {
        $this->custom_authorize('delete_pets');

        DB::beginTransaction();
        try {
            $pet = Pet::findOrFail($id);
            $pet->delete(); // Asumiendo que el modelo Pet usa SoftDeletes

            DB::commit();
            return redirect()->route('voyager.pets.index')->with(['message' => 'Mascota eliminada exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al eliminar mascota: ' . $e->getMessage());
            return redirect()->route('voyager.pets.index')->with(['message' => 'Ocurrió un error al eliminar la mascota.', 'alert-type' => 'error']);
        }
    }


}

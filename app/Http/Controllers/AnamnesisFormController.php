<?php

namespace App\Http\Controllers;

use App\Models\AnamnesisForm;
use App\Models\AnamnesisItemStock;
use App\Models\Animal;
use App\Models\ItemStock;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AnamnesisFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Pet $pet)
    {
        // Reutilizamos la misma vista para crear y editar
        $animals = Animal::with('races')->get();
        $anamnesis = new AnamnesisForm(); // Un objeto vacío para el modo 'create'
        $dataTypeContent = $anamnesis; // Para compatibilidad con la vista
        return view('administrations.pets.edit-add-history', compact('pet', 'animals', 'dataTypeContent'));
    }

    public function listByPet(Pet $pet)
    {
        // Opcional: puedes añadir un permiso específico para ver el historial
        // $this->custom_authorize('read_pet_histories');

        $search = request('search') ?? null;
        $paginate = request('paginate') ?? 5; // Paginamos de 5 en 5, puedes cambiarlo

        $data = AnamnesisForm::with(['doctor'])
            ->where('pet_id', $pet->id)
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('main_problem', 'like', "%$search%")
                      ->orWhere('date', 'like', "%$search%")
                      ->orWhereHas('doctor', function($query) use ($search) {
                          $query->where('name', 'like', "%$search%");
                      });
                });
            })
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate($paginate);
        return view('administrations.pets.history-list', compact('data', 'pet'));
    }

    public function edit(AnamnesisForm $anamnesis)
    {
        $pet = $anamnesis->pet;
        $animals = Animal::with('races')->get();

        // Decodificar el JSON de animales convivientes para que el select2 lo pueda leer
        $anamnesis->cohabiting_animals = json_decode($anamnesis->cohabiting_animals);

        // Cargar los productos asociados para mostrarlos en la tabla
        $anamnesis->load(['anamnesisItemStocks.itemStock.item.category', 'anamnesisItemStocks.itemStock.item.presentation', 'anamnesisItemStocks.itemStock.item.laboratory', 'anamnesisItemStocks.itemStock.item.brand']);

        // Renombrar para que la vista sea compatible con el modo 'edit' de Voyager
        $dataTypeContent = $anamnesis;

        return view('administrations.pets.edit-add-history', compact('pet', 'dataTypeContent', 'animals'));
    }

    public function store(Request $request, Pet $pet)
    {
        // 1. Validar los datos del formulario
        $validatedData = $request->validate([
            'date' => 'required|date',
            'reproductive_status' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'identification' => 'nullable|string|max:255',
            'main_problem' => 'nullable|string',
            'evolution_time' => 'nullable|string|max:255',
            'recent_changes' => 'nullable|string|max:255',
            'observed_signs' => 'nullable|string',
            'appetite' => 'required|string',
            'water_intake' => 'required|string',
            'activity' => 'required|string',
            'urination' => 'required|string',
            'defecation' => 'nullable|string|max:255',
            'temperature' => 'nullable|string|max:50',
            'heart_rate' => 'nullable|string|max:50',
            'respiratory_rate' => 'nullable|string|max:50',
            'previous_diseases' => 'nullable|string',
            'previous_surgeries' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'allergies' => 'nullable|string',
            'vaccines' => 'nullable|string',
            'deworming' => 'nullable|string',
            'diet_type' => 'nullable|string|max:255',
            'diet_brand' => 'nullable|string|max:255',
            'diet_frequency' => 'nullable|string|max:255',
            'diet_recent_changes' => 'nullable|string',
            'housing' => 'required|string',
            'access_to_exterior' => 'required|string',
            'stay_place' => 'nullable|string|max:255',
            'cohabiting_animals' => 'nullable|array',
            'cohabiting_animals.*' => 'exists:races,id', // Valida cada ID en el array
            'toxic_exposure' => 'nullable|string',
            'females_repro' => 'nullable|string',
            'males_repro' => 'nullable|string',
            'repro_complications' => 'nullable|string',
            'additional_observations' => 'nullable|string',

        ]);

        if ($request->has('products')) {
            foreach ($request->products as $product) {
                $itemStock = ItemStock::findOrFail($product['id']);
                if ($itemStock->stock < $product['quantity']) {
                    return back()->with(['message' => 'Stock insuficiente para ' . $itemStock->item->name, 'alert-type' => 'error'])->withInput();
                }
            }
        }
   

        DB::beginTransaction();
        try {
            // return $request;
            // 2. Crear el registro de Anamnesis
            $anamnesis = AnamnesisForm::create([
                'pet_id' => $pet->id,
                'doctor_id' => Auth::id(),

                'date' => $request->date,
                'reproductive_status' => $request->reproductive_status,
                'weight' => $request->weight,
                'identification' => $request->identification,   
                'main_problem' => $request->main_problem,
                'evolution_time' => $request->evolution_time,
                'recent_changes' => $request->recent_changes,
                'appetite' => $request->appetite,
                'water_intake' => $request->water_intake,
                'activity' => $request->activity,
                'urination'=> $request->urination,
                'defecation' => $request->defecation,
                'temperature' => $request->temperature,
                'heart_rate' => $request->heart_rate,
                'respiratory_rate' => $request->respiratory_rate,
                'previous_diseases' => $request->previous_diseases,
                'previous_surgeries' => $request->previous_surgeries,
                'current_medications' => $request->current_medications,
                'allergies' => $request->allergies,
                'vaccines' => $request->vaccines,
                'deworming' => $request->deworming,
                'diet_type' => $request->diet_type,
                'diet_brand' => $request->diet_brand,
                'diet_frequency' => $request->diet_frequency,
                'diet_recent_changes' => $request->diet_recent_changes,
                'housing' => $request->housing,
                'access_to_exterior' => $request->access_to_exterior,
                'stay_place' => $request->stay_place,
                'cohabiting_animals' => $request->cohabiting_animals ? json_encode($request->cohabiting_animals) : null,
                'toxic_exposure' => $request->toxic_exposure,
                'females_repro' => $request->females_repro,
                'males_repro' => $request->males_repro,
                'repro_complications' => $request->repro_complications,
                'additional_observations' => $request->additional_observations,

            ]);

           
            // return 1;

            // return $request;

            if ($request->products) {
                foreach ($request->products as $key => $value) {
                    $itemStock = ItemStock::where('id', $value['id'])->first();
                    AnamnesisItemStock::create([
                        'anamnesisForm_id' => $anamnesis->id,
                        'itemStock_id' => $itemStock->id,
                        'pricePurchase' => $itemStock->pricePurchase,
                        'price' => $value['priceSale'],
                        'quantity' => $value['quantity'],
                        'amount' => $value['priceSale'] * $value['quantity'],
                    ]);
                    $itemStock->decrement('stock', $value['quantity']);
                } 
            }  
            // return 1;

            DB::commit();

            return redirect()->route('voyager.pets.show', $pet->id)->with(['message' => 'Historial clínico guardado exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return 0;
            Log::error('Error al guardar el historial clínico: ' . $e->getMessage());
            return redirect()->back()->with(['message' => 'Ocurrió un error al guardar el historial.', 'alert-type' => 'error'])->withInput();
        }
    }

    public function update(Request $request, AnamnesisForm $anamnesis)
    {
        // 1. Validar los datos del formulario
        $validatedData = $request->validate([
            'date' => 'required|date',
            'reproductive_status' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'identification' => 'nullable|string|max:255',
            'main_problem' => 'nullable|string',
            'evolution_time' => 'nullable|string|max:255',
            'recent_changes' => 'nullable|string|max:255',
            'observed_signs' => 'nullable|string',
            'appetite' => 'required|string',
            'water_intake' => 'required|string',
            'activity' => 'required|string',
            'urination' => 'required|string',
            'defecation' => 'nullable|string|max:255',
            'temperature' => 'nullable|string|max:50',
            'heart_rate' => 'nullable|string|max:50',
            'respiratory_rate' => 'nullable|string|max:50',
            'previous_diseases' => 'nullable|string',
            'previous_surgeries' => 'nullable|string',
            'current_medications' => 'nullable|string',
            'allergies' => 'nullable|string',
            'vaccines' => 'nullable|string',
            'deworming' => 'nullable|string',
            'diet_type' => 'nullable|string|max:255',
            'diet_brand' => 'nullable|string|max:255',
            'diet_frequency' => 'nullable|string|max:255',
            'diet_recent_changes' => 'nullable|string',
            'housing' => 'required|string',
            'access_to_exterior' => 'required|string',
            'stay_place' => 'nullable|string|max:255',
            'cohabiting_animals' => 'nullable|array',
            'cohabiting_animals.*' => 'exists:races,id',
            'toxic_exposure' => 'nullable|string',
            'females_repro' => 'nullable|string',
            'males_repro' => 'nullable|string',
            'repro_complications' => 'nullable|string',
            'additional_observations' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // 2. Actualizar el registro de Anamnesis
            $requestData = $request->all();
            $requestData['cohabiting_animals'] = $request->cohabiting_animals ? json_encode($request->cohabiting_animals) : null;
            $anamnesis->update($requestData);

            // 3. Sincronizar los productos (items)
            // Devolver stock de items eliminados
            $existingItems = $anamnesis->anamnesisItemStocks;
            $newItemsIds = $request->products ? array_column($request->products, 'id') : [];

            foreach ($existingItems as $existingItem) {
                if (!in_array($existingItem->itemStock_id, $newItemsIds)) {
                    $itemStock = ItemStock::find($existingItem->itemStock_id);
                    if ($itemStock) {
                        $itemStock->increment('stock', $existingItem->quantity);
                    }
                    $existingItem->delete();
                }
            }

            // Actualizar/Crear nuevos items
            if ($request->products) {
                foreach ($request->products as $product) {
                    $itemStock = ItemStock::findOrFail($product['id']);
                    $quantityDifference = $product['quantity'] - ($anamnesis->anamnesisItemStocks()->where('itemStock_id', $product['id'])->first()->quantity ?? 0);

                    if ($itemStock->stock < $quantityDifference) {
                        DB::rollBack();
                        return back()->with(['message' => 'Stock insuficiente para ' . $itemStock->item->name, 'alert-type' => 'error'])->withInput();
                    }

                    $anamnesis->anamnesisItemStocks()->updateOrCreate(
                        ['itemStock_id' => $product['id']],
                        ['price' => $product['priceSale'], 'quantity' => $product['quantity'], 'amount' => $product['priceSale'] * $product['quantity'], 'pricePurchase' => $itemStock->pricePurchase]
                    );
                    $itemStock->decrement('stock', $quantityDifference);
                }
            }

            DB::commit();

            return redirect()->route('voyager.pets.show', $anamnesis->pet_id)->with(['message' => 'Historial clínico actualizado exitosamente.', 'alert-type' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar el historial clínico: ' . $e->getMessage());
            return redirect()->back()->with(['message' => 'Ocurrió un error al actualizar el historial.', 'alert-type' => 'error'])->withInput();
        }
    }

    
}

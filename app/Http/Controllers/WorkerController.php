<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class WorkerController extends Controller
{
    public $storageController;
    public function __construct()
    {
        $this->middleware('auth');
        $this->storageController = new StorageController();
    }

    public function index()
    {
        $this->custom_authorize('browse_workers');

        return view('administrations.workers.browse');
    }

    public function list(){

        $search = request('search') ?? null;
        $paginate = request('paginate') ?? 10;


        $data = Worker::query()
            // El método when() hace lo mismo que tu "if($search)"
            ->when($search, function ($query, $search) {
                return $query->where(function($q) use ($search) {
                    $q->where('id', $search)
                      ->orWhere('ci', 'like', "%$search%")
                      ->orWhere('phone', 'like', "%$search%")
                      ->orWhere(DB::raw("CONCAT(first_name, ' ', COALESCE(paternal_surname, ''), ' ', COALESCE(maternal_surname, ''))"), 'like', "%$search%")
                      ->orWhere(DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', COALESCE(paternal_surname, ''), ' ', COALESCE(maternal_surname, ''))"), 'like', "%$search%");
                });
            })
            ->whereNull('deleted_at')
            ->orderBy('id', 'DESC')
            ->paginate($paginate);



        return view('administrations.workers.list', compact('data'));
    }

    public function store(Request $request)
    {
        $this->custom_authorize('add_workers');
        $request->validate([
            'ci' => 'required|string|max:255|unique:workers,ci', // Agregar unique aquí
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:Masculino,Femenino',
            'first_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,bmp,webp|max:2048' // 🎉 CAMBIO AQUÍ: Se añade max:3072
        ],
        [
            'ci.required' => 'El número de cédula es obligatorio',
            'ci.unique' => 'Esta cédula ya está registrada',
            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'first_name.required' => 'El nombre es obligatorio.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe tener uno de los siguientes formatos: jpeg, jpg, png, bmp, webp.',
            'image.max' => 'La imagen no puede pesar más de 2 megabytes (MB).' // ✍️ CAMBIO AQUÍ: Mensaje personalizado para el tamaño
        ]);
        try {
            // Si envian las imágenes
            Worker::create([
                'ci' => $request->ci,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'paternal_surname' => $request->paternal_surname,
                'maternal_surname' => $request->maternal_surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'image' => $this->storageController->store_image($request->image, 'workers')
            ]);

            DB::commit();
            return redirect()->route('voyager.workers.index')->with(['message' => 'Registrado exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('voyager.workers.index')->with(['message' => $th->getMessage(), 'alert-type' => 'error']);
        }
    }


    public function update(Request $request, $id){
        $this->custom_authorize('edit_workers');
        $ci_validation_rule = 'required|string|max:255|unique:workers,ci,' . $id;

        $request->validate([
            // Use the new variable here
            'ci' => $ci_validation_rule, 
            
            'birth_date' => 'required|date',
            'gender' => 'required|string|in:Masculino,Femenino',
            'first_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,bmp,webp|max:2048' 
        ],

        [
            'ci.required' => 'El número de cédula es obligatorio',
            'ci.unique' => 'Esta cédula ya está registrada',
            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'first_name.required' => 'El nombre es obligatorio.',
            'image.image' => 'El archivo debe ser una imagen.',
            'image.mimes' => 'La imagen debe tener uno de los siguientes formatos: jpeg, jpg, png, bmp, webp.',
            'image.max' => 'La imagen no puede pesar más de 2 megabytes (MB).' 
        ]);

        DB::beginTransaction();
        try {
            
            $worker = Worker::find($id);
            $worker->ci = $request->ci;
            $worker->birth_date = $request->birth_date;
            $worker->gender = $request->gender;
            $worker->first_name = $request->first_name;
            $worker->middle_name = $request->middle_name;
            $worker->paternal_surname = $request->paternal_surname;
            $worker->maternal_surname = $request->maternal_surname;
            $worker->email = $request->email;
            $worker->phone = $request->phone;
            $worker->address = $request->address;
            $worker->status = $request->status=='on' ? 1 : 0;

            if ($request->image) {
                $worker->image = $this->storageController->store_image($request->image, 'workers');
            }
          
            
            $worker->update();

            DB::commit();
            return redirect()->route('voyager.workers.index')->with(['message' => 'Actualizada exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('voyager.workers.index')->with(['message' => $th->getMessage(), 'alert-type' => 'error']);
        }
    }
}

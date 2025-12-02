<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Race;
use Illuminate\Support\Facades\DB;

class RaceController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            Race::create([
                'animal_id' => $request->animal_id,
                'name' => $request->name,
                'observation' => $request->observation,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Raza guardada exitosamente.'
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al guardar la raza.'
            ], 500);
        }
    }

    public function ajaxList(Request $request){
        $races = Race::where('animal_id', $request->id)->where('deleted_at', NULL)->paginate(10);
        return view('parameters.animals.listRaces', compact('races'));
    }

    public function destroy($id)
    {
        try {
            $race = Race::findOrFail($id);
            $race->delete();
            return response()->json(['success' => true, 'message' => 'Raza eliminada exitosamente.']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Ocurrió un error al eliminar la raza.']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function personList(){
        $q = request('q');
        $data = Person::OrWhereRaw($q ? "ci like '%$q%'" : 1)
                        ->OrWhereRaw($q ? "phone like '%$q%'" : 1)
                        ->OrWhereRaw($q ? "first_name like '%$q%'" : 1)
                        ->OrWhereRaw($q ? "middle_name like '%$q%'" : 1)
                        ->OrWhereRaw($q ? "paternal_surname like '%$q%'" : 1)
                        ->OrWhereRaw($q ? "maternal_surname like '%$q%'" : 1)
                        ->orWhere(function ($subQ) use ($q) {
                            $subQ->whereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(middle_name, '')) like ?", ["%$q%"])
                                ->orWhereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(paternal_surname, ''), ' ', COALESCE(maternal_surname, '')) like ?", ["%$q%"])
                                ->orWhereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(middle_name, ''), ' ', COALESCE(paternal_surname, ''), ' ', COALESCE(maternal_surname, '')) like ?", ["%$q%"]);
                        })
                        ->where('deleted_at', null)
                        ->get();
        return response()->json($data);
    }

    public function personStore(Request $request){
        DB::beginTransaction();
        try {
            $person =Person::create($request->all());
            DB::commit();
            return response()->json(['person' => $person]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }


    public function itemStockList(){
        $search = request('q');
        
        // $user = Auth::user();
        $data = ItemStock::with(['item', 'item.brand', 'item.category', 'item.presentation'])
            ->Where(function($query) use ($search){
                if($search){
                    $query->whereHas('item', function($query) use($search){
                        $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                    })
                    ->OrwhereHas('item.brand', function($query) use($search){
                        $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                    })
                    ->OrwhereHas('item.category', function($query) use($search){
                        $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                    })
                    ->OrwhereHas('item.presentation', function($query) use($search){
                        $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                    })
                    ->OrWhereRaw($search ? "id like '%$search%'" : 1)
                    ->OrWhereRaw($search ? "lote like '%$search%'" : 1);
                }
            })
            ->where('deleted_at', null)
            ->where('stock', '>', 0)
            ->get();
        return response()->json($data);
    }

    public function itemList(){
        $search = request('q');
        $user = Auth::user();
        $data = Item::with(['brand', 'laboratory', 'category', 'presentation'])
            ->Where(function($query) use ($search){
                if($search){
                    $query->OrwhereHas('brand', function($query) use($search){
                        $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                    })
                    ->OrwhereHas('category', function($query) use($search){
                        $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                    })
                    ->OrwhereHas('laboratory', function($query) use($search){
                        $query->whereRaw($search ? 'name like "%'.$search.'%"' : 1);
                    })
                    ->OrWhereRaw($search ? "id like '%$search%'" : 1)
                    ->OrWhereRaw($search ? "nameGeneric like '%$search%'" : 1)
                    ->OrWhereRaw($search ? "nameTrade like '%$search%'" : 1);
                }
            })
            ->where('deleted_at', null)
            ->where('status', 1)
            ->get();
        return response()->json($data);
    }
}

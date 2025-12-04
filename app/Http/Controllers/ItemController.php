<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    protected $storageController;
    public function __construct()
    {
        $this->middleware('auth');
        $this->storageController = new StorageController();
    }

    public function index()
    {
        $this->custom_authorize('browse_items');
        $laboratories = Item::with(['laboratory'])
            ->whereHas('laboratory', function($q){
                $q->where('deleted_at', null);
            })
            ->where('deleted_at', null)
            ->select('laboratory_id')
            ->groupBy('laboratory_id')
            ->get();

        return view('parameterInventories.items.browse', compact('laboratories'));
    }

    public function list(){
        $search = request('search') ?? null;
        $paginate = request('paginate') ?? 10;
        $laboratory_id = request('laboratory') ?? null;
        $user = Auth::user();

        $data = Item::with(['laboratory', 'presentation', 'category', 'brand', 'itemStocks'=>function($q)use($user){
                            $q->where('deleted_at', null);
                            // ->whereRaw($user->branch_id? "branch_id = $user->branch_id" : 1);
                        }])
                        ->where(function($query) use ($search){
                            $query->OrwhereHas('laboratory', function($query) use($search){
                                $query->whereRaw($search ? "name like '%$search%'" : 1);
                            })
                            ->OrwhereHas('brand', function($query) use($search){
                                $query->whereRaw($search ? "name like '%$search%'" : 1);
                            })
                            ->OrWhereRaw($search ? "id = '$search'" : 1)
                            ->OrWhereRaw($search ? "observation like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "name like '%$search%'" : 1);
                        })
                        ->where('deleted_at', NULL)
                        ->whereRaw($laboratory_id? "laboratory_id = '$laboratory_id'" : 1)
                        ->orderBy('id', 'DESC')
                        ->paginate($paginate);

        return view('parameterInventories.items.list', compact('data'));
    }

    public function store(Request $request)
    {
        $this->custom_authorize('add_items');
        $request->validate([
                'nameGeneric' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,jpg,png,bmp,webp|max:2048' // 🎉 CAMBIO AQUÍ: Se añade max:3072
            ],
            [
                'nameGeneric.required' => 'El nombre generico es obligatorio.',
                'image.image' => 'El archivo debe ser una imagen.',
                'image.mimes' => 'La imagen debe tener uno de los siguientes formatos: jpeg, jpg, png, bmp, webp.',
                'image.max' => 'La imagen no puede pesar más de 2 megabytes (MB).' // ✍️ CAMBIO AQUÍ: Mensaje personalizado para el tamaño
            ]
        );
        try {
            Item::create([
                'category_id' => $request->category_id,
                'presentation_id' => $request->presentation_id,
                'brand_id' => $request->brand_id,
                'laboratory_id' => $request->laboratory_id,
                'nameGeneric' => $request->nameGeneric,
                'nameTrade' => $request->nameTrade,
                'observation' => $request->observation,
                'image' => $this->storageController->store_image($request->image, 'items')
            ]);

            DB::commit();
            return redirect()->route('voyager.items.index')->with(['message' => 'Registrado exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('voyager.items.index')->with(['message' => $th->getMessage(), 'alert-type' => 'error']);
        }
    }

    public function update(Request $request, $id){
        $this->custom_authorize('edit_items');
        $request->validate([
                'nameGeneric' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,jpg,png,bmp,webp'
            ],
            [
                'nameGeneric.required' => 'El nombre generico es obligatorio.',
                'image.image' => 'El archivo debe ser una imagen.',
                'image.mimes' => 'La imagen debe tener uno de los siguientes formatos: jpeg, jpg, png, bmp, webp.'
            ]
        );

        DB::beginTransaction();
        try {
            
            $item = Item::find($id);
            $item->category_id = $request->category_id;
            $item->presentation_id = $request->presentation_id;
            $item->brand_id = $request->brand_id;
            $item->laboratory_id = $request->laboratory_id;
            $item->nameGeneric = $request->nameGeneric;
            $item->nameTrade = $request->nameTrade;
            $item->observation = $request->observation;
            $item->status = $request->status=='on' ? 1 : 0;

            if ($request->image) {
                $item->image = $this->storageController->store_image($request->image, 'items');
            }
            $item->update();

            DB::commit();
            return redirect()->route('voyager.items.index')->with(['message' => 'Actualizada exitosamente', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->route('voyager.items.index')->with(['message' => $th->getMessage(), 'alert-type' => 'error']);
        }
    }

    public function show($id)
    {
        $this->custom_authorize('read_items');

        $item = Item::with(['laboratory', 'brand'])
            ->where('id', $id)
            ->where('deleted_at', null)
            ->first();

        return view('parameterInventories.items.read', compact('item'));
    }

    public function listStock($id)
    {
        $paginate = request('paginate') ?? 10;
        $status = request('status') ?? null;
        // $branch = request('branch') ?? null;
        $user = Auth::user();
        $data = ItemStock::where('item_id', $id)
            // ->whereRaw($status>1? "status = '$branch'" : 1)
            ->where('deleted_at', null)
            ->orderBy('id', 'DESC')
            ->paginate($paginate);
        return view('parameterInventories.items.listStock', compact('data'));
    }


    public function storeStock(Request $request, $id)
    {
        $this->custom_authorize('add_items');    
        DB::beginTransaction();
        try {
            ItemStock::create([
                'item_id' => $id,
                'lote'=>$request->lote,
                'quantity' =>  $request->quantity,
                'stock' => $request->quantity,
                'pricePurchase' => $request->pricePurchase,
                'priceSale' => $request->priceSale,

                'type' => 'Ingreso',
                'observation' => $request->observation,
            ]);
            DB::commit();
            return redirect()->route('voyager.items.show', ['id'=>$id])->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('voyager.items.show',  ['id'=>$id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        } 
    }

    public function destroyStock($id, $stock)
    {
        $item = ItemStock::where('id', $stock)
                ->where('deleted_at', null)
                ->first();
        if($item->stock != $item->quantity)
        {
            return redirect()->route('voyager.items.show', ['id'=>$id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }

        DB::beginTransaction();
        try {            
            if($item->incomeDetail_id != null)
            {
                $incomeDetail = IncomeDetail::where('deleted_at', null)->where('id', $item->incomeDetail_id)->first();
                $incomeDetail->increment('stock', $item->quantity);
            }
            $item->delete();

            DB::commit();
            return redirect()->route('voyager.items.show', ['id'=>$id])->with(['message' => 'Eliminado exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('voyager.items.show', ['id'=>$id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function listSales($id)
    {
        $paginate = request('paginate') ?? 10;
        $sales = \App\Models\SaleDetail::with(['sale.person'])
            ->whereHas('itemStock', function($q) use ($id){
                $q->where('item_id', $id);
            })
            ->where('deleted_at', null)
            ->orderBy('id', 'DESC')
            ->paginate($paginate);
        return view('parameters.items.partials.list-sales', compact('sales'));
    }
}

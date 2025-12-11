<?php

namespace App\Http\Controllers;

use App\Models\ItemStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\SaleTransaction;
use App\Models\Transaction;


class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $this->custom_authorize('browse_sales');
        return view('sales.browse');
    }

    public function list()
    {
        $this->custom_authorize('browse_sales');

        $search = request('search') ?? null;
        $paginate = request('paginate') ?? 10;
        // $status = request('status') ?? null;
        // $typeSale = request('typeSale') ?? null;

        $data = Sale::with([
            'person',
            'register',
            'saleDetails' => function ($q) {
                $q->where('deleted_at', null);
            },
            'saleDetails.itemStock.item',
            'saleTransactions' => function ($q) {
                $q->where('deleted_at', null);
            },
        ])
            ->where(function ($query) use ($search) {
                $query
                    ->OrWhereRaw($search ? "id = '$search'" : 1)
                    ->OrWhereRaw($search ? "code like '%$search%'" : 1);
            })
            ->where('deleted_at', null)
            // ->whereRaw($typeSale ? "typeSale = '$typeSale'" : 1)
            // ->whereRaw($status ? "status = '$status'" : 1)
            ->orderBy('id', 'DESC')
            ->paginate($paginate);            

        return view('sales.list', compact('data'));
    }

    public function create()
    {
        // $branches = Branch::where('deleted_at', null)->get();

        $user = Auth::user();
        $this->custom_authorize('add_sales');
        return view('sales.edit-add');
    }

    public function generarNumeroFactura($typeSale)
    {
        $prefix = $typeSale != 'Proforma' ? 'VTA-' : 'PRO-';
        $fecha = now()->format('Ymd');
        $count = Sale::withTrashed()
            // ->where('typeSale', $typeSale)
            ->whereRaw($typeSale != 'Proforma' ? 'typeSale != "Proforma"' : 'typeSale = "Proforma"')
            ->whereDate('created_at', today())
            ->count();

        return $prefix . $fecha . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        $this->custom_authorize('add_sales');

        $amount_cash = $request->amount_cash ? $request->amount_cash : 0;
        $amount_qr = $request->amount_qr ? $request->amount_qr : 0;

        if(($amount_cash + $amount_qr) < $request->amountTotalSale)
        {
            return redirect()
                ->route('sales.create')
                ->with(['message' => 'Monto Incorrecto.', 'alert-type' => 'error']);
        }

        $cashier = $this->cashier(null,'user_id = "'.Auth::user()->id.'"', 'status = "Abierta"');
        if (!$cashier) {
            return redirect()
                ->route('sales.index')
                ->with(['message' => 'Usted no cuenta con caja abierta.', 'alert-type' => 'warning']);
        }
        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'status' => 'Completado',
            ]);
            $sale = Sale::create([
                'person_id' => $request->person_id,
                // 'branch_id' => $request->branch_id,
                'cashier_id' => $cashier->id,

                'code' => $this->generarNumeroFactura($request->typeSale),
                'typeSale' => $request->typeSale,
                'amountReceived' => $request->amountReceived,
                'amountChange' => $request->payment_type == 'Efectivo'? $request->amountReceived-$request->amountTotalSale : 0,
                'amount' => $request->amountTotalSale,
                'observation' => $request->observation,
                'dateSale' => Carbon::now(),
                'status' => $request->typeSale == 'Venta al Contado' ? 'Pagado' : (($amount_cash+$amount_qr) >= $request->amountTotalSale?'Pagado':'Pendiente'),
            ]);

            if ($request->payment_type == 'Efectivo' || $request->payment_type == 'Ambos') {
                SaleTransaction::create([
                    'sale_id' => $sale->id,
                    'transaction_id' => $transaction->id,
                    'amount' => $request->amountTotalSale - $amount_qr,
                    'paymentType' => 'Efectivo',
                ]);
            }
            if ($request->paymentType == 'Qr' || $request->paymentType == 'Ambos') {
                SaleTransaction::create([
                    'sale_id' => $sale->id,
                    'transaction_id' => $transaction->id,
                    'amount' => $amount_qr,
                    'paymentType' => 'Qr',
                ]);
            }

            foreach ($request->products as $key => $value) {
                $itemStock = ItemStock::where('id', $value['id'])->first();

                SaleDetail::create([
                    'sale_id' => $sale->id,
                    'itemStock_id' => $itemStock->id,
                    'pricePurchase' => $itemStock->pricePurchase,
                    'price' => $value['priceSale'],
                    'quantity' => $value['quantity'],
                    'amount' => $value['priceSale'] * $value['quantity'],
                ]);

                if ($request->typeSale != 'Proforma') {
                    $itemStock->decrement('stock', $value['quantity']);
                }
            }

            DB::commit();
            return redirect()
                ->route('sales.index')
                ->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return 0;
            return redirect()
                ->route('sales.index')
                ->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function prinf($id)
    {
        $sale = Sale::with([
            'person',
            'register',
            'branch',
            'saleDetails' => function ($q) {
                $q->where('deleted_at', null);
            },
        ])
            ->where('id', $id)
            ->where('deleted_at', null)
            ->first();
        if ($sale->typeSale != 'Proforma') {
            $transaction = SaleTransaction::with(['transaction'])
                ->where('sale_id', $sale->id)
                ->first();
            return view('sales.prinfSale', compact('sale', 'transaction'));
        } else {
            return view('sales.prinfProforma', compact('sale'));
        }
    }

    public function destroy($id)
    {
        $sale = Sale::with([
            'saleDetails' => function ($q) {
                $q->where('deleted_at', null)->with(['saledetailItemstock']);
            },
        ])
            ->where('id', $id)
            ->first();

        DB::beginTransaction();
        try {
            foreach ($sale->saleDetails as $detail) {
                foreach ($detail->saledetailItemstock as $item) {
                    $itemStock = ItemStock::where('id', $item->itemStock_id)->first();
                    $itemStock->increment('stock', $item->quantity);
                    $itemStock->delete();
                }
            }
            $sale->delete();
            DB::commit();
            return redirect()
                ->route('sales.index')
                ->with(['message' => 'Eliminado exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()
                ->route('sales.index')
                ->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }


    public function show($id)
    {
        $sale = Sale::with([
            'person',
            'register',
            'saleTransactions',
            'saleDetails' => function ($q) {
                $q->where('deleted_at', null);
            },
            'saleDetails.itemStock.item' => function ($q) {
                $q->withTrashed();
            },
        ])
            ->where('id', $id)
            ->first();

        return view('sales.read', compact('sale'));
    }





    public function prinfPayment($id, $payment)
    {
        $transaction = SaleTransaction::with(['transaction', 'sale.saleDetails'])
            ->where('id', $payment)
            ->where('deleted_at', null)
            ->first();
        // return $transaction;

        return view('sales.prinf.transaction', compact('transaction'));
    }

    public function storePayment(Request $request, $id)
    {
        $this->custom_authorize('add_sales');
        $user = Auth::user();
        $sale = Sale::where('id', $id)->where('deleted_at', null)->first();

        $cashier = Cashier::where('status', 'Abierta')->where('user_id', $user->id)->first();
        if (!$cashier) {
            return redirect()
                ->route('sales.show', ['sale' => $id])
                ->with(['message' => 'No cuenta con caja activa.', 'alert-type' => 'error']);
        }
  
        if ($sale->typeSale == 'Proforma') {
            return redirect()
                ->route('sales.show', ['sale' => $id])
                ->with(['message' => 'Error.', 'alert-type' => 'error']);
        }
        $saleTransaction = SaleTransaction::where('sale_id', $sale->id)->where('deleted_at', null)->get();
        $totalPayment = $saleTransaction->sum('amount');

        $debt = $sale->amount - $totalPayment;

        if (($request->amount_cash + $request->amount_qr) > $debt) {
            return redirect()
                ->route('sales.show', ['sale' => $id])
                ->with(['message' => 'Error.', 'alert-type' => 'error']);
        }

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                    'type' => $request->payment_type,
                    'status' => 'Completado',
                ]);

            
            if($request->payment_type == 'Efectivo' && $request->amount_cash > 0)
            {
                SaleTransaction::create([
                    'transaction_id' => $transaction->id,
                    'sale_id' => $sale->id,
                    'cashier_id' => $cashier->id,
                    'branch_id' => $request->branch_id,
                    'paymentType' => 'Efectivo',
                    'amount' => $request->amount_cash,
                    // 'observation' => $request->observation,
                ]);
            }
            if($request->payment_type == 'Qr' && $request->amount_qr > 0)
            {
                SaleTransaction::create([
                    'transaction_id' => $transaction->id,
                    'sale_id' => $sale->id,
                    'cashier_id' => $cashier->id,
                    'branch_id' => $request->branch_id,
                    'paymentType' => 'Qr',
                    'amount' => $request->amount_qr,
                    // 'observation' => $request->observation,
                ]);
            }

                

            if (($totalPayment + $request->amount_qr + $request->amount_cash) >= $sale->amount) {
                $sale->update(['status' => 'Pagado']);
            }
            DB::commit();
            return redirect()
                ->route('sales.show', ['sale' => $id])
                ->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()
                ->route('sales.show', ['sale' => $id])
                ->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

}

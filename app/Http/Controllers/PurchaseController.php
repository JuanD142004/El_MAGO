<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use App\Models\DetailsPurchase;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;

/**
 * Class PurchaseController
 * @package App\Http\Controllers
 */
class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = trim($request->get('search'));
    
    // Cambiamos la consulta para cargar las compras con sus proveedores
    $purchases = Purchase::with('supplier')
        ->whereHas('supplier', function ($query) use ($search) {
            $query->where('supplier_name', 'LIKE', '%' . $search . '%');
        })
        ->paginate(10);

    return view('purchase.index', compact('purchases'))
        ->with('i', (request()->input('page', 1) - 1) * $purchases->perPage());
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $purchase = new Purchase();
        $products = Product::all();
        $suppliers = Supplier::all();
        $detailsPurchase = new DetailsPurchase();
        return view('purchase.create', compact('purchase', 'detailsPurchase', 'products', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $datos = $request->all();

        // Crear una nueva compra
        $compra = new Purchase();
        $compra->suppliers_id = $datos['nombre_proveedor'];
        $compra->date = $datos['fecha'];
        $compra->total_value = $datos['ValorTotal'];
        $compra->num_bill = $datos['NumeroFactura'];
        $compra->enabled = true; // Asegurar que la compra está habilitada
        $compra->save();

        // Recorrer los detalles de la compra y guardarlos en la base de datos
        foreach ($datos['detalles'] as $detalle) {
            $detalleCompra = new DetailsPurchase();
            $detalleCompra->products_id = $detalle['Producto'];
            $detalleCompra->purchase_lot = $detalle['Lote'];
            $detalleCompra->amount = $detalle['Cantidad'];
            $detalleCompra->unit_value = $detalle['ValorUnitario'];
            $detalleCompra->purchases_id = $compra->id; // Asociar el detalle con la compra creada
            $detalleCompra->save();
        }

        // Retornar una respuesta de redirección
        return redirect()->route('purchase.index')
            ->with('success', 'Registro creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $purchase = Purchase::find($id);
        $detailsPurchases = DetailsPurchase::where('purchases_id', $id)->get();

        return view('purchase.show', compact('purchase', 'detailsPurchases'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $purchase = Purchase::find($id);

        return view('purchase.edit', compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PurchaseRequest $request, Purchase $purchase)
    {
        $purchase->update($request->validated());

        return redirect()->route('purchase.index')
            ->with('success', 'Compra actualizada exitosamente');
    }

    public function destroy($id)
    {
        // Encuentra la compra con el ID dado
        $purchase = Purchase::find($id);
        if (!$purchase) {
            return redirect()->route('purchases.index')->with('error', 'La compra no existe');
        }

        // Anula la compra (asumiendo que 'disable' representa el estado de anulación)
        $purchase->disable = true;
        $purchase->save();

        // Redirige con un mensaje de éxito
        return redirect()->route('purchases.index')->with('success', 'La compra ha sido anulada con éxito');
    }
}
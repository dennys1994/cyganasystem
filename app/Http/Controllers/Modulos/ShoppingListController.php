<?php

namespace App\Http\Controllers\Modulos;

use App\Http\Controllers\Controller;
use App\Models\Modulos\ShoppingList;
use App\Models\Role;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class ShoppingListController extends Controller
{
    public function index()
    {

        $compras = ShoppingList::with('user.role')->get();
        return view('Modulos.Compras.index', compact('compras'));
    }

    public function create()
    {
        return view('Modulos.Compras.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
        ]);

        ShoppingList::create([
            'description' => $request->description,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('shopping_lists.index')->with('success', 'Item adicionado à lista de compras.');
    }

    public function destroy(ShoppingList $shoppingList)
    {
        $shoppingList->delete();

        return redirect()->route('shopping_lists.index')->with('success', 'Item removido da lista de compras.');
    }

    public function generatePdf()
    {
        $compras = ShoppingList::with('user.role')->get();
        $pdf = Pdf::loadView('Modulos.Compras.pdf', compact('compras'));
        return $pdf->stream('lista_compras.pdf');
    }

}


<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\ProductRequest;
use App\Ingredient;
use App\ProductIngredients;
use Facade\FlareClient\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    private $obj, $ing;

    public function __construct(Product $obj, Ingredient $ing, ProductIngredients $pr)
    {
        $this->obj = $obj;
        $this->ing = $ing;
        $this->pr = $pr;
    }

    public function index()
    {
        $result = $this->obj->all();
        return view('system/Product/index', compact('result' ?? ''));
    }

    public function create()
    {
        return view('system/Product/form');
    }

    public function store(ProductRequest $request)
    {
        $product = $request->only(['description', 'amount', 'und', 'price']);
        $salvo = $this->obj->cstore($product);
        if ($salvo) {
            return redirect()->route('produto.show', $salvo->id)->with('success','editado com sucesso');
        } else {
            return redirect()->route('produto.create', compact('request'))->with('danger','erro ao tentar cadastrar o produto');
        }
    }

    public function show($id)
    {
        $result = $this->obj->with('Ingredients')->find($id);
        $ingredient = $this->ing->all();
        $valGasto = $this->pr->where('product_id', $id)->get();
        return view(
            'system/Product/show',
            [
                'result' => $result,
                'ingredient' => $ingredient,
                'valGasto' => $valGasto
            ]
        );
    }

    public function edit($id)
    {
        $result = $this->obj->find($id);
        return view('system/Product/form', compact('result' ?? ''));
    }

    public function update(Request $request, $id)
    {
        $product = $request->only(['description', 'amount', 'und', 'price']);
        $result = $this->obj->cUpdate($product, $id);
        return redirect()->route('produto.show', $id)->with('success','editado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        //
    }
}

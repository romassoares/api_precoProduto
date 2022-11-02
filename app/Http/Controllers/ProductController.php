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
        $result = $this->obj->paginate(5);
        return response()->json(['result' => $result], 200);
    }

    public function create()
    {
        return response()->json(['message' => 'ok'], 200);
    }

    public function store(ProductRequest $request)
    {
        $product = $request->only(['description', 'amount', 'und', 'price']);
        $salvo = $this->obj->cstore($product);
        if ($salvo) {
            return response()->json(['product' => $salvo->id], 200);
        } else {
            return response()->json(['message' => 'erro ao tentar cadastrar o produto']);
        }
    }

    public function show($id)
    {
        $product = $this->obj->findorfail($id);
        $ingredient = $this->ing->withTrashed()->get();
        $valGasto = $this->pr->where('product_id', $id)->get();
        return response()->json(['product' => $product, 'ingredient' => $ingredient, 'valGasto' => $valGasto], 200);
    }

    public function edit($id)
    {
        $result = $this->obj->find($id);
        if ($result) {
            return response()->json(['result' => $result], 200);
        }
        return response()->json(['message' => 'Não encontrado'], 404);
    }

    public function update(Request $request, $id)
    {
        $product = $request->only(['description', 'amount', 'und', 'price']);
        $result = $this->obj->cUpdate($product, $id);
        if ($result) {
            return response()->json(['produto' => $result], 200);
        }
        return response()->json(['message' => 'Erro ao editar item'], 403);
    }

    public function destroy($id)
    {
        $product = $this->obj->findorfail($id);
        if ($product) {
            $result = $product->delete();
            if ($result) {
                return response()->json(['produto' => $result], 200);
            }
            return response()->json(['message' => 'Permissão negada'], 403);
        } else {
            return response()->json(['message' => 'Não encontrado'], 404);
        }
    }

    public function archive()
    {
        $result = $this->obj->withTrashed()->where('deleted_at', '!=', null)->get();
        if ($result) {
            return response()->json(['produto' => $result], 200);
        } else {
            return response()->json(['message' => 'Não encontrado'], 404);
        }
    }

    public function restory($id)
    {
        $result = $this->obj->withTrashed()->where('id', $id)->first();
        if ($result) {
            $res = $result->restore();
            if ($res) {
                return redirect()->route(['produto' => $res], 200);
            }
            return response()->json(['message' => 'Não encontrado'], 404);
        }
    }
}

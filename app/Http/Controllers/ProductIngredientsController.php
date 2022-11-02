<?php

namespace App\Http\Controllers;

use App\Ingredient;
use App\Product;
use App\ProductIngredients;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProductIngredientsController extends Controller
{
    private $obj;
    public function __construct(ProductIngredients $obj)
    {
        $this->obj = $obj;
    }

    public function edit($id)
    {
        $product = Product::findorfail($id);
        $ingredients = $this->obj->withTrashed()->get();
        return response()->json(['product' => $product, 'ingredients' => $ingredients], 200);
    }

    // adciona ingrediente a receita
    public function update(Request $request, $product_id)
    {
        $product = Product::findorfail($product_id);
        $list = $request->except(['_method', '_token']);
        $result = $this->obj->get()->where('product_id', $product_id);
        foreach ($result as $exist) {
            if ($exist->ingredient_id == intval($list['ingredient'])) {
                return response()->json(['product' => $product_id], 200);
            }
        }
        if (isset($result)) {
            $new = new ProductIngredients();
            $save = $new->create(['product_id' => $product->id, 'ingredient_id' => intval($list['ingredient']), 'qnt' => floatval($list['amount'])]);
            if ($save) {
                return response()->json(['produto' => $product_id], 200);
            } else {
                return response()->json(['message', 'Houve um erro ao tentar adcionar os ingredientes']);
            }
        }
    }

    // redireciona para a pagina de adicionar a quantidade 
    public function Qnt($id, $ing)
    {
        $result = $this->obj->where('product_id', intval($id))->where('ingredient_id', intval($ing))->get()->first();
        $ingredient = Ingredient::get()->where('id', $result->ingredient_id)->first();
        if ($ingredient) {
            return view('system.Product.recipe', ['result' => $result, 'ingredient' => $ingredient]);
        } else {
            DB::rollBack();
            return response()->json('produto.show', intval($id))->with('error', 'Falha ingrediente não encontrado, verifique em arquivos removidos e reative-o');
        }
    }

    // adicionar a quantidade de ingrediente a receita
    public function addQnt(Request $qnt, $product_id)
    {
        $exist = $this->obj->get()->where('product_id', $product_id)->where('ingredient_id', $qnt->ingredient);
        foreach ($exist as $ing) {
            if ($ing->ingredient_id == $qnt->ingredient) {
                $result = Ingredient::get()->where('id', $qnt->ingredient)->first();
                if ($result->amount >= $qnt->qnt) {
                    $save = DB::table('product_ingredients')
                        ->where('product_id', $ing->product_id)
                        ->where('ingredient_id', $qnt->ingredient)
                        ->update(['qnt' => $qnt->qnt]);
                    if ($save) {
                        $amount = $result->update(['amount' => $result->amount - $qnt->qnt]);
                        return response()->json('produto.show', $product_id)->with('error', 'item adcionado com successo');
                    } else {
                        return redirect()->back()->with('error', 'Houve um erro ao tentar adcionar os ingredientes');
                    }
                } else {
                    return response()->json('produto.show', $product_id)->with('error', 'estoque insuficiente');
                }
            }
            redirect()->back()->with('warning', 'ocorreu um erro, recarregue a pagina e tente novamente');
        }
    }

    public function remove($prod, $ing)
    {
        $recipe = $this->obj->where('product_id', $prod)->where('ingredient_id', $ing)->get()->first();
        $result = $this->obj->where('product_id', $prod)->where('ingredient_id', $ing)->delete();
        if ($result == 1) {
            $ingredient = Ingredient::where('id', $ing)->get()->first();
            $amount = $recipe->qnt == null ? 0 : $recipe->qnt;
            $restoreAmount = $ingredient->update(['amount' => $ingredient->amount + $amount]);
            if (isset($restoreAmount)) {
                return response()->json('produto.show', $prod)->with('ingrediente removido com sucesso');
            }
        }
    }
}

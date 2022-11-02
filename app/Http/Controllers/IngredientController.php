<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientRequest;
use App\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    private $obj;

    public function __construct()
    {
        $this->obj = new Ingredient();
    }

    public function index()
    {
        $result = $this->obj->paginate(5);
        return response()->json(['ingredients' => $result], 200);
    }

    public function create()
    {
        return response()->json([], 200);
    }

    public function store(IngredientRequest $request)
    {
        $ingredient = $request->only(['description', 'amount', 'und', 'price']);
        $result = $this->obj->cstore($ingredient);
        if ($result) {
            return response()->json(['ingredient' => $result], 200);
        }
    }

    public function show($id)
    {
        $result = $this->obj->find($id);
        if ($result) {
            return response()->json(['ingredient' => $result], 200);
        }
    }

    public function edit($id)
    {
        $result = $this->obj->find($id);
        return response()->json(['ingredient', $result], 200);
    }

    public function update(IngredientRequest $request, $id)
    {
        $ingredient = $request->only(['description', 'amount', 'und', 'price']);
        $result = $this->obj->cUpdate($ingredient, $id);
        if ($result) {
            return response()->json(['ingredient', $result], 200);
        } else {
            return response()->json(['message' => 'não encontrado'], 404);
        }
    }

    public function destroy($id)
    {
        $ingredient = $this->obj->findorfail($id);
        if ($ingredient) {
            $result = $ingredient->delete();
            if ($result) {
                return response()->json(['ingredient', $result], 200);
            }
        } else {
            return response()->json(['message' => 'não encontrado'], 404);
        }
    }

    public function archive()
    {
        $result = $this->obj->withTrashed()->where('deleted_at', '!=', null)->get();
        return response()->json(['ingredient', $result], 200);
    }

    public function restory($id)
    {
        $result = $this->obj->withTrashed()->where('id', $id)->first();
        if ($result) {
            $res = $result->restore();
            if ($res) {
                return response()->json(['ingredient', $result], 200);
            } else {
                return response()->json(['message' => 'Erro ao tentar restaurar'], 404);
            }
        } else {
            return response()->json(['message' => 'não encontrado'], 404);
        }
    }
}

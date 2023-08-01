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
        $result = $this->obj->paginate(10);
        if ($result) {
            return response()->json([
                'ingredient' => $result,
                'msg' => 'Item salvo com sucesso',
                'status_code' => 200,
            ]);
        } else {
            return response()->json([
                'msg' => 'erro ao tentar salvar',
                'status_code' => 404,
            ]);
        }
    }

    public function create()
    {
        return response()->json([
            'msg' => '',
            'status_code' => 200,
        ]);
    }

    public function store(IngredientRequest $request)
    {
        $ingredient = $request->only(['description', 'amount', 'und', 'price']);
        $result = $this->obj->cstore($ingredient);
        if ($result) {
            return response()->json([
                'ingredient' => $result,
                'msg' => 'Item salvo com sucesso',
                'status_code' => 200,
            ]);
        } else {
            return response()->json([
                'msg' => 'erro ao tentar salvar',
                'status_code' => 404,
            ]);
        }
    }

    public function show($id)
    {
        $result = $this->obj->find($id);
        if ($result) {
            return response()->json([
                'msg' => '',
                'status_code' => 200,
                'ingredient' => $result,
            ]);
        } else {
            return response()->json([
                'msg' => 'erro ao tentar encontrar item',
                'status_code' => 204
            ]);
        }
    }

    public function edit($id)
    {
        $result = $this->obj->find($id);
        if ($result) {
            response()->json([
                'msg' => '',
                'status_code' => 200,
                'ingredient' => $result,
            ]);
        } else {
            return response()->json([
                'msg' => 'erro ao tentar encontrar item',
                'status_code' => 204
            ]);
        }
    }

    public function update(IngredientRequest $request, $id)
    {
        $ingredient = $request->only(['description', 'amount', 'und', 'price']);
        $result = $this->obj->cUpdate($ingredient, $id);
        if ($result) {
            return response()->json([
                'msg' => 'Item editado com sucesso',
                'status_code' => 200,
                'ingredient' => $result,
            ]);
        } else {
            return response()->json([
                'msg' => 'item não encontrado',
                'status_code' => 204,
            ]);
        }
    }

    public function destroy($id)
    {
        $ingredient = $this->obj->findorfail($id);
        if ($ingredient) {
            $result = $ingredient->delete();
            if ($result) {
                return response()->json([
                    'msg' => 'Item removido com sucesso',
                    'ingredient' => $result,
                    'status_code' => 200
                ]);
            } else {
                return response()->json([
                    'msg' => 'erro ao tentar apagar item',
                    'status_code' => 204
                ]);
            }
        } else {
            return response()->json([
                'msg' => 'não encontrado',
                'status_code' => 204
            ]);
        }
    }

    public function archive()
    {
        $result = $this->obj->withTrashed()->where('deleted_at', '!=', null)->get();
        return response()->json([
            'ingredient' => $result,
            'status_code' => 200
        ]);
    }

    public function restory($id)
    {
        $result = $this->obj->withTrashed()->where('id', $id)->first();
        if ($result) {
            $res = $result->restore();
            if ($res) {
                return response()->json([
                    'msg' => 'Item restaurado com sucesso',
                    'ingredient' => $result,
                    'status_code' => 200
                ]);
            } else {
                return response()->json([
                    'msg' => 'Erro ao tentar restaurar',
                    'status_code' => 204
                ]);
            }
        } else {
            return response()->json([
                'msg' => 'não encontrado',
                'status_code' => 204
            ]);
        }
    }
}

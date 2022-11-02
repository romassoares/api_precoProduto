<?php

namespace App\Http\Controllers;

use App\Client;
use App\Http\Requests\ClientRequest;
use App\Sale;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $obj;
    private $sale;
    public function __construct(Client $obj, Sale $sale)
    {
        $this->obj = $obj;
        $this->sale = $sale;
    }

    public function index()
    {
        $clients = $this->obj->get();
        return response()->json(['clients' => $clients], 200);
    }

    public function report($id)
    {
        $result = $this->sale->where('client_id', $id)->get()->all();
        $client = $this->obj->find($id);
        return response()->json(['sales' => $result, 'client' => $client], 200);
    }

    public function create()
    {
        return response()->json([], 200);
    }

    public function store(ClientRequest $request)
    {
        $client = $request->only(['name', 'city', 'district', 'street', 'number', 'contact']);
        $salvo = $this->obj->cstore($client);
        if ($salvo) {
            return response()->json(['cliente' => $salvo->id]);
        } else {
            return response()->json(['client' => $client, 'message' => 'erro ao tentar salvar']);
        }
    }

    public function search(Request $label)
    {
        $search = $this->obj->where('name', 'like', "$label->search%")->paginate();
        return response()->json(['clients' => $search]);
    }

    public function edit($id)
    {
        $client = $this->obj->find($id);
        return response()->json(['client' => $client]);
    }

    public function update(ClientRequest $request, $id)
    {
        $client = $request->only(['name', 'city', 'district', 'street', 'number', 'contact']);
        $result = $this->obj->cUpdate($client, $id);
        if ($result) {
            return response()->json('client_id', $id);
        } else {
            return response()->json(['message' => 'erro ao tentar editar registro']);
        }
    }

    public function destroy($id)
    {
        $client = $this->obj->findorfail($id);
        if ($client) {
            $result = $client->delete();
            if ($result) {
                return response()->json(['client' => $client]);
            }
        } else {
            return response()->json(['message', 'cliente não encontrado']);
        }
    }

    public function archive()
    {
        $result = $this->obj->withTrashed()->where('deleted_at', '!=', null)->get();
        return response()->json(['clients' => $result]);
    }

    public function restory($id)
    {
        $result = $this->obj->withTrashed()->where('id', $id)->first();
        if ($result) {
            $res = $result->restore();
            if ($res) {
                return response()->json(['client' => $id]);
            } else {
                return response()->json(['message' => 'Erro ao tentar restaurar']);
            }
        } else {
            return response()->json(['message' => 'Arquivo não encontrado']);
        }
    }
}

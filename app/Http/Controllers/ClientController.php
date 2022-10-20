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
        return view('system/Client/report', ['sales' => $result, 'client' => $client]);
    }

    public function create()
    {
        return view('system/Client/form');
    }

    public function store(ClientRequest $request)
    {
        $client = $request->only(['name', 'city', 'district', 'street', 'number', 'contact']);
        $salvo = $this->obj->cstore($client);
        if ($salvo) {
            return redirect()->route('cliente.report', $salvo->id);
        } else {
            return redirect()->route('cliente.create', ['client' => $client]);
        }
    }

    public function search(Request $label)
    {
        $search = $this->obj->where('name', 'like', "$label->search%")->paginate();
        return view('system.Client.index', ['clients' => $search]);
    }

    public function edit($id)
    {
        $client = $this->obj->find($id);
        return view('system/Client/form', ['result' => $client]);
    }

    public function update(ClientRequest $request, $id)
    {
        $client = $request->only(['name', 'city', 'district', 'street', 'number', 'contact']);
        $result = $this->obj->cUpdate($client, $id);
        $client = $this->obj->find($id);
        return redirect()->route('cliente.report', $id);
    }

    public function destroy($id)
    {
        $client = $this->obj->findorfail($id);
        if ($client) {
            $result = $client->delete();
            if ($result) {
                return redirect()->route('cliente')->with('success', 'cliente removido com sucesso');
            }
        } else {
            return redirect()->route('cliente')->with('warning', 'erro, cliente não encontrado');
        }
    }

    public function archive()
    {
        $result = $this->obj->withTrashed()->where('deleted_at', '!=', null)->get();
        return view('system/Client/deleted', compact('result'));
    }

    public function restory($id)
    {
        $result = $this->obj->withTrashed()->where('id', $id)->first();
        if ($result) {
            $res = $result->restore();
            if ($res) {
                return redirect()->route('cliente.report', $id)->with('success', 'arquivo restaurado com sucesso');
            }
        }
    }
}

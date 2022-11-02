<?php

namespace App\Http\Controllers;

use App\Client;
use App\Product;
use App\Sale;
use App\Items;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    private $obj;
    private $prod;
    public function __construct(Sale $obj, Product $prod, Items $item)
    {
        $this->obj = $obj;
        $this->prod = $prod;
        $this->item = $item;
    }

    public function index()
    {
        $sales = $this->obj->paginate(5);
        $clients = Client::withTrashed()->get();
        return response()->json(['sales' => $sales, 'clients' => $clients]);
    }

    public function store(Request $request, Sale $sale)
    {
        $products = Product::all();
        $client = Client::where('id', intval($request->client_id))->first();
        if ($client) {
            $sale->client_id = $client->id;
            $save = $sale->save();
            if ($save) {
                $items = $this->item->get()->where('sale_id', $sale->id);
                return response()->json(['products' => $products,  'sale' => $sale, 'items' => $items]);
            }
        } else {
            $client = Client::create(['name' => 'default']);
            $save = new Sale();
            $result = $save->create(['client_id' => $client->id]);
            if ($result) {
                $items = $this->item->get()->where('sale_id', $result->id);
                return response()->json(['products' => $products,  'sale' => $result, 'items' => $items]);
            }
        }
    }

    public function addProduct(Request $request, $id)
    {
        $product = $this->prod->find(intval($request->product_id));
        if ($product && $product->amount >= $request->amount) {
            $item = Items::where('product_id', $product->id)->where('sale_id', intval($id))->get()->first();
            DB::beginTransaction();
            if ($item) {
                $item->amount += $request->amount;
            } else {
                $item = new Items();
                $item->product_id = $product->id;
                $item->sale_id = intval($id);
                $item->price = $product->price;
                $item->amount = $request->amount;
            }
            $sale = $this->obj->where('id', $id)->get()->first();
            if ($sale) {
                $sale->price += floatval(str_replace(array('.', ','), array('', '.'), $item->price)) * intval($request->amount);
            }
            $sale->save();
            $save = $item->save();
            if ($save) {
                $product->amount -= $request->amount;
                $save = $product->save();
                if ($save) {
                    DB::commit();
                    return response()->json(['sale' => $id]);
                } else {
                    DB::rollBack();
                    return response()->json(['messagge' => 'Falha ao atualizar quantidade no estoque']);
                }
            } else {
                DB::rollBack();
                return response()->json(['messagge' => 'Falha ao atualizar quantidade na venda']);
            }
        } else {
            return response()->json(['messagge' => 'estoque insuficiente']);
        }
    }

    public function removeItem($id, $product)
    {
        $item = Items::where('product_id', $product)->where('sale_id', $id)->get()->first();
        $itemRemove = Items::where('product_id', $product)->where('sale_id', $id)->delete();
        $itemRemove = true;
        if ($itemRemove) {
            $prod = $this->prod->where('id', $item->product_id)->get()->first();
            if ($prod) {
                $prodAmount = $prod->amount + floatval($item->amount);
                $prod->update(['amount' => $prodAmount]);
            }
            $sale = $this->obj->where('id', $id)->get()->first();
            if ($sale) {
                $result = floatval(str_replace(array(','), array('.'), $sale->price)) - floatval(str_replace(array(','), array('.'),  $item->getPriceTot()));
                $saleEdit = $sale->update(['price' => $result]);
            }
            if ($saleEdit) {
                return response()->json('sale.edit', $id)->with('success', 'item removido com sucesso');
            }
        }
    }

    public function edit($id)
    {
        $sale = Sale::findorfail($id);
        $items = $this->item->get()->where('sale_id', $id);
        $products = Product::all();
        return view('system.sales.form', ['products' => $products,  'items' => $items, 'sale' => $sale]);
    }

    public function show($id)
    {
        $sale = Sale::findorfail($id);
        $items = Items::where('sale_id', $id)->get();
        return view('system.sales.show', ['items' => $items, 'sale' => $sale]);
    }
    public function destroy($id)
    {
        $product = $this->obj->findorfail($id);
        if ($product) {
            $result = $product->delete();
            if ($result) {
                return response()->json('sale')->with('success', 'sale removido com sucesso');
            }
        } else {
            return response()->json('sale')->with('warning', 'erro, venda não encontrado');
        }
    }

    public function archive()
    {
        $result = $this->obj->withTrashed()->where('deleted_at', '!=', null)->get();
        return view('system.sales.deleted', compact('result'));
    }

    public function restory($id)
    {
        $result = $this->obj->withTrashed()->where('id', $id)->first();
        if ($result) {
            $res = $result->restore();
            if ($res) {
                return response()->json('sale.show', $id)->with('success', 'arquivo restaurado com sucesso');
            }
        }
    }
}

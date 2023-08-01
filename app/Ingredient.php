<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingredient extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'description',
        'und',
        'amount',
        'price',
    ];

    public function setDescription($value)
    {
        $this->description = $value;
    }
    public function getDescription(): string
    {
        return $this->description;
    }

    public function setUnd($value)
    {
        $this->und = $value;
    }
    public function getUnd()
    {
        return $this->und;
    }

    public function setAmount($value)
    {
        $this->amount = $value;
    }
    public function getAmount()
    {
        return str_replace(array('', '.'), array('.', ','), $this->amount);
    }

    public function setPrice($value)
    {
        $this->price = $value;
    }
    public function getPrice()
    {
        return $this->price;
    }

    public function cUpdate($request, $id)
    {
        $teste = Ingredient::find($id);
        $result = $teste->update($request);
        if ($result) {
            return  $teste;
        }
    }

    public function cstore($request)
    {
        $novo = new Ingredient;
        $result = $novo->create($request);
        if ($result) {
            return $result;
        }
    }

    public function Products()
    {
        return $this->belongsToMany('App\Product', 'ProductIngredients', 'ingredient_id', 'product_id');
    }
}

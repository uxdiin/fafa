<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    public function items(){
        return $this->belongsToMany(Item::class)->withPivot('total');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}

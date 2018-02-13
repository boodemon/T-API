<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'banks';
    
    public  function scopeActive($query){
        return $query->where('active','!=','D');
    }
    
    public  function scopeStatus($query,$status = 'Y'){
        return $query->where('active',$status);
    }
}

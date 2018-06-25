<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Role extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name'
    ];

    public function User(){
        return $this->hasMany('App\User');
    }
}

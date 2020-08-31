<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    //
    public function investment() {
        return $this->belongsToMany('App\Investment');
    }
}

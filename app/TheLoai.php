<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    protected $table = 'TheLoai';

    public function LoaiTin(){
    	return $this->hasMany('App\LoaiTin','idTheLoai','id');
    }
}

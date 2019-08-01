<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $table = 'uploads';
    protected $fillable = [
        'userId','path', 'fileName', 'type', 'size', 'section', 'itemId', 'itemToken'
    ];
    public function user(){
        return $this->belongsTo(User::class,'userId','id');
    }
}

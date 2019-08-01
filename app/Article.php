<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Article extends Model
{
    /**
     * @var array
     */
    protected $table = 'articles';
    protected $fillable = [
        'authorId','title', 'content', 
    ];
    public function user(){
        return $this->belongsTo(User::class,'authorId','id');
    }
}

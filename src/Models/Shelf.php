<?php
/**
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Models;


use Illuminate\Database\Eloquent\Model;

class Shelf extends Model
{
    protected $fillable = ['name'];

    public function books()
    {
        return $this->hasMany('\Mikro\Models\Book');
    }
}
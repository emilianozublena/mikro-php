<?php
/**
 * @Author: Emiliano Zublena - https://github.com/emilianozublena
 * @Package: Mikro PHP - https://github.com/emilianozublena/mikro-php
 */

namespace Mikro\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['name', 'author', 'shelf_id'];
    protected $with = ['shelf'];

    public function shelf()
    {
        return $this->belongsTo('\Mikro\Models\Shelf');
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Submodule extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orden', 'module', 'icon', 'name', 'link', 'group', 'titlegroup', 
    ];

    public function id()
    {
        return Crypt::encryptString($this->id);
    }
}

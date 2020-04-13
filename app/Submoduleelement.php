<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Submoduleelement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'orden', 'submodule', 'name', 'link', 
    ];

    public function id()
    {
        return Crypt::encryptString($this->id);
    }
}

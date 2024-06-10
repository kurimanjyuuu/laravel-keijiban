<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boards extends Model
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name', 
        'subject', 
        'message',
        'image_path',
        'email', 
        'url', 
        'text_color',
        'delete_key',
        'created_at',
        'update_at'
    ];
}

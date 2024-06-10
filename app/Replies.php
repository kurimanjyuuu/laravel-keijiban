<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'board_id',
        'name', 
        'subject', 
        'message',
        'image_path',
        'email', 
        'url', 
        'text_color',
        'delete_key'
    ];
}

<?php

namespace App;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use SoftDeletes;

    protected $fillable=[
        'name',
        'description'
    ];

    protected $dates=[
        'deletedAt'
    ];

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

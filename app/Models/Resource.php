<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model {

    protected $fillable = [
        'user_id',
        'folder_id',
        'title',
        'type',
        'description',
        'url',
        'file_path',
        'thumbnail',
    ];

    public function user() {
        
        return $this->belongsTo(User::class);
    }

    public function folder() {

        return $this->belongsTo(Folder::class);
    }

    public function tags() {

        return $this->belongsToMany(Tag::class);
    }
}

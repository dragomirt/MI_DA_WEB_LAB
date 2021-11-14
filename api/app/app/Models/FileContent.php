<?php

namespace App\Models;

class FileContent extends \Illuminate\Database\Eloquent\Model
{

    protected $table = 'file_contents';

    protected $fillable = ['media_id', 'content'];
}

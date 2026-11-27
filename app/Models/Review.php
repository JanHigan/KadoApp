<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $timestamps = false;

    protected $fillable = ["card_id", "result", "reviewed_at"];

    protected $casts = [
        "result" => "boolean",
        "reviewed_at" => "datetime",
    ];
}

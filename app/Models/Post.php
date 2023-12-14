<?php

namespace App\Models;

use DoubleThreeDigital\Runway\Traits\HasRunwayResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasRunwayResource;

    protected $fillable = ['title', 'slug'];
}

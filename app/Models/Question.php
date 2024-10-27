<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // Está definido Unguard para todos os Model diretamente no AppServiceProvider.php
    //protected $guarded = [];

    use HasFactory;
}

<?php

namespace Bslm\Stock\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockShareholders extends Model
{
    protected $fillable = ['person_id', 'name'];
    use HasFactory;
}

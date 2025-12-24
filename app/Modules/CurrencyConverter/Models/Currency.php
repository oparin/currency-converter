<?php

namespace App\Modules\CurrencyConverter\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Currency extends Model
{
    protected $table = "currencies";
    protected $guarded = [];
}

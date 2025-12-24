<?php

namespace App\Modules\CurrencyConverter\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property float $rate
 * @method static create(array $array)
 */
class Currency extends Model
{
    protected $table = "currencies";
    protected $guarded = [];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * @package App\Models
 */
class Country extends Model
{
    use HasFactory;

    protected $fillable = ['country', 'new_confirmed', 'new_deaths', 'total_deaths', 'new_recovered', 'total_confirmed', 'total_recovered', 'date'];
}

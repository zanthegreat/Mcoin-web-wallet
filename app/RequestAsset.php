<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestAsset extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'email',
        'coin_id',
        'description',
        'amount',
    ];

    public $appends = ['coin'];

    public function getCoinAttribute()
    {
        return $this->belongsTo('App\Coin', 'coin_id')->first();
    }
}

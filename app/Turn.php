<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Crud;
use App\Rules\NotPresent;

class Turn extends Model
{
    use Crud;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'time'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'time' => 'datetime:H:i:s'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'time', 'active'
    ];

    /**
     * The validation rules.
     *
     * @var array
     */
    public static $rules = [
        'time'       => 'required|date_format:H:i:s',
        'active'    => 'required|boolean',
    ];

    /**
     * The movies that belong to the turn.
     */
    public function movies()
    {
        return $this->belongsToMany('App\Movie');
    }
}

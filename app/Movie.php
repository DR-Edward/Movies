<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Crud;
use App\Rules\NotPresent;

class Movie extends Model
{
    use Crud;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'publicationDate'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'publicationDate' => 'datetime:Y-m-d',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'publicationDate', 'imageLink', 'active'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_link'];

    /**
     * Get the full link.
     *
     * @param  string  $value
     * @return string
     */
    public function getFullLinkAttribute($value)
    {
        if(env('APP_ENV') == "local") return "http://127.0.0.1:8000".$this->imageLink;
        return env('MIX_APP_URL').$this->imageLink;
    }

    /**
     * The turns that belong to the movie.
     */
    public function turns()
    {
        return $this->belongsToMany('App\Turn');
    }
}

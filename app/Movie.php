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
        return env('APP_URL').$this->imageLink;
    }

    /**
     * The validation rules for store.
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string',
        'publicationDate' => 'required|date_format:Y-m-d',
        'image' => 'required_with:updateImage|image',
        'active' => 'required',
    ];
    
    /**
     * The validation rules for activator field.
     *
     * @var array
     */
    public static function rules_activator() {
        return [
            'active' => 'required',
            'name' => [new NotPresent],
            'publicationDate' => [new NotPresent],
            'image' => [new NotPresent],
        ];
    }

    /**
     * The turns that belong to the movie.
     */
    public function turns()
    {
        return $this->belongsToMany('App\Turn');
    }
}

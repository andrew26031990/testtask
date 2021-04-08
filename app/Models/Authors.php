<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Authors
 * @package App\Models
 * @version April 8, 2021, 7:24 am UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection $books
 * @property string $name
 */
class Authors extends Model
{
    use SoftDeletes;

    use HasFactory;

    public $table = 'authors';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required|string|max:255',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'deleted_at' => 'nullable'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function books()
    {
        return $this->hasMany(\App\Models\Books::class, 'author_id');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($tournament) {
            foreach ($tournament->books()->get() as $ct) {
                $ct->delete();
            }
        });
    }
}

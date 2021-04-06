<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;

class ArticleCategory extends Model
{
	use CrudTrait;
	use HasTranslations;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'article_categories';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = ['name', 'slug', 'image', 'content', 'parent_id'];
	
	public $translatable = ['name', 'slug', 'content'];
    // protected $hidden = [];
    // protected $dates = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_name',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function parent()
    {
        return $this->belongsTo('App\Models\ArticleCategory', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\ArticleCategory', 'parent_id');
    }

    public function articles()
    {
        return $this->hasMany('App\Models\NewsArticle');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
	public function scopeFirstLevelItems($query)
    {
        return $query->where('depth', '1')
                    ->orWhere('depth', null)
                    ->orderBy('lft', 'ASC');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "name" field if no slug exists.
    public function getSlugOrNameAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->name;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

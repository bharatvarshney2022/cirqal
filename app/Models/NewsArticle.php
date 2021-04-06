<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\SpatieTranslatable\HasTranslations;

class NewsArticle extends Model
{
	use HasTranslations;
    use CrudTrait;
    use Sluggable, SluggableScopeHelpers;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'news_articles';
    protected $primaryKey = 'id';
    public $timestamps = true;
    // protected $guarded = ['id'];
    protected $fillable = ['article_category_id', 'author_id', 'title', 'slug', 'content', 'image', 'status', 'featured', 'date'];
	
	public $translatable = ['title', 'slug', 'content'];
    // protected $hidden = [];
    // protected $dates = [];
    protected $casts = [
        'featured'  => 'boolean',
        'date'      => 'date',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug_or_title',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
	public function translation($language = null)
	{
		if ($language == null) {
			$language = App::getLocale();
		}
		return $this->hasMany('App\ArticleTranslation')->where('language', '=', $language);
	}

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo('App\Models\ArticleCategory', 'article_category_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', 'news_article_tag');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopePublished($query)
    {
        return $query->where('status', 'PUBLISHED')
                    ->where('date', '<=', date('Y-m-d'))
                    ->orderBy('date', 'DESC');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    // The slug is created automatically from the "title" field if no slug exists.
    public function getSlugOrTitleAttribute()
    {
        if ($this->slug != '') {
            return $this->slug;
        }

        return $this->title;
    }

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

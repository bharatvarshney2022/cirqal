<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleTranslation extends Model
{
	protected $fillable = ['language', 'title', 'content', 'post_id'];

	public function post()
	{
		return $this->belongsTo('App\Category');
	}
}
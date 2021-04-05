<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
	protected $fillable = ['language', 'name', 'content', 'category_id'];

	public function post()
	{
		return $this->belongsTo('App\Category');
	}
}
<?php
namespace App\Support;
use Illuminate\Support\Facades\Config;
trait Translateable
{
	protected static function boot()
	{
		parent::boot();

		static::saved(function($model){

			//Let's get our supported configurations from the config file we've created
			$languages = Config::get('languages.supported');
			foreach ($languages as $language) 
			{
				$model->translation()->create(['language' => $language]);
			}
		});
	}
}
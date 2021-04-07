<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    public static function getPageInfo($id)
	{
		$pageData = static::find($id);
		return $pageData;
	}
	
	public static function isPageExists($id)
	{
		$pageData = static::where('id','=', $id)->count();
		return $pageData;
	}
	
	public static function getPageData($id)
	{
		$pageData = static::where('id','=', $id)->first();
		return $pageData;
	}
}

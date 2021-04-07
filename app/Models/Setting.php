<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    //
    public static function assignSetting()
	{
		$settings = static::all();
		foreach ($settings as $k => $setting) {
			define($setting['key'], $setting['value']);
		}
	}
}
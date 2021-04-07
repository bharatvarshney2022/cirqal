<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ArticleCategory;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	//START LOGIN
	public function articleListing()
	{
		Setting::assignSetting();

		$pageInfo = Page::getPageInfo(1);
		$pageData = json_decode($pageInfo['extras']);

		$categoryData = ArticleCategory::whereNull('parent_id')->where('depth', '1')->orderBy('lft', 'ASC')->get();
		

		$articleData = \DB::table('news_articles')->leftJoin('users', 'news_articles.author_id', '=', 'users.id')->where('featured', '0')->where('status', 'PUBLISHED')->selectRaw('news_articles.*,users.name,users.user_photo')->get();

		return view('article-listing', ['title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords, 'categoryData' => $categoryData, 'articleData' => $articleData]);

		return view('');
	}
}

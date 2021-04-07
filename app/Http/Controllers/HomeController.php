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
		//dd($categoryData);

		//$bankingData = \DB::table('lender_banking')->leftJoin('banking_arrangment', 'lender_banking.banking_arrangment_id', '=', 'banking_arrangment.id')->where('lender_id', $lenderData->id)->selectRaw('lender_banking.*,banking_arrangment.name')->get();

		return view('article-listing', ['title' => $pageData->meta_title, 'meta_description' => $pageData->meta_description, 'meta_keywords' => $pageData->meta_keywords, 'categoryData' => $categoryData]);

		return view('');
	}
}

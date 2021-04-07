<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('category', 'CategoryCrudController');
    Route::crud('news', 'ArticleCrudController');
    Route::crud('tag', 'TagCrudController');

    Route::crud('author', 'AuthorCrudController');
    Route::crud('article', 'NewsArticleCrudController');
    Route::crud('article_category', 'ArticleCategoryCrudController');
	
    Route::crud('newsarticle_bookmark', 'NewsArticleBookmarkCrudController');
    Route::crud('newsarticle_comment', 'NewsArticleCommentCrudController');
    Route::crud('newsarticle_like', 'NewsArticleLikeCrudController');
    Route::crud('newsarticle_retweet', 'NewsArticleRetweetCrudController');
}); // this should be the absolute last line of this file
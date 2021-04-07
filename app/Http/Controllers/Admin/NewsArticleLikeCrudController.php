<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NewsArticleLikeRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class NewsArticleLikeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class NewsArticleLikeCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\NewsArticleLike::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/newsarticle_like');
        CRUD::setEntityNameStrings('news article like', 'news article likes');

        $this->crud->operation('list', function () {
            $this->crud->addColumn([
                'label' => 'Article',
                'type' => 'select',
                'name' => 'news_article_id',
                'entity' => 'newsArticle',
                'attribute' => 'title',
            ]);
            $this->crud->addColumn([
                'label' => 'Customer',
                'type' => 'select',
                'name' => 'customer_id',
                'entity' => 'customer',
                'attribute' => 'name',
            ]);

            $this->crud->addColumn([
                'label' => 'Like',
                'type' => 'check',
                'name' => 'is_like',
            ]);

            $this->crud->addColumn([
                'label' => 'DisLike',
                'type' => 'check',
                'name' => 'is_dislike',
            ]);
        });

        $this->crud->operation(['create', 'update'], function () {
            $this->crud->setValidation(NewsArticleLikeRequest::class);

            $this->crud->addField([
                'label' => 'Article',
                'type' => 'select2',
                'name' => 'news_article_id',
                'entity' => 'newsArticle',
                'attribute' => 'title',
            ]);
            $this->crud->addField([
                'label' => 'Customer',
                'type' => 'select2',
                'name' => 'customer_id',
                'entity' => 'customer',
                'attribute' => 'name',
            ]);

            $this->crud->addField([
                'label' => 'Like',
                'type' => 'checkbox',
                'name' => 'is_like',
            ]);

            $this->crud->addField([
                'label' => 'DisLike',
                'type' => 'checkbox',
                'name' => 'is_dislike',
            ]);

            

            $this->crud->addField([
                'label' => 'Like Time',
                'type' => 'datetime',
                'name' => 'like_time',
            ]);

            $this->crud->addField([
                'label' => 'DisLike Time',
                'type' => 'datetime',
                'name' => 'dislike_time',
            ]);
        });
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // columns

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(NewsArticleLikeRequest::class);

        //CRUD::setFromDb(); // fields

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}

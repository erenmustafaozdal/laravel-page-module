<?php

namespace ErenMustafaOzdal\LaravelPageModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Page;
use App\PageCategory;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\BaseController;
// events
use ErenMustafaOzdal\LaravelPageModule\Events\Page\StoreSuccess;
use ErenMustafaOzdal\LaravelPageModule\Events\Page\StoreFail;
use ErenMustafaOzdal\LaravelPageModule\Events\Page\UpdateSuccess;
use ErenMustafaOzdal\LaravelPageModule\Events\Page\UpdateFail;
use ErenMustafaOzdal\LaravelPageModule\Events\Page\DestroySuccess;
use ErenMustafaOzdal\LaravelPageModule\Events\Page\DestroyFail;
use ErenMustafaOzdal\LaravelPageModule\Events\Page\PublishSuccess;
use ErenMustafaOzdal\LaravelPageModule\Events\Page\PublishFail;
use ErenMustafaOzdal\LaravelPageModule\Events\Page\NotPublishSuccess;
use ErenMustafaOzdal\LaravelPageModule\Events\Page\NotPublishFail;
// requests
use ErenMustafaOzdal\LaravelPageModule\Http\Requests\Page\ApiStoreRequest;
use ErenMustafaOzdal\LaravelPageModule\Http\Requests\Page\ApiUpdateRequest;


class PageApiController extends BaseController
{
    /**
     * default urls of the model
     *
     * @var array
     */
    private $urls = [
        'publish'       => ['route' => 'api.page.publish', 'id' => true],
        'not_publish'   => ['route' => 'api.page.notPublish', 'id' => true],
        'edit_page'     => ['route' => 'admin.page.edit', 'id' => true]
    ];

    /**
     * Display a listing of the resource.
     *
     * @param Request  $request
     * @param integer|null $id
     * @return Datatables
     */
    public function index(Request $request, $id = null)
    {
        // query
        if (is_null($id)) {
            $pages = Page::with('category');
        } else {
            $pages = PageCategory::findOrFail($id)->pages();
        }
        $pages->select(['id','category_id','slug','title','is_publish','created_at']);

        // if is filter action
        if ($request->has('action') && $request->input('action') === 'filter') {
            $pages->filter($request);
        }

        // urls
        $addUrls = $this->urls;
        if( ! is_null($id)) {
            array_merge($addUrls, [
                'edit_page' => [
                    'route'     => 'admin.page_category.page.edit',
                    'id'        => $id,
                    'model'     => config('laravel-page-module.url.page')
                ],
                'show' => [
                    'route'     => 'admin.page_category.page.show',
                    'id'        => $id,
                    'model'     => config('laravel-page-module.url.page')
                ]
            ]);
        }

        $addColumns = [
            'addUrls'           => $addUrls,
            'status'            => function($model) { return $model->is_publish; },
        ];
        $editColumns = [
            'created_at'        => function($model) { return $model->created_at_table; }
        ];
        $removeColumns = ['is_publish','category_id'];
        return $this->getDatatables($pages, $addColumns, $editColumns, $removeColumns);
    }

    /**
     * get detail
     *
     * @param integer $id
     * @param Request $request
     * @return Datatables
     */
    public function detail($id, Request $request)
    {
        $page = Page::with([
            'category' => function($query)
            {
                return $query->select(['id','name']);
            }
        ])->where('id',$id)->select(['id','category_id','title','slug','description','content','created_at','updated_at']);

        $editColumns = [
            'created_at'    => function($model) { return $model->created_at_table; },
            'updated_at'    => function($model) { return $model->updated_at_table; }
        ];
        return $this->getDatatables($page, [], $editColumns, []);
    }

    /**
     * get model data for edit
     *
     * @param integer $id
     * @param Request $request
     * @return Datatables
     */
    public function fastEdit($id, Request $request)
    {
        return Page::with([
            'category' => function($query)
            {
                return $query->select(['id','name']);
            }
        ])->where('id',$id)->first(['id','category_id','title','slug','description','is_publish']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ApiStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApiStoreRequest $request)
    {
        return $this->storeModel(Page::class, $request, [
            'success'   => StoreSuccess::class,
            'fail'      => StoreFail::class
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Page $page
     * @param  ApiUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(ApiUpdateRequest $request, Page $page)
    {
        $result = $this->updateModel($page, $request, [
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ]);

        // publish
        $request->input('is_publish') === 'true' ? $this->updateModelPublish($page, true, [
            'success'   => PublishSuccess::class,
            'fail'      => PublishFail::class
        ]) : $this->updateModelPublish($page, false, [
            'success'   => NotPublishSuccess::class,
            'fail'      => NotPublishFail::class
        ]);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        return $this->destroyModel($page, [
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ]);
    }

    /**
     * publish model
     *
     * @param Page $page
     * @return \Illuminate\Http\Response
     */
    public function publish(Page $page)
    {
        return $this->updateModelPublish($page, true, [
            'success'   => PublishSuccess::class,
            'fail'      => PublishFail::class
        ]);
    }

    /**
     * not publish model
     *
     * @param Page $page
     * @return \Illuminate\Http\Response
     */
    public function notPublish(Page $page)
    {
        return $this->updateModelPublish($page, false, [
            'success'   => NotPublishSuccess::class,
            'fail'      => NotPublishFail::class
        ]);
    }

    /**
     * update content page
     *
     * @param Page $page
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function contentUpdate(Page $page, Request $request)
    {
        return $this->updateModel($page, $request, [
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ]);
    }

    /**
     * group action method
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function group(Request $request)
    {
        $events = [];
        switch($request->input('action')) {
            case 'publish':
                $events['success'] = PublishSuccess::class;
                $events['fail'] = PublishFail::class;
                break;
            case 'not_publish':
                $events['success'] = NotPublishSuccess::class;
                $events['fail'] = NotPublishFail::class;
                break;
            case 'destroy':
                break;
        }
        $action = camel_case($request->input('action')) . 'GroupAction';
        if ( $this->$action(Page::class, $request->input('id'), $events) ) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }
}

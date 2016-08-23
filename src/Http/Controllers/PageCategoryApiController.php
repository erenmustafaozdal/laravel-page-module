<?php

namespace ErenMustafaOzdal\LaravelPageModule\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\PageCategory;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\BaseController;
// events
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\StoreSuccess;
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\StoreFail;
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\UpdateSuccess;
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\UpdateFail;
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\DestroySuccess;
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\DestroyFail;
// requests
use ErenMustafaOzdal\LaravelPageModule\Http\Requests\PageCategory\ApiStoreRequest;
use ErenMustafaOzdal\LaravelPageModule\Http\Requests\PageCategory\ApiUpdateRequest;


class PageCategoryApiController extends BaseController
{
    /**
     * default urls of the model
     *
     * @var array
     */
    private $urls = [
        'edit_page'     => ['route' => 'admin.page_category.edit', 'id' => true],
        'relations'     => ['route' => 'admin.page_category.page.index', 'id' => true]
    ];

    /**
     * Display a listing of the resource.
     *
     * @param  Request  $request
     * @return Datatables
     */
    public function index(Request $request)
    {
        $page_categories = PageCategory::select(['id','name','created_at']);
        // if is filter action
        if ($request->has('action') && $request->input('action') === 'filter') {
            $page_categories->filter($request);
        }

        $addColumns = [
            'addUrls' => $this->urls
        ];
        $editColumns = [
            'created_at'        => function($model) { return $model->created_at_table; }
        ];
        $removeColumns = [];
        return $this->getDatatables($page_categories, $addColumns, $editColumns, $removeColumns);
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
        $page_category = PageCategory::where('id',$id)->select(['id','name', 'created_at','updated_at']);

        $editColumns = [
            'created_at'    => function($model) { return $model->created_at_table; },
            'updated_at'    => function($model) { return $model->updated_at_table; }
        ];
        return $this->getDatatables($page_category, [], $editColumns, []);
    }

    /**
     * get model data for edit
     *
     * @param $id
     * @param Request $request
     * @return PageCategory
     */
    public function fastEdit($id, Request $request)
    {
        return PageCategory::find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ApiStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApiStoreRequest $request)
    {
        $this->setEvents([
            'success'   => StoreSuccess::class,
            'fail'      => StoreFail::class
        ]);
        return $this->storeModel(PageCategory::class);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PageCategory $page_category
     * @param  ApiUpdateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(ApiUpdateRequest $request, PageCategory $page_category)
    {
        $this->setEvents([
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ]);
        return $this->updateModel($page_category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PageCategory  $page_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageCategory $page_category)
    {
        $this->setEvents([
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ]);
        return $this->destroyModel($page_category);
    }

    /**
     * group action method
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function group(Request $request)
    {
        if ( $this->groupAlias(PageCategory::class) ) {
            return response()->json(['result' => 'success']);
        }
        return response()->json(['result' => 'error']);
    }

    /**
     * get roles with query
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function models(Request $request)
    {
        return PageCategory::where('name', 'like', "%{$request->input('query')}%")->get(['id','name']);
    }
}

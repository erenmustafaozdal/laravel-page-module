<?php

namespace ErenMustafaOzdal\LaravelPageModule\Http\Controllers;

use App\Http\Requests;
use App\PageCategory;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\AdminBaseController;
// events
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\StoreSuccess;
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\StoreFail;
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\UpdateSuccess;
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\UpdateFail;
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\DestroySuccess;
use ErenMustafaOzdal\LaravelPageModule\Events\PageCategory\DestroyFail;
// requests
use ErenMustafaOzdal\LaravelPageModule\Http\Requests\PageCategory\StoreRequest;
use ErenMustafaOzdal\LaravelPageModule\Http\Requests\PageCategory\UpdateRequest;

class PageCategoryController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(config('laravel-page-module.views.page_category.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $operation = 'create';
        return view(config('laravel-page-module.views.page_category.create'), compact('operation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->storeModel(PageCategory::class, $request, [
            'success'   => StoreSuccess::class,
            'fail'      => StoreFail::class
        ], [], 'index');
    }

    /**
     * Display the specified resource.
     *
     * @param  PageCategory  $page_category
     * @return \Illuminate\Http\Response
     */
    public function show(PageCategory $page_category)
    {
        return view(config('laravel-page-module.views.page_category.show'), compact('page_category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PageCategory $page_category
     * @return \Illuminate\Http\Response
     */
    public function edit(PageCategory $page_category)
    {
        $operation = 'edit';
        return view(config('laravel-page-module.views.page_category.edit'), compact('page_category','operation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  PageCategory  $page_category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, PageCategory $page_category)
    {
        return $this->updateModel($page_category,$request, [
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ], [],'show');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  PageCategory  $page_category
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageCategory $page_category)
    {
        return $this->destroyModel($page_category, [
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ], 'index');
    }
}

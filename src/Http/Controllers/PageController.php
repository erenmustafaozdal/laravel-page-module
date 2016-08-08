<?php

namespace ErenMustafaOzdal\LaravelPageModule\Http\Controllers;

use App\Http\Requests;
use App\Page;

use ErenMustafaOzdal\LaravelModulesBase\Controllers\AdminBaseController;
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
use ErenMustafaOzdal\LaravelPageModule\Http\Requests\Page\StoreRequest;
use ErenMustafaOzdal\LaravelPageModule\Http\Requests\Page\UpdateRequest;

class PageController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(config('laravel-page-module.views.page.index'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(config('laravel-page-module.views.page.create'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        return $this->storeModel(Page::class, $request, [
            'success'   => StoreSuccess::class,
            'fail'      => StoreFail::class
        ], [], 'index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view(config('laravel-page-module.views.page.show'), compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view(config('laravel-page-module.views.page.edit'), compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Page $page)
    {
        $result = $this->updateModel($page,$request, [
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ], [],'show');

        // publish
        $request->has('is_publish') ? $this->updateModelPublish($page, true, [
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
        ], 'index');
    }
}

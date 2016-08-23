<?php

namespace ErenMustafaOzdal\LaravelPageModule\Http\Controllers;

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
use ErenMustafaOzdal\LaravelPageModule\Http\Requests\Page\StoreRequest;
use ErenMustafaOzdal\LaravelPageModule\Http\Requests\Page\UpdateRequest;

class PageController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param integer|null $id
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {
        if (is_null($id)) {
            return view(config('laravel-page-module.views.page.index'));
        }

        $page_category = PageCategory::findOrFail($id);
        return view(config('laravel-page-module.views.page.index'), compact('page_category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param integer|null $id
     * @return \Illuminate\Http\Response
     */
    public function create($id = null)
    {
        $operation = 'create';
        if (is_null($id)) {
            return view(config('laravel-page-module.views.page.create'), compact('operation'));
        }

        $page_category = PageCategory::findOrFail($id);
        return view(config('laravel-page-module.views.page.create'), compact('page_category','operation'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreRequest  $request
     * @param integer|null $id
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, $id = null)
    {
        if (is_null($id)) {
            $redirect = 'index';
        } else {
            $redirect = 'page_category.page.index';
            $this->setRelationRouteParam($id, config('laravel-page-module.url.page'));
        }

        $this->setEvents([
            'success'   => StoreSuccess::class,
            'fail'      => StoreFail::class
        ]);
        return $this->storeModel(Page::class,$redirect);
    }

    /**
     * Display the specified resource.
     *
     * @param integer|Page $firstId
     * @param integer|null $secondId
     * @return \Illuminate\Http\Response
     */
    public function show($firstId, $secondId = null)
    {
        $page = is_null($secondId) ? $firstId : $secondId;
        if (is_null($secondId)) {
            return view(config('laravel-page-module.views.page.show'), compact('page'));
        }

        $page_category = PageCategory::findOrFail($firstId);
        return view(config('laravel-page-module.views.page.show'), compact('page', 'page_category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param integer|Page $firstId
     * @param integer|null $secondId
     * @return \Illuminate\Http\Response
     */
    public function edit($firstId, $secondId = null)
    {
        $operation = 'edit';
        $page = is_null($secondId) ? $firstId : $secondId;
        if (is_null($secondId)) {
            return view(config('laravel-page-module.views.page.edit'), compact('page','operation'));
        }

        $page_category = PageCategory::findOrFail($firstId);
        return view(config('laravel-page-module.views.page.edit'), compact('page', 'page_category','operation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param integer|Page $firstId
     * @param integer|null $secondId
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $firstId, $secondId = null)
    {
        $page = is_null($secondId) ? $firstId : $secondId;
        if (is_null($secondId)) {
            $redirect = 'show';
        } else {
            $redirect = 'page_category.page.show';
            $this->setRelationRouteParam($firstId, config('laravel-page-module.url.page'));
        }

        $this->setEvents([
            'success'   => UpdateSuccess::class,
            'fail'      => UpdateFail::class
        ]);
        return $this->updateModel($page,$redirect);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param integer|Page $firstId
     * @param integer|null $secondId
     * @return \Illuminate\Http\Response
     */
    public function destroy($firstId, $secondId = null)
    {
        $page = is_null($secondId) ? $firstId : $secondId;
        if (is_null($secondId)) {
            $redirect = 'index';
        } else {
            $redirect = 'page_category.page.index';
            $this->setRelationRouteParam($firstId, config('laravel-page-module.url.page'));
        }

        $this->setEvents([
            'success'   => DestroySuccess::class,
            'fail'      => DestroyFail::class
        ]);
        return $this->destroyModel($page,$redirect);
    }

    /**
     * publish model
     *
     * @param integer|Page $firstId
     * @param integer|null $secondId
     * @return \Illuminate\Http\Response
     */
    public function publish($firstId, $secondId = null)
    {
        $page = is_null($secondId) ? $firstId : $secondId;
        if (is_null($secondId)) {
            $redirect = 'show';
        } else {
            $redirect = 'page_category.page.show';
            $this->relatedModelId = $firstId;
            $this->modelRouteRegex = config('laravel-page-module.url.page');
        }
        return $this->updateModelPublish($page, true, [
            'success'   => PublishSuccess::class,
            'fail'      => PublishFail::class
        ],$redirect);
    }

    /**
     * not publish model
     *
     * @param integer|Page $firstId
     * @param integer|null $secondId
     * @return \Illuminate\Http\Response
     */
    public function notPublish($firstId, $secondId = null)
    {
        $page = is_null($secondId) ? $firstId : $secondId;
        if (is_null($secondId)) {
            $redirect = 'show';
        } else {
            $redirect = 'page_category.page.show';
            $this->relatedModelId = $firstId;
            $this->modelRouteRegex = config('laravel-page-module.url.page');
        }
        return $this->updateModelPublish($page, false, [
            'success'   => NotPublishSuccess::class,
            'fail'      => NotPublishFail::class
        ],$redirect);
    }
}

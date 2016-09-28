<?php

namespace ErenMustafaOzdal\LaravelPageModule;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use ErenMustafaOzdal\LaravelModulesBase\Traits\ModelDataTrait;

class PageCategory extends Model
{
    use ModelDataTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'page_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'datatable_filter',
        'datatable_tools',
        'datatable_fast_add',
        'datatable_group_action',
        'datatable_detail',
    ];





    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * query filter with id scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $request)
    {
        // filter id
        if ($request->has('id')) {
            $query->where('id',$request->get('id'));
        }
        // filter name
        if ($request->has('name')) {
            $query->where('name', 'like', "%{$request->get('name')}%");
        }
        // filter created_at
        if ($request->has('created_at_from')) {
            $query->where('created_at', '>=', Carbon::parse($request->get('created_at_from')));
        }
        if ($request->has('created_at_to')) {
            $query->where('created_at', '<=', Carbon::parse($request->get('created_at_to')));
        }
        return $query;
    }





    /*
    |--------------------------------------------------------------------------
    | Model Relations
    |--------------------------------------------------------------------------
    */

    /**
     * Get the pages of the page category.
     */
    public function pages()
    {
        return $this->hasMany('App\Page','category_id');
    }





    /*
    |--------------------------------------------------------------------------
    | Model Set and Get Attributes
    |--------------------------------------------------------------------------
    */
}

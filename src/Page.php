<?php

namespace ErenMustafaOzdal\LaravelPageModule;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use ErenMustafaOzdal\LaravelModulesBase\Traits\ModelDataTrait;

class Page extends Model
{
    use ModelDataTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_publish'
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
        // filter title
        if ($request->has('title')) {
            $query->where('title', 'like', "%{$request->get('title')}%");
        }
        // filter slug
        if ($request->has('slug')) {
            $query->where('slug', 'like', "%{$request->get('slug')}%");
        }
        // filter category
        if ($request->has('category')) {
            $query->whereHas('category', function ($query) use($request) {
                $query->where('name', 'like', "%{$request->get('category')}%");
            });
        }
        // filter status
        if ($request->has('status')) {
            $query->where('is_publish',$request->get('status'));
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
     * Get the category of the page.
     */
    public function category()
    {
        return $this->belongsTo('App\PageCategory');
    }





    /*
    |--------------------------------------------------------------------------
    | Model Set and Get Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Get the title attribute.
     *
     * @param  string $title
     * @return string
     */
    public function getTitleAttribute($title)
    {
        return ucfirst_tr($title);
    }

    /**
     * Set slug encrypted
     *
     * @param $slug
     */
    public function setSlugAttribute($slug)
    {
        if ( ! $slug) {
            $slug = str_slug($this->title, '-');
        }
        $this->attributes['slug'] =  $slug;
    }

    /**
     * Get the content attribute.
     * clean iframe for xss atack
     *
     * @param string $content
     * @return string
     */
    public function getContentAttribute($content)
    {
        return clean($content, 'iframe');
    }

    /**
     * Get the read attribute.
     *
     * @param integer $read
     * @return string
     */
    public function getReadAttribute($read)
    {
        return (int) $read;
    }

    /**
     * Set the is_publish attribute.
     *
     * @param boolean $value
     * @return string
     */
    public function setIsPublishAttribute($value)
    {
        $this->attributes['is_publish'] = $value == 1 || $value === 'true' || $value === true ? true : false;
    }

    /**
     * Get the is_publish attribute.
     *
     * @param boolean $value
     * @return string
     */
    public function getIsPublishAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    /**
     * Get the created_at attribute.
     *
     * @param  $date
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format(config('laravel-page-module.date_format'));
    }

    /**
     * Get the created_at attribute for humans.
     *
     * @return string
     */
    public function getCreatedAtForHumansAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    /**
     * Get the created_at attribute for datatable.
     *
     * @return array
     */
    public function getCreatedAtTableAttribute()
    {
        return [
            'display'       => $this->created_at_for_humans,
            'timestamp'     => Carbon::parse($this->created_at)->timestamp,
        ];
    }

    /**
     * Get the updated_at attribute.
     *
     * @param  $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format(config('laravel-page-module.date_format'));
    }

    /**
     * Get the updated_at attribute for humans.
     *
     * @return string
     */
    public function getUpdatedAtForHumansAttribute()
    {
        return Carbon::parse($this->updated_at)->diffForHumans();
    }

    /**
     * Get the updated_at attribute for datatable.
     *
     * @return array
     */
    public function getUpdatedAtTableAttribute()
    {
        return [
            'display'       => $this->updated_at_for_humans,
            'timestamp'     => Carbon::parse($this->updated_at)->timestamp,
        ];
    }
}

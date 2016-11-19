<?php

namespace ErenMustafaOzdal\LaravelPageModule\Http\Requests\Page;

use App\Http\Requests\Request;
use Sentinel;

class StoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $hackedRoute = 'admin.page.store';
        if ( ! is_null($this->segment(4))) {
            $hackedRoute .= '#####' .$this->segment(3);
        }
        return hasPermission($hackedRoute);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id'       => 'required|integer',
            'title'             => 'required|max:255',
            'slug'              => 'alpha_dash|max:255|unique:pages',
            'description'       => 'max:255',
            'meta_title'        => 'max:255',
            'meta_description'  => 'max:255',
            'meta_keywords'     => 'max:255',
        ];
    }
}

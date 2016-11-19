<?php

namespace ErenMustafaOzdal\LaravelPageModule\Http\Requests\PageCategory;

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
        $hackedRoute = 'admin.page_category.store';
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
            'name'          => 'required|max:255'
        ];
    }
}

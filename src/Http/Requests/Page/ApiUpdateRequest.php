<?php

namespace ErenMustafaOzdal\LaravelPageModule\Http\Requests\Page;

use App\Http\Requests\Request;
use Sentinel;

class ApiUpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Sentinel::getUser()->is_super_admin || Sentinel::hasAccess('api.page.update')) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = is_null($this->segment(5)) ? $this->segment(3) : $this->segment(5);
        return [
            'category_id'       => 'required|integer',
            'title'             => 'required|max:255',
            'slug'              => 'alpha_dash|max:255|unique:pages,slug,'.$id,
            'description'       => 'max:255',
        ];
    }
}

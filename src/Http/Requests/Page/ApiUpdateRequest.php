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
        return hasPermission('api.page.update');
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
            'description'       => 'max:255',
        ];
    }
}

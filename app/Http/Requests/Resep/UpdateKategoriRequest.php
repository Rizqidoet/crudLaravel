<?php

namespace App\Http\Requests\Resep;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Kategori;
use Symfony\Component\HttpFoundation\Response;

class UpdateKategoriRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => [
                'required','string','max:50',
            ]
        ];
    }
}

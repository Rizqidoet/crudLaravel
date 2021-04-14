<?php

namespace App\Http\Requests\Resep;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Recipes;
use Symfony\Component\HttpFoundation\Response;

class StoreRecipesRequest extends FormRequest
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
            'title' => [
                'required','string','max:50',
            ],
            'category_id' => [
                'required','integer','max:3',
            ],
            'isvegan' => [
                'required','integer','max:3',
            ],
            'stories' => [
                'required','string','max:150',
            ],
            'serving' => [
                'required','integer','max:3',
            ],
            'preptime' => [
                'required','integer','max:3',
            ],
            'cooktime' => [
                'required','integer','max:3',
            ],
            'calories' => [
                'required','integer','max:3',
            ],
            'level' => [
                'required','integer','max:3',
            ],
            'budget' => [
                'required','integer','max:3',
            ],
            'status' => [
                'required','integer','max:3',
            ],
            'ishalal' => [
                'required','integer','max:3',
            ],
            'isvegan' => [
                'required','integer','max:3',
            ],

        ];
    }
}

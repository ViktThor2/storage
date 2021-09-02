<?php

namespace App\Http\Requests;

use App\Models\Stock;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateStockRequest extends FormRequest
{
    public function authorize()
    {
        return true
    }

    public function rules()
    {
        return [
            'asset_id'      => [
                'required',
                'integer'],
            'current_stock' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647'],
        ];

    }
}

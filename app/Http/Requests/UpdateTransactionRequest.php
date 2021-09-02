<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'asset_id' => [
                'required',
                'integer'],
            'user_id'  => [
                'required',
                'integer'],
            'stock'    => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647'],
        ];

    }
}

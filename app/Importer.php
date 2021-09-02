<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Importer extends Model
{
    use HasFactory;

    public function setRequest($request)
    {
        $this->name = $request['name'];
        $this->company_name = $request['company_name'];
        $this->tax_number = $request['tax_number'];
        $this->contact_name = $request['contact_name'];
        $this->contact_phone = $request['contact_phone'];
        $this->adress = $request['adress'];
        $this->email = $request['email'];
    }

    public function scopeSearch($query, $data)
    {
        $query->where('name', 'LIKE', '%' . $data . '%');
    }

}

<?php

namespace App\Models\Api;

use App\Http\Requests\Api\StoreEventRequest;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function store(StoreEventRequest $request){
        dd($request->teste);
    }
}

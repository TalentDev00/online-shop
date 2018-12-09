<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ShopInformationResource;
use App\Models\ShopInformation;
use App\Http\Controllers\Controller;


class CategoryController extends Controller
{
    public function index()
    {
        return new ShopInformationResource(ShopInformation::with( ['categories.children', 'vouchers.users:user_id'])->first());
    }
}

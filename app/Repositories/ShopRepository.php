<?php

namespace App\Repositories;

use App\Models\Shop;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Hash;

class ShopRepository
{

    public static function all()
    {
        return Shop::get();
    }

    public static function getShopById(string $id): Shop
    {
        return Shop::findOrFail($id);
    }

    public static function createShop(array $data): Shop
    {
        return Shop::create($data);
    }

    public static function deleteShop(string $id): bool
    {
        return Shop::find($id)->delete();
    }
}

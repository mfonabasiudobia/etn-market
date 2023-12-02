<?php

namespace App\Repositories;

use App\Models\Market;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Hash;

class MarketRepository
{


    public static function all()
    {
        return Market::get();
    }

    public static function getMarketById(string $id): Market
    {
        return Market::findOrFail($id);
    }

    public static function createMarket(array $data): Market
    {
        return Market::create($data);
    }

    public static function deleteMarket(string $id): bool
    {
        return Market::find($id)->delete();
    }
}

<?php

namespace Bslm\Stock\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Bslm\Stock\Http\Models\StockShareholders;

class StockShareholdersController extends Controller
{
    public static function getByUserId($userid)
    {
        is_allowed('stock');

        $res = StockShareholders::firstOrCreate(['person_id' => $userid]);
        return $res->id;
    }

    public static function getByUserShareholderId($shareholderId)
    {
        is_allowed('stock');

        $res = StockShareholders::firstOrCreate(['id' => $shareholderId]);
        return $res->person_id;
    }
}

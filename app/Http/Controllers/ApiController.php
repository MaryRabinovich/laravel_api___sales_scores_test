<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiUpdateRequest;
use App\Services\ApiDbMaster;
use App\Services\ScoresCalculator;

class ApiController extends Controller
{
    public function update(ApiUpdateRequest $request)
    {
        $scores = (new ScoresCalculator())->getScores($request->items);

        (new ApiDbMaster())->pushToDb(
            $request->only('id', 'client_id', 'status'),
            $request->items,
            $scores
        );

        return response()->json([
            'order_id' => $request->id,
            'client_id' => $request->client_id,
            'scores' => $scores
        ]);
    }
}

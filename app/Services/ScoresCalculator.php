<?php

namespace App\Services;

use App\Models\Sales;

class ScoresCalculator
{
    public function getScores(array $items): int
    {
        $inSales = Sales::select(['article', 'points'])
            ->get()->pluck('points', 'article')->all();

        $scores = 0;

        foreach ($items as $item) {
            $article = $item['article'];

            if (array_key_exists($article, $inSales)) {
                $points = $inSales[$article];

                $scores += $item['quantity'] * $points;
            }
        }

        return $scores;
    }
}

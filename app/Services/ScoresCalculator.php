<?php

namespace App\Services;

class ScoresCalculator
{
    public function getScores(array $items): int
    {
        // скидочные артикулы должны бы браться из БД
        // но в задании вроде хардкод
        $inSales = [
            '3005-13' => 3
        ];

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

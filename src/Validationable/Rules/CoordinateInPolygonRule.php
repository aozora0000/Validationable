<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Helpers\Str;
use Validationable\Parameters;

/**
 * 点(lat,lon)が多角形内に含まれるかを判定（レイキャスティング法）
 * - 値: "lat,lon" 形式の文字列
 * - 引数: 多角形の各頂点を "lat,lon" 形式で並べた配列（少なくとも3点）
 */
class CoordinateInPolygonRule implements RuleInterface
{
    private function parsePoint(string $s): ?array
    {
        $parts = array_map('trim', explode(',', $s));
        if (count($parts) !== 2 || !is_numeric($parts[0]) || !is_numeric($parts[1])) {
            return null;
        }

        return [(float)$parts[0], (float)$parts[1]]; // [lat, lon]
    }

    private function pointInPolygon(array $point, array $polygon): bool
    {
        // $point = [lat, lon]; $polygon = [[lat, lon], ...]
        $x = $point[1]; // lon
        $y = $point[0]; // lat
        $inside = false;
        $n = count($polygon);
        for ($i = 0, $j = $n - 1; $i < $n; $j = $i++) {
            $xi = $polygon[$i][1]; $yi = $polygon[$i][0];
            $xj = $polygon[$j][1]; $yj = $polygon[$j][0];
            $intersect = (($yi > $y) !== ($yj > $y))
                && ($x < ($xj - $xi) * ($y - $yi) / (($yj - $yi) ?: 1e-12) + $xi);
            if ($intersect) {
                $inside = !$inside;
            }
        }

        return $inside;
    }

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!Str::of($value) || $value === '') {
            return false;
        }

        $p = $this->parsePoint((string)$value);
        if ($p === null) {
            return false;
        }

        if (count($arguments) < 3) {
            return false; // 三角形以上が必要
        }

        $poly = [];
        foreach ($arguments as $argument) {
            if (!Str::of($argument)) {
                return false;
            }

            $pt = $this->parsePoint((string)$argument);
            if ($pt === null) {
                return false;
            }

            $poly[] = $pt;
        }

        return $this->pointInPolygon($p, $poly);
    }
}

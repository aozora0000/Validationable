<?php

namespace Validationable\Rules;

use Validationable\Contracts\RuleInterface;
use Validationable\Parameters;

class GeoJsonRule implements RuleInterface
{

    public function passes(string $attribute, mixed $value, Parameters $parameters, array $arguments = []): bool
    {
        if (!is_string($value) && !is_array($value)) {
            return false;
        }

        $data = is_string($value) ? json_decode($value, true) : $value;

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
            return false;
        }

        if (!isset($data['type']) || !isset($data['coordinates'])) {
            return false;
        }

        // 特定のタイプが指定されている場合は検証
        if (!empty($arguments[0]) && $data['type'] !== $arguments[0]) {
            return false;
        }

        // 座標の検証
        return $this->validateCoordinates($data['type'], $data['coordinates']);
    }

    private function validateCoordinates(string $type, array $coordinates): bool
    {
        switch ($type) {
            case 'Point':
                return $this->isValidPosition($coordinates);

            case 'MultiPoint':
                foreach ($coordinates as $coordinate) {
                    if (!$this->isValidPosition($coordinate)) {
                        return false;
                    }
                }

                return true;

            case 'LineString':
                if (count($coordinates) < 2) {
                    return false;
                }

                foreach ($coordinates as $coordinate) {
                    if (!$this->isValidPosition($coordinate)) {
                        return false;
                    }
                }

                return true;

            case 'MultiLineString':
                foreach ($coordinates as $coordinate) {
                    if (count($coordinate) < 2) {
                        return false;
                    }

                    foreach ($coordinate as $point) {
                        if (!$this->isValidPosition($point)) {
                            return false;
                        }
                    }
                }

                return true;

            case 'Polygon':
                foreach ($coordinates as $coordinate) {
                    if (count($coordinate) < 4) {
                        return false;
                    }

                    // 最初と最後の点が一致するか
                    if ($coordinate[0] !== $coordinate[count($coordinate) - 1]) {
                        return false;
                    }

                    foreach ($coordinate as $point) {
                        if (!$this->isValidPosition($point)) {
                            return false;
                        }
                    }
                }

                return true;

            case 'MultiPolygon':
                foreach ($coordinates as $coordinate) {
                    foreach ($coordinate as $ring) {
                        if (count($ring) < 4) {
                            return false;
                        }

                        // 最初と最後の点が一致するか
                        if ($ring[0] !== $ring[count($ring) - 1]) {
                            return false;
                        }

                        foreach ($ring as $point) {
                            if (!$this->isValidPosition($point)) {
                                return false;
                            }
                        }
                    }
                }

                return true;

            default:
                return false;
        }
    }

    /**
     * 座標位置が有効かどうかを検証
     */
    private function isValidPosition(array $position): bool
    {
        // 少なくとも経度と緯度を含む
        if (count($position) < 2) {
            return false;
        }

        // 数値であることを確認
        foreach ($position as $coordinate) {
            if (!is_numeric($coordinate)) {
                return false;
            }
        }

        // 経度は -180 から 180 の範囲
        if ($position[0] < -180 || $position[0] > 180) {
            return false;
        }

        // 緯度は -90 から 90 の範囲
        return $position[1] >= -90 && $position[1] <= 90;
    }
}
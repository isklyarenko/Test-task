<?php

namespace Helpers;

use DB;

/**
 * Class Helper
 * @package Helpers
 */
class Helper
{
    /**
     * Returns a list of all brands
     * @return array
     */
    public static function getBrands()
    {
        $result = [];
        $brands = DB::query("SELECT id, name FROM brands ORDER BY name ASC");

        if ($brands) {
            foreach ($brands as $brand) {
                $result[$brand['id']] = $brand['name'];
            }
        }

        return $result;
    }

    /**
     * Returns a list of all sizes
     * @return array
     */
    public static function getSizes()
    {
        $result = [];
        $sizes = DB::query("SELECT id, name FROM sizes ORDER BY id ASC");

        if ($sizes) {
            foreach ($sizes as $size) {
                $result[$size['id']] = $size['name'];
            }
        }

        return $result;
    }

    /**
     * Converts an array to select options HTML
     * @param array $items
     * @param string $selected
     * @return string
     */
    public static function convertToOptions($items, $selected = '')
    {
        if (empty($items)) {
            return '';
        }

        $result = '<option value="">Select</option>';
        foreach ($items as $key => $item) {
            $default = ($selected == $key) ? 'selected' : '';
            $result .= "<option value='$key' $default>$item</option>";
        }

        return $result;
    }
}
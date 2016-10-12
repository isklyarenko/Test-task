<?php

namespace Helpers;

use DB;

/**
 * Class Search
 * @package Helpers
 */
class Search
{
    /**
     * @var string
     */
    private $searchText;
    /**
     * @var string
     */
    private $brand;
    /**
     * @var string
     */
    private $size;

    /**
     * Search constructor.
     * @param string $searchText
     * @param string $brand
     * @param string $size
     */
    public function __construct($searchText = '', $brand = '', $size = '')
    {
        $this->searchText = $searchText;
        $this->brand = $brand;
        $this->size = $size;
    }

    /**
     * Generates SQL of conditional query based on selected filters and keywords
     * @return string
     */
    private function prepareConditions()
    {
        $subquery = 'SELECT p.id FROM products as p ';

        if (!empty($this->size)) {
            $subquery .= 'INNER JOIN product_sizes as ps ON p.id = ps.product_id AND ps.size_id = ' . $this->size;
        }

        if (!empty($this->searchText)) {
            preg_match_all('/(\pL{3,})/iu', $this->searchText, $matches);

            $subquery .= ' INNER JOIN product_keywords AS pk ON p.id = pk.product_id
                         INNER JOIN keywords AS k ON pk.word_id = k.id AND k.word IN ("' . implode('","', $matches[0]) . '")';
        }

        if (!empty($this->brand)) {
            $subquery .= ' WHERE p.brand_id = ' . $this->brand;
        }

        if (!empty($this->searchText)) {
            $subquery .= ' GROUP BY p.id
                           ORDER BY count(frequency) DESC';
        }

        return $subquery;
    }

    /**
     * Generates SQL of main search query
     * @return string
     */
    private function prepareQuery()
    {
        $subquery = $this->prepareConditions();

        $query = 'SELECT p.id, p.name, b.id as brandId, b.name as brand, t.name as type, s.name as size
                        FROM products AS p
                        LEFT JOIN brands AS b ON p.brand_id = b.id
                        LEFT JOIN types AS t ON p.type_id = t.id
                        LEFT JOIN product_sizes as ps ON p.id = ps.product_id
                        LEFT JOIN sizes as s ON ps.size_id = s.id
                        INNER JOIN (' . $subquery . ') AS filtered on p.id = filtered.id';

        return $query;
    }

    /**
     * Performs search
     * @return array
     */
    public function search()
    {
        $query = $this->prepareQuery();
        $results = DB::query($query);

        return $results;
    }
}
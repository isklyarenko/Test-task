<?php

define('APP_DIR', realpath(__DIR__ . '/..'));
define('CONFIG_DIR', APP_DIR . '/config');
define('VENDOR_DIR', APP_DIR . '/vendor');

$loader = require_once VENDOR_DIR . '/autoload.php';
$loader->add('Helpers\\', APP_DIR);
require_once CONFIG_DIR . '/config.php';

echo date('H:i:s',time()) . PHP_EOL;

// Truncate tables "keywords" and "product_keywords"
echo 'Truncating "product_keywords" table...'. PHP_EOL;
var_dump(DB::query("SET FOREIGN_KEY_CHECKS = 0;"));
var_dump(DB::query("TRUNCATE TABLE  product_keywords"));
echo 'Truncating "keywords" table...' . PHP_EOL;
var_dump(DB::query("TRUNCATE TABLE  keywords"));
var_dump(DB::query("SET FOREIGN_KEY_CHECKS = 1;"));


$products = DB::query("SELECT p.id, p.name, b.name as brand, t.name as type
                  FROM products as p
                  LEFT JOIN brands as b ON p.brand_id = b.id
                  LEFT JOIN types as t ON p.type_id = t.id");

foreach ($products as $product) {
    echo 'Processing product ' . $product['id'] . PHP_EOL;

    $text = $product['name'] . ' ' . $product['brand'] . ' ' . $product['type'];

    // get all words longer 3 characters
    preg_match_all('/(\pL{3,})/iu', $text, $matches);

    if(empty($matches[0])) continue;

    $keywords = [];
    foreach($matches[0] as $word){
        $keywords[] = [$word];
    }

    // INSERT IGNORE in order not to use 2 operation insert/update
    DB::query("INSERT IGNORE INTO %b %lb VALUES %?", 'keywords', ['word'], $keywords);

    $wordIds = DB::query("SELECT id FROM keywords WHERE `word` IN %ls", $matches[0]);

    $productKeywords = [];
    foreach ($wordIds as $id) {
        $productKeywords[] = [$product['id'], $id['id']];
    }

    // Increase keyword frequency in product already has this keyword. Key "product_keyword" is unique
    DB::query("INSERT INTO %b %lb VALUES %? ON DUPLICATE KEY UPDATE frequency = frequency+1",
        'product_keywords',
        ['product_id', 'word_id'],
        $productKeywords
    );
}

echo 'Done at ' . date('H:i:s',time()) . PHP_EOL;


echo count($products);

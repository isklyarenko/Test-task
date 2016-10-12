<?php

define('APP_DIR', realpath(__DIR__ . '/..'));
define('CONFIG_DIR', APP_DIR . '/config');
define('VENDOR_DIR', APP_DIR . '/vendor');

$loader = require_once VENDOR_DIR . '/autoload.php';
$loader->add('Helpers\\', APP_DIR);
require_once CONFIG_DIR . '/config.php';

echo date('H:i:s', time()) . PHP_EOL;

// Truncate tables "brands", "products" and "product_sizes"
echo 'Truncating "brands" table...' . PHP_EOL;
var_dump(DB::query("SET FOREIGN_KEY_CHECKS = 0;"));
var_dump(DB::query("TRUNCATE TABLE  brands"));

echo 'Truncating "products" table...' . PHP_EOL;
var_dump(DB::query("TRUNCATE TABLE  products"));

echo 'Truncating "product_sizes" table...' . PHP_EOL;
var_dump(DB::query("TRUNCATE TABLE  product_sizes"));
var_dump(DB::query("SET FOREIGN_KEY_CHECKS = 1;"));

echo 'Generating of brands...' . PHP_EOL;


// create a Faker\Generator instance
$fakerEn = \Faker\Factory::create('en_EN');
$fakerFr = Faker\Factory::create('fr_FR');
$fakerDk = Faker\Factory::create('da_DK');
$fakerRu = Faker\Factory::create('ru_RU');
$faker = $fakerEn;


// generate brands in 4 different languages
$brands = [];
for ($i = 1; $i <= 2000; $i++) {
    if ($i == 500) $faker = $fakerFr;
    if ($i == 1000) $faker = $fakerDk;
    if ($i == 1500) $faker = $fakerRu;

    $brands[] = [$faker->company];
}
DB::query("INSERT INTO %b %lb VALUES %?", 'brands', ['name'], $brands);

echo count($brands) . ' brands were added' . PHP_EOL;
echo 'Generating of products... It may take some time, make some coffee :)' . PHP_EOL;


// generate products and product sizes
$products = [];
$productSizes = [];
$count = 10000;
$faker = $fakerEn;

for ($j = 1; $j <= 110000; $j++) {

    if ($j == 40000) $faker = $fakerFr;
    if ($j == 75000) $faker = $fakerDk;
    if ($j == 95000) $faker = $fakerRu;

    // Some values are hardcoded in order to minimize unnecessary db queries
    $type = rand(1, 2); // 1 - dresses, 2 - shoes
    $products[] = [$faker->realText(100), rand(1, 2000), $type]; // 1-2000 is a random brand id
    $productSizes[] = [$j, ($type == 1) ? rand(1, 3) : rand(4, 14)]; // get random size depending on the type

    // adding of products and product sizes is in increments of 10000 items
    if ($j == $count) {
        DB::query("INSERT INTO %b %lb VALUES %?", 'products', ['name', 'brand_id', 'type_id'], $products);
        DB::query("INSERT INTO %b %lb VALUES %?", 'product_sizes', ['product_id', 'size_id'], $productSizes);
        echo 'Added ' . $count . ' products.' . PHP_EOL;
        $products = [];
        $productSizes = [];
        $count += 10000;
    }
}

echo 'Adding of projects is finished. Thank you for patience' . PHP_EOL;
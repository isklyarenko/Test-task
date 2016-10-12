<?php
use Helpers\Helper;
use Helpers\Search;

$keywords = '';
$brand = '';
$size = '';
$brands = Helper::getBrands();
$sizes = Helper::getSizes();
$products = [];
$showResults = false;

if (isset($_GET['search_filed'])) {
    $keywords = isset($_GET['search_filed']) ? strip_tags($_GET['search_filed']) : '';
    $brand = isset($_GET['brand']) ? $_GET['brand'] : '';
    $size = isset($_GET['size']) ? $_GET['size'] : '';

    if (!$keywords && !$brand && !$size) {
        echo '<span style="color: red">Please select at least one of search fields</span>';
    } elseif (!empty($keywords) && strlen($keywords) < 3) {
        echo '<span style="color: red">Please fill in at least 3 characters in search field</span>';
    } else {
        $showResults = true;
        $products = (new Search($keywords, $brand, $size))->search();

        if (!empty($products)) {
            $brands = [];
            foreach ($products as $product) {
                $brands[$product['brandId']] = $product['brand'];
            }
            asort($brands);
        }
    }
}
?>
    <form name="search" action="index.php" method="get">
        <input type="text" name="search_filed"
               value="<?php echo $keywords; ?>"/>
        <select name="brand"
                style="height: 300px; overflow-y: scroll !important;"><?php echo Helper::convertToOptions($brands, $brand); ?></select>
        <select name="size"
                style="height: 300px; overflow-y: scroll !important;"><?php echo Helper::convertToOptions($sizes, $size); ?></select>
        <input type="submit" value="Search">
    </form>

<?php
if ($showResults) {
    if (empty($products)) {
        echo 'There are no relevant products';
    } else {
        include 'results.php';
    }
}
?>
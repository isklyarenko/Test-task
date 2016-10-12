<table border="1">
    <thead>
    <th>Product ID</th>
    <th>Product Name</th>
    <th>Brand</th>
    <th>Type</th>
    <th>Size</th>
    </thead>
    <tbody>
    <?php  foreach ($products as $product): ?>
        <tr>
            <td><?php echo $product['id']; ?></td>
            <td><?php echo $product['name']; ?></td>
            <td><?php echo $product['brand']; ?></td>
            <td><?php echo $product['type']; ?></td>
            <td><?php echo $product['size']; ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
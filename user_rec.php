<?php
// Define actual product counts
$actual_product_counts = [

    "Our Home Sofa" => 45,
    "Christan Sectional Sofa" => 42,
    "Aubrey Bedframe" => 35,
    "Copenhagen Sectional" => 32,
    "Portland Bar Set" => 30,
    "Hallie Bar Set" => 16,
    "Verel 3 seater sofa" => 16,
    "Our Home verel 2 seater sofa" => 16
];

// Given data set
$data_set = [
    ["Our Home Sofa", 1],
    ["Aubrey Bedframe", 1],
    ["Christan Sectional Sofa", 1],
    ["Hallie Bar Set", 1],
    ["Our Home Sofa", 1],
    ["Christan Sectional Sofa", 1],
    ["Our Home Sofa", 1],
    ["Portland Bar Set", 1],
    ["Our Home Sofa", 1],
    ["Aubrey Bedframe", 1],
    ["Our Home Sofa", 1],
    ["Christan Sectional Sofa", 1],
    ["Our Home Sofa", 1],
    ["Copenhagen Sectional", 1],
    ["Aubrey Bedframe", 1],
    ["Portland Bar Set", 1],
    ["Christan Sectional Sofa", 1],
    ["Our Home Sofa", 1],
    ["Copenhagen Sectional", 1],
    ["Portland Bar Set", 1],
    ["Verel 3 seater sofa", 1],
    ["Our Home verel 2 seater sofa", 1]
    // Add more entries from your data set here...
];

// Count occurrences of each product
$product_counts = [];
foreach ($data_set as $item) {
    $product = $item[0];
    if (isset($product_counts[$product])) {
        $product_counts[$product]++;
    } else {
        $product_counts[$product] = 1;
    }
}

// Sort products based on occurrence count
arsort($product_counts);

// Calculate the adjustment factor to reach 350 total products
$total_desired_count = 350;
$total_current_count = array_sum($product_counts);
$adjustment_factor = $total_desired_count / $total_current_count;

// Adjust counts of each product proportional to their frequency
foreach ($product_counts as $product => $count) {
    $product_counts[$product] = round($count * $adjustment_factor);
}

// Re-sort products based on adjusted counts
arsort($product_counts);

// Fill in missing products to reach the desired total count
$missing_count = $total_desired_count - array_sum($product_counts);
foreach ($product_counts as $product => &$count) {
    if ($missing_count > 0) {
        $count += $product_counts[$product];
        $missing_count -= $product_counts[$product];
    } else {
        break;
    }
}

// Define the most paired product
$most_paired_product = key($product_counts);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Confusion Matrix</title>
<style>
    .container {
        display: flex;
        align-items: center;
    }
    .table-container {
        padding: 20px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #dddddd;
        text-align: center;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }
    .highlight {
        font-weight: bold;
        background-color: #ffd966;
    }
    .our-home-sofa {
        background-color: #ffcccb;
    }
    .other-products {
        background-color: #b0e0e6;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="table-container">
            <h2 style="text-align: center;">Confusion Matrix</h2>
            <table>
                <tr>
                    <th rowspan="2"></th>
                    <th colspan="2">Predicted</th>
                    <th rowspan="2">Total</th>
                </tr>
                <tr>
                    <th>Our Home Sofa</th>
                    <th>Other Products</th>
                </tr>
                <?php foreach ($actual_product_counts as $product => $count): ?>
                    <tr>
                        <td><?php echo $product; ?></td>
                        <td class="<?php echo ($product === $most_paired_product) ? 'highlight our-home-sofa' : 'other-products'; ?>"><?php echo ($product === $most_paired_product) ? $count : ''; ?></td>
                        <td class="other-products"><?php echo ($product !== $most_paired_product) ? $count : ''; ?></td>
                        <td><?php echo $count; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>

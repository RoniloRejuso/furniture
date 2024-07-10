<?php
require_once('tcpdf/tcpdf.php'); // Ensure the path is correct

// Database connection details
$servername = "localhost";  // Replace with your server name
$username = "u138133975_ourhome";  // Replace with your MySQL username
$password = "A@&DDb;7";  // Replace with your MySQL password
$dbname = "u138133975_furniture";  // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cart items query
<<<<<<< HEAD
$query = "SELECT cart_item_id, cart_id, product_id, quantity, amount FROM cart_items ORDER BY cart_item_id DESC LIMIT 9"; // Adjust limit as needed
=======
<<<<<<< HEAD
$query = "SELECT cart_item_id, cart_id, product_id, quantity, amount FROM cart_items ORDER BY cart_item_id DESC LIMIT 9"; // Adjust limit as needed
=======
<<<<<<< HEAD
$query = "SELECT cart_item_id, cart_id, product_id, quantity, amount FROM cart_items ORDER BY cart_item_id DESC LIMIT 9"; // Adjust limit as needed
=======
$query = "SELECT cart_item_id, cart_id, product_id, quantity, amount
          FROM cart_items
          ORDER BY cart_item_id DESC
          LIMIT 9"; // Adjust limit as needed
>>>>>>> b68a38d76038cea4c49156dfeafeb59dd52b37c8
>>>>>>> b6b93d693c913d05296d8548b7e741bd2bd6313e
>>>>>>> cbc680c9ba4b9d5710445edd16ae8fb866fcf4ab

$result = $conn->query($query);

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Cart Items Report');
$pdf->SetSubject('Report of Cart Items');
$pdf->SetKeywords('TCPDF, PDF, report, cart items');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Cart Items Report', 'Generated on: ' . date('Y-m-d H:i:s'));

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Column titles
$header = array('Cart Item ID', 'Cart ID', 'Product ID', 'Quantity', 'Amount');

// Print table header
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');

$w = array(30, 30, 30, 30, 30); // Column widths
$num_headers = count($header);
for ($i = 0; $i < $num_headers; ++$i) {
    $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
}
$pdf->Ln();

// Restore font and colors
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);
$pdf->SetFont('');

// Print table rows
$fill = 0;

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
// Sample data row
$pdf->Cell($w[0], 6, '1', 'LR', 0, 'C', $fill);
$pdf->Cell($w[1], 6, '1', 'LR', 0, 'L', $fill);
$pdf->Cell($w[2], 6, '101', 'LR', 0, 'L', $fill);
$pdf->Cell($w[3], 6, '2', 'LR', 0, 'L', $fill);
$pdf->Cell($w[4], 6, '50.00', 'LR', 0, 'L', $fill);
$pdf->Ln();
$fill = !$fill;

>>>>>>> b68a38d76038cea4c49156dfeafeb59dd52b37c8
>>>>>>> b6b93d693c913d05296d8548b7e741bd2bd6313e
>>>>>>> cbc680c9ba4b9d5710445edd16ae8fb866fcf4ab
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell($w[0], 6, $row['cart_item_id'], 'LR', 0, 'C', $fill);
        $pdf->Cell($w[1], 6, $row['cart_id'], 'LR', 0, 'L', $fill);
        $pdf->Cell($w[2], 6, $row['product_id'], 'LR', 0, 'L', $fill);
        $pdf->Cell($w[3], 6, $row['quantity'], 'LR', 0, 'L', $fill);
        $pdf->Cell($w[4], 6, $row['amount'], 'LR', 0, 'L', $fill);
        $pdf->Ln();
        $fill = !$fill;
    }
} else {
    $pdf->Cell(array_sum($w), 6, 'No cart items found', 'LR', 0, 'C', $fill);
    $pdf->Ln();
}

// Closing line
$pdf->Cell(array_sum($w), 0, '', 'T');

<<<<<<< HEAD
// Output PDF to browser for download
$pdf->Output('cart_items_report.pdf', 'D'); // 'D' parameter forces download
=======
<<<<<<< HEAD
// Output PDF to browser for download
$pdf->Output('cart_items_report.pdf', 'D'); // 'D' parameter forces download
=======
<<<<<<< HEAD
// Output PDF to browser for download
$pdf->Output('cart_items_report.pdf', 'D'); // 'D' parameter forces download
=======
// Output PDF to uploads directory
$pdf->Output(__DIR__ . '/uploads/cart_items_report.pdf', 'F');
>>>>>>> b68a38d76038cea4c49156dfeafeb59dd52b37c8
>>>>>>> b6b93d693c913d05296d8548b7e741bd2bd6313e
>>>>>>> cbc680c9ba4b9d5710445edd16ae8fb866fcf4ab

// Close connection
$conn->close();
?>
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cart Items PDF Generation</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<script>
    Swal.fire({
        title: 'Success!',
        text: 'Cart items report generated successfully',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'orders.php';
        }
    });
</script>
</body>
</html>
>>>>>>> b68a38d76038cea4c49156dfeafeb59dd52b37c8
>>>>>>> b6b93d693c913d05296d8548b7e741bd2bd6313e
>>>>>>> cbc680c9ba4b9d5710445edd16ae8fb866fcf4ab

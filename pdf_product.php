<?php
require_once('tcpdf/tcpdf.php');

// Extend TCPDF
class MYPDF extends TCPDF {
    // Page header
    public function Header() {
        // Set font
        $this->SetFont('helvetica', 'B', 12);
        // Title
        $this->Cell(0, 10, 'Product List Report', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        // Line break
        $this->Ln(10);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
$l = array(
    'a_meta_charset' => 'UTF-8',
    'a_meta_dir' => 'ltr',
    'a_meta_language' => 'en',
    'w_page' => 'page',
);

// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ronilo Rejuso');
$pdf->SetTitle('Product List Report');
$pdf->SetSubject('Product List');
$pdf->SetKeywords('TCPDF, PDF, product list, report');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

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

// Set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// Add a page
$pdf->AddPage();

// Fetch data from the database
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'furniture';

$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

// Output data of each row in a table format
if ($result->num_rows > 0) {
    // Table header
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(30, 10, 'Product ID', 1, 0, 'C');
    $pdf->Cell(60, 10, 'Product Name', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Status', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Price', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Quantity', 1, 1, 'C');

    // Table data
    $pdf->SetFont('helvetica', '', 10);
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, $row["product_id"], 1, 0, 'C');
        $pdf->Cell(60, 10, $row["product_name"], 1, 0, 'C');
        $pdf->Cell(30, 10, $row["status"], 1, 0, 'C');
        $pdf->Cell(30, 10, $row["price"], 1, 0, 'C');
        $pdf->Cell(30, 10, $row["quantity"], 1, 1, 'C');
    }
} else {
    $pdf->Cell(0, 10, '0 results', 0, 1);
}

// Close database connection
$conn->close();

// ---------------------------------------------------------

// Close and output PDF document
// Close and output PDF document
$outputPath = __DIR__ . '/uploads/product_list.pdf';

// Close and output PDF document
$pdf->Output($outputPath, 'F');

// Generate JavaScript code to display alert and redirect
echo "<script>";
echo "alert('PDF report generated. Check uploads folder for the product report.');";
echo "window.location.href = 'productlist.php';";
echo "</script>";

?>

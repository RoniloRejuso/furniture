<?php
include 'dbcon.php';
require_once('tcpdf/tcpdf.php');
$query = "SELECT user_id, firstname, lastname, email FROM users ORDER BY user_id DESC";
$result = $conn->query($query);

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Users List');
$pdf->SetSubject('Users List');
$pdf->SetKeywords('TCPDF, PDF, users, list');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, 'Users List', 'Generated on: ' . date('Y-m-d H:i:s'));

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
$header = array('User ID', 'First Name', 'Last Name', 'Email');

// Print table header
$pdf->SetFillColor(255, 255, 255);
$pdf->SetTextColor(0);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(0.3);
$pdf->SetFont('', 'B');

$w = array(30, 50, 50, 50); // Column widths
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

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell($w[0], 6, $row['user_id'], 'LR', 0, 'C', $fill);
        $pdf->Cell($w[1], 6, $row['firstname'], 'LR', 0, 'L', $fill);
        $pdf->Cell($w[2], 6, $row['lastname'], 'LR', 0, 'L', $fill);
        $pdf->Cell($w[3], 6, $row['email'], 'LR', 0, 'L', $fill);
        $pdf->Ln();
        $fill = !$fill;
    }
} else {
    $pdf->Cell(array_sum($w), 6, 'No users found', 'LR', 0, 'C', $fill);
    $pdf->Ln();
}

// Closing line
$pdf->Cell(array_sum($w), 0, '', 'T');

// Output PDF to browser for download
$pdf->Output('users_list.pdf', 'D'); // 'D' parameter forces download

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Users List PDF Generation</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        // Show SweetAlert popup
        Swal.fire({
            title: 'PDF Generated',
            text: 'The users list PDF has been generated successfully.',
            icon: 'success',
            confirmButtonText: 'Download PDF'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'generate_pdf.php'; // Replace with the path to your PHP script
            }
        });
    </script>
</body>
</html>

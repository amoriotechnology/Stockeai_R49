<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-table th, .invoice-table td {
/*            border: 1px solid #ddd;*/
            padding: 8px;
        }
        .textdirleft{
            text-align: left;
        }
        .textdirright{
            text-align: right;
        }
        .right-image {
            max-width: 100px; 
            height: auto;
        }
        
       /* .invoice-table th {
            background-color: #f4f4f4;
        }*/
    </style>
</head>
<body>
    <div class="invoice-header">
        <h3><?php echo $title; ?></h3>
        <p>Quotation ID: <?php echo $quotation_id; ?></p>
    </div>
    <table class="invoice-table">
        <thead>
            <tr>
                <th class="textdirleft">Description</th>
                <th class="textdirleft">:</th>
                <td class="text-left">Left</td>
                <th class="textdirright">Amount</th>
                <th class="textdirleft">:</th>
                <td class="text-right">
                    <img src="path_to_your_image.jpg" alt="Image" class="right-image">
                </td>
            </tr>
        </thead>
    </table>
</body>
</html>

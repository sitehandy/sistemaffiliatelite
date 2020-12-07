<?php
include "../pwjafflite_affiliate_data.php";

// Get product product
$result = mysql_query("SELECT * FROM produk WHERE idproduk = '4'", $database_connection) or die ('Database Connection Error');

if (mysql_num_rows($result))
{
    while ($product = mysql_fetch_array($result))
    {
        $product_price = $product['hargaproduk'];
    }
}
else
{
    $product_price = null;
}
?>
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<!-- Animate CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
<!-- Fontawesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">

<style>
body {
    padding-top: 3.5rem;
    padding-bottom: 30px;
    font-family: 'Raleway', sans-serif;
    font-size: 14px;
}
</style>
<title>Online Group Coaching Buat Online Sales</title>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">CikguHafis</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="http://buatonlinesales.com">Utama <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Hubungi</a>
            </li>
        </ul>
    </div>
</nav>

<main role="main">

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
    <div class="container">
        <h3 class="text-center">Tempahan Online Group Coaching Buat Online Sales</h3>
        <p class="text-center">Sila Ikuti Langkah Mudah Berikut Untuk Membuat Tempahan.</p>
    </div>
</div>

<div class="container">

    <form id="validate-form" method="post" enctype="multipart/form-data" action="form-processing.php">

    <div class="row mb-4 text-center">
        <div class="col-md-8 offset-md-2">

            <div class="card">
                <div class="card-header">
                    <strong>Butiran Pembelian</strong>
                </div>
                <div class="card-body">

                    <p>Berikut adalah butiran pembelian yang akan anda lakukan:</p>

                    <div class="table-responsive">
                    <table class="table table-hover table-sm">

                    <colgroup>
                        <col style="width: 60%">
                        <col style="width: 15%">
                        <col style="width: 25%">
                    </colgroup>

                    <thead class="thead-light">
                        <tr>
                            <th>PRODUK</th>
                            <th>KUANTITI</th>
                            <th>HARGA (RM)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Online Group Coaching Buat Online Sales</td>
                            <td>1</td>
                            <td><?php echo $product_price; ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>JUMLAH HARGA</strong></td>
                            <td><strong>1</strong></td>
                            <td>
                                <strong><?php echo $product_price; ?></strong>
                                <input type="hidden" name="product_price" value="<?php echo $product_price; ?>">
                            </td>
                        </tr>
                    </tfoot>
                    </table>
                    </div><!--/.table-responsive-->
                </div>
            </div>

        </div><!--/.col-->
    </div><!--/.row-->

    <div class="row mb-4 text-center">
        <div class="col-md-8 offset-md-2">

            <div class="card">
                <div class="card-header">
                    <strong>Butiran Pelanggan</strong>
                </div>
                <div class="card-body">

                    <p>Sila lengkapkan butiran yang diperlukan dibawah untuk meneruskan pembelian:</p>

                    <div class="form-group">
                        <input id="name" name="customer_name" type="text" class="form-control" placeholder="Nama Anda" required>
                    </div>

                    <div class="form-group">
                        <input id="email" name="customer_email" type="email" class="form-control" placeholder="Email Anda" required>
                    </div>

                    <div class="form-group">
                        <input id="phone" name="customer_phone" type="text" class="form-control" placeholder="No. Telefon Anda" required>
                    </div>

                    <div class="form-group">
                        <textarea id="address" name="customer_address" class="form-control" placeholder="Alamat Anda" required></textarea>
                    </div>

                </div>
            </div>

        </div><!--/.col-->
    </div><!--/.row-->

    <div class="row mb-4 text-center">
        <div class="col-md-8 offset-md-2">

            <div class="card">
                <div class="card-header">
                    <strong>Butiran Pembayaran</strong>
                </div>
                <div class="card-body">

                    <h3>Jumlah Bayaran: RM<?php echo $product_price; ?></h3>

                    <input type="image" src="toyyibpay.png">

                    <input type="hidden" name="ref" value="<?php if (isset($usernameaffiliate)) { echo $usernameaffiliate; } ?>">
                    <input type="hidden" name="product_id" value="2">
                    <input type="hidden" name="form_action" value="submit">
                </div>
                <div class="card-footer">
                    <div class="">
                        <button type="reset" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset Borang</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Buat Bayaran</button>
                    </div>
                </div>
            </div>

        </div><!--/.col-->
    </div><!--/.row-->

    </form>

</div><!-- /.container -->

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/js/all.min.js"></script>

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.min.js"></script>
<script>
$("#validate-form").validate({
    rules: {
        'attachments[0]': {
            required: true,
            accept: "image/*,application/pdf"
        },
            'attachments[1]': {
            required: true,
            accept: "image/*,application/pdf"
        }
    }
});
</script>

</body>
</html>

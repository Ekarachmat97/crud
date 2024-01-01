<?php
session_start();
require '../dbconn.php';

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Cek apakah tombol add to cart ditekan
if (isset($_POST['add_to_cart'])) {
    // Ambil ID produk dari tombol add to cart
    $product_id = $_POST['add_to_cart'];

    // Query untuk mendapatkan detail produk berdasarkan ID
    $product_query = mysqli_query($conn, "SELECT * FROM produk WHERE id = $product_id");
    $product = mysqli_fetch_array($product_query);

    // Tambahkan produk ke dalam session keranjang belanja
    $_SESSION['cart'][] = array(
        'id' => $product['id'],
        'namaproduk' => $product['namaproduk'],
        'harga' => $product['harga'],
        'quantity' => 1 // Default kuantitas
        // Tambahkan informasi produk lainnya sesuai kebutuhan
    );
    header("Location: index.php");
    exit();
}

// Tampilkan produk di keranjang belanja
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
         body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #000;
            margin-top: 20px;
        }

        .cart-container {
            width: 70%;
            margin: 20px auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        thead {
            background-color: #3498db;
            color: #fff;
        }

        td input {
            width: 30px;
            padding: 8px;
            text-align: center;
            margin-right: 10px; /* Tambahkan margin untuk memberi jarak */
        }

        td button {
            padding: 8px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        td button:hover {
            background-color: #1d5ca3;
        }

        a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            margin-top: 20px;
            display: block;
            text-align: center;
        }

        a:hover {
            color: #1d5ca3;
        }
        @media only screen and (max-width: 600px) {
            .cart-container {
                width: 100%;
            }
            h1 {
                font-size: 1.2em; /* Adjust the font size for smaller screens */
            }
            td, tr{
                font-size: 10px;
                width: 10px;
            }

            td input {
                width: 10px; /* Adjust the input width for smaller screens */
            }
        }
    </style>
    <title>Keranjang Belanja</title>
</head>
<body>
    <h1>Keranjang Belanja</h1>
    <div class="cart-container">
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Tampilkan produk yang ada di keranjang
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    $totalHarga = 0;
                    foreach ($_SESSION['cart'] as $key => $item) {
                        echo '<tr>';
                        echo '<td>' . $item['namaproduk'] . '</td>';
                        echo '<td>Rp ' . number_format($item['harga'], 0, ',', '.') . '</td>';
                        echo '<td>';
                        echo '<input type="number" name="quantity[]" value="' . $item['quantity'] . '" min="1" max="99">';
                        echo '<button onclick="updateQuantity(' . $key . ')"><i class="fas fa-sync-alt"></i></button>';
                        echo '</td>';
                        echo '<td>Rp ' . number_format($item['harga'] * $item['quantity'], 0, ',', '.') . '</td>';
                        echo '<td>';
                        echo '<button onclick="removeItem(' . $key . ')"  style="background-color:#ff1414;"><i class="fas fa-trash"></i></button>';
                        echo '</td>';
                        echo '</tr>';

                        $totalHarga += $item['harga'] * $item['quantity'];
                    }
                    echo '<tr>';
                    echo '<td colspan="3" style="text-align: right;"><strong>Total Harga</strong></td>';
                    echo '<td colspan="2"><strong>Rp ' . number_format($totalHarga, 0, ',', '.') . '</strong></td>';
                    echo '</tr>';
                    echo '<tr>';
                    echo '<td colspan="5" style="text-align: right;"><a href="checkout.php">Checkout</a></td>';
                    echo '</tr>';
                } else {
                    echo '<tr>';
                    echo '<td colspan="5">Keranjang belanja kosong</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <a href="index.php">Kembali ke Beranda</a>
    </div>

    <script>
        function removeItem(index) {
            var confirmation = confirm("Anda yakin ingin menghapus produk ini?");
            if (confirmation) {
                window.location.href = 'hapus_produk.php?index=' + index;
            }
        }

        function updateQuantity(index) {
            var newQuantity = document.getElementsByName('quantity[]')[index].value;
            window.location.href = 'update_quantity.php?index=' + index + '&quantity=' + newQuantity;
        }
    </script>
</body>
</html>

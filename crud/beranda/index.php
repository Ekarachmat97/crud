<?php
session_start();
require '../dbconn.php';

// Memeriksa apakah koneksi berhasil atau tidak
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

if (isset($_POST['add_to_cart'])) {
    // Mendapatkan nilai id_produk dari tombol add_to_cart
    $id_produk = $_POST['add_to_cart'];

    // Menambahkan produk ke dalam session cart
    $_SESSION['cart'][] = $id_produk;

    // Mengarahkan pengguna kembali ke halaman utama
    header("Location: index.php");
    exit();
}
// Inisialisasi jumlah produk di keranjang
$cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en" style="box-sizing: border-box">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- ICONS -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- MYSTYLE -->
    <link rel="stylesheet" href="styles.css">
    <title>Secca Food</title>
</head>
<body style="background-color:#eeeeee;">
<header id="top">
    <div class="navbar" data-header style="background-color:#373a3c;">
        <div class="menu-icon" id="menuIcon" onclick="toggleMenu()" style="color: #fff;"><i data-feather="menu"></i>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <h2 style="margin:0; color:#fff;">GOCAI.com</h2>
            <div class="cart-icon" id="shopping-cart-button" onclick="toggleCart()" style="color: #fff;">
                <a href="cart.php" style="color:#fff;"><i data-feather="shopping-cart"></i><span class="cart-count" id="cart-count"><?php echo $cartCount; ?></span></a>
            </div>
    </div>

    <div class="sidebar" style="background-color:#00adb5;">
        <ul>
            <li class="user-icon" id="profile-button" onclick="toggleProfile()"><i class="ph ph-user"></i></li>
            <li class="active"><a href="#top"><i data-feather="home"></i></a></li>
            <li><a href="#contact"><i data-feather="phone"></i></a></li>
            <li><a href="#about"><i data-feather="info"></i></a></li>
        </ul>
    </div>
</header>
<main>
    
    <h1 class="daftar-menu" style="color: #000;">Pilih kesukaanmu <br></h1>
    <div class="search-bar" >
            <form id="searchForm" onsubmit="searchProducts(); return false;" >
                <input type="text" id="searchInput" placeholder="Cari..." > 
            </form> 
            <button type="submit" class="searchbutton" style="background-color:#00adb5;"><i data-feather="search"></i></button>  
        </div>
    <section class="products" id="products" style="
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 4rem;
            margin-left: 20px;
            margin-right: 20px;
            justify-content: center;
            align-items: center;
    ">
        <?php
        $produk_query = mysqli_query($conn, "SELECT * FROM produk");

        // Memeriksa apakah terdapat produk atau tidak
        if (mysqli_num_rows($produk_query) > 0) {
            while ($produk = mysqli_fetch_array($produk_query)) {
                ?>
                <div class="product-card" style="border-radius: 5px; border: 1px solid #000;">
                    <h3 style="color:#000; text-shadow: none;"><?= $produk['namaproduk'] ?></h3>
                    <?php if (!empty($produk['gambar'])): ?>
                        <!-- Perbaikan di sini, gunakan $produk['gambar'] -->
                        <img src="../uploads<?php echo $produk['gambar']; ?>" alt="<?php echo $produk['namaproduk']; ?>" style="width: 100%; height: 100%; border-radius:10px;">
                    <?php endif; ?>
                    <p style="color:#000; font-size:10px"><?= $produk['deskripsi'] ?></p>
                    <div class="product-info" style="color:#000;">
                        <p>Harga: <span class="product-price"><?= $produk['harga'] ?></span></p>
                        <p>Stock: <?= $produk['stock'] ?></p>
                    </div>
                    <!-- button add cart -->
                    <form method="post" action="cart.php">
                        <button class="add-to-cart-btn" style="background-color: #00adb5;" type="submit" name="add_to_cart" value="<?= $produk['id'] ?>">Add to Cart</button>
                    </form>
            </div>
                <?php
            }
        } else {
            echo "<p>Tidak ada produk yang tersedia.</p>";
        }
        ?>
    </section>
</main>

<!-- PROFILE SIDEBAR -->
<div class="profile-sidebar" id="profileSidebarBeforeLogin">
    <button class="close-btn" onclick="closeProfile()">
        <i class="ph ph-x-circle" style="color:#000;"></i>
    </button>
    <div class="profile">
        <h2>
            <?php
            // Periksa apakah sudah login
            if (isset($_SESSION['log']) && $_SESSION['log'] === 'Logged') {
                echo 'Halo ' . $_SESSION['username'];
            } else {
                echo 'Login';
            }
            ?>
        </h2>
    </div>
</div>

<!-- TENTANG KAMI -->
<section class="about" id="about" style="background-color:#eeeeee;">
    <div class="about-content">
        <h2 style="color:#000;">Tentang Kami</h2>
        <div>
            <img src="../src/produk/web_banner.jpg" alt="" style="width: 100%; max-height: 100%; border-radius:10px;">
        </div>
        <p style="font-size: 10px; color:#000;">Secca Food adalah sebuah usaha makanan yang berkomitmen untuk menyajikan makanan berkualitas tinggi dengan rasa yang lezat. Kami percaya bahwa makanan adalah cara terbaik untuk menghubungkan orang dan menciptakan kenangan yang tak terlupakan. Dengan berbagai pilihan menu yang lezat, kami berharap dapat memuaskan selera Anda dan menjadi bagian dari momen spesial Anda.</p>
    </div>
</section>

<!-- FOOTER -->
<footer class="footer" style="background-color:#eeeeee;">
    <div class="footer-content">
        <p style="font-size: 10px; color:#000;">&copy; 2023 Seccadev. All rights reserved.</p>
    </div>
</footer>

<a
        href="#top"
        class="back-top-btn"
        aria-label="back to top"
        data-back-top-btn
>
    <ion-icon name="caret-up"></ion-icon>
</a>

<!-- feather-icons -->
<script>
    feather.replace();
</script>
<!-- ionicon link -->
<script
        type="module"
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"
></script>
<script
        nomodule
        src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"
></script>
<script>
    const header = document.querySelector("[data-header]");
    const backTopBtn = document.querySelector("[data-back-top-btn]");

    window.addEventListener("scroll", function () {
        if (window.scrollY >= 200) {
            header.classList.add("active");
            backTopBtn.classList.add("active");
        } else {
            header.classList.remove("active");
            backTopBtn.classList.remove("active");
        }
    });

    function searchProducts() {
    var searchTerm = document.getElementById('searchInput').value.toLowerCase();

    // Loop melalui produk dan sembunyikan yang tidak cocok
    var products = document.querySelectorAll('.product-card');
    products.forEach(function (product) {
        var productName = product.querySelector('h3').innerText.toLowerCase();
        if (productName.includes(searchTerm)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

    function updateCartCount() {
        var cartCount = <?php echo $cartCount; ?>;
        document.getElementById('cart-count').innerText = cartCount;
    }

    // Fungsi untuk menampilkan sidebar profile
    function toggleProfile() {
        const cartSidebar = document.getElementById('profileSidebarBeforeLogin');
        cartSidebar.classList.toggle('active');
    }

    // Fungsi untuk menampilkan/menutup sidebar profile
    function closeProfile() {
        const cartSidebar = document.getElementById('profileSidebarBeforeLogin');
        cartSidebar.classList.remove('active');
    }

    // Fungsi untuk menampilkan/menutup sidebar menu
    function toggleMenu() {
        const menuIcon = document.getElementById('menuIcon');
        const sidebar = document.querySelector('.sidebar');
        const isSidebarActive = sidebar.classList.contains('active');

        if (isSidebarActive) {
            // Mengganti ikon X menjadi ikon menu saat menutup sidebar
            menuIcon.setAttribute('data-feather', 'menu');
        } else {
            // Mengganti ikon menu menjadi ikon X saat membuka sidebar
            menuIcon.setAttribute('data-feather', 'x');
        }

        // Memanggil Feather Icons untuk memperbarui tampilan ikon
        feather.replace();

        // Memanggil fungsi toggleMenu() yang ada pada sidebar
        sidebar.classList.toggle('active');
    }

    function closeSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.remove('active');
    }

    document.getElementById('searchForm').addEventListener('submit', function (event) {
        searchProducts();
        event.preventDefault();
    });
</script>
</body>
</html>

<?php
include 'db.php';

// Default cart count
$cartCount = 0;

// If the user is logged in, get the cart count
if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    $countQuery = mysqli_query($conn, "
        SELECT SUM(quantity) AS total
        FROM cart
        WHERE user_id='$user_id'
    ");

    $countRow = mysqli_fetch_assoc($countQuery);

    $cartCount = ($countRow['total']) ? $countRow['total'] : 0;
}

// Get all products
$productQuery = mysqli_query($conn, "
    SELECT *
    FROM products
    ORDER BY id ASC
");
?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>PeakForm</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="style.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Poppins, sans-serif;
        }

        body {
            background-color: #000;
            color: #fff;
            overflow-x: hidden;
            font-family: 'Poppins', sans-serif;
        }

        /* ================= GLASS NAVBAR ================= */

        .navbar {

            position: fixed;

            top: 0;
            left: 0;

            width: 100%;

            padding: 20px 50px;

            background: rgba(0, 0, 0, .25);

            backdrop-filter: blur(20px);

            border-bottom: 1px solid rgba(255, 255, 255, .15);

            z-index: 9999;

        }

        .navbar-brand {

            color: #fff !important;

            font-size: 32px;

            font-weight: 700;

            letter-spacing: 1px;

        }

        .navbar-brand:hover {

            color: #fff;

        }

        .nav-link {

            color: #fff !important;

            font-size: 17px;

            margin-left: 20px;

            transition: .3s;

        }

        .nav-link:hover {

            color: #d9d9d9 !important;

        }

        .search-box {

            width: 260px;

            background: rgba(255, 255, 255, .12);

            border: 1px solid rgba(255, 255, 255, .2);

            border-radius: 30px;

            padding: 8px 18px;

            display: flex;

            align-items: center;

            backdrop-filter: blur(10px);

        }

        body {

            padding-top: 100px;

        }

        .search-box input {

            background: transparent;

            color: #fff;

            border: none;

            outline: none;

            margin-left: 10px;

            width: 100%;

        }

        .search-box input::placeholder {

            color: #ddd;

        }

        .search-box i {

            color: #fff;

        }

        #cartCount {

            font-size: 11px;

            min-width: 20px;

            height: 20px;

            display: flex;

            justify-content: center;

            align-items: center;

        }

        #toast {

            position: fixed;

            top: 25px;
            right: 25px;

            background: #198754;

            color: #fff;

            padding: 15px 22px;

            border-radius: 10px;

            font-weight: 600;

            opacity: 0;

            pointer-events: none;

            transition: .4s;

            z-index: 999999;

        }

        #toast.show {

            opacity: 1;

        }



        .hero {

            margin-top: -100px;

            position: relative;

            height: 100vh;

            overflow: hidden;

        }

        .hero video {

            width: 100%;
            height: 100%;

            object-fit: cover;

        }

        .hero-overlay {

            position: absolute;

            top: 0;
            left: 0;

            width: 100%;
            height: 100%;

            background: rgba(0, 0, 0, .45);

            display: flex;

            justify-content: center;

            align-items: center;

            text-align: center;

        }

        .hero-overlay h1 {

            font-size: 75px;

            font-weight: 800;

            color: #fff;

        }

        .hero-overlay p {

            font-size: 20px;

            color: #fff;

            margin-top: 15px;

        }

        .hero-overlay .btn {

            margin-top: 25px;

            padding: 15px 45px;

            font-size: 18px;

            border-radius: 40px;

        }

        .collection {
            background-color: #000;
            color: #fff;
        }

        .collection-images {

            position: relative;
            height: 500px;

        }

        .img-back {

            position: absolute;

            top: 0;
            right: 40px;

            width: 340px;
            height: 320px;

            object-fit: cover;

            border-radius: 20px;

        }

        .img-front {

            position: absolute;

            bottom: 0;
            left: 20px;

            width: 300px;
            height: 340px;

            object-fit: cover;

            border-radius: 20px;

            box-shadow: 0 15px 35px rgba(0, 0, 0, .3);

        }

        .collection-title {

            font-size: 58px;
            font-weight: 800;
            line-height: 1.1;

            margin-bottom: 25px;

        }

        .collection-text {

            font-size: 18px;

            color: #555;

            margin-bottom: 30px;

        }

        .product-card {

            transition: .3s;

            border-radius: 15px;

            overflow: hidden;

        }

        .product-card:hover {

            transform: translateY(-8px);

            box-shadow: 0 20px 40px rgba(0, 0, 0, .15);

        }

        .product-image {

            height: 330px;

            object-fit: cover;

        }

        .product-card {

            border-radius: 18px;

            overflow: hidden;

            transition: .35s;

        }

        .product-card:hover {

            transform: translateY(-8px);

            box-shadow: 0 18px 40px rgba(0, 0, 0, .15);

        }

        .product-image {

            height: 330px;

            object-fit: cover;

        }

        .productName {

            min-height: 55px;

        }

        #catalog {

            padding-top: 90px;

        }

        .d-grid .btn {

            height: 50px;

            font-size: 16px;

            font-weight: 600;

            border-radius: 10px;

        }

        /* ===========================
   TOP PRODUCTS
=========================== */

        .top-products {

            background: #000;

            padding: 50px 0 70px;

        }

        .section-title {

            color: #fff;

            font-family: 'Oswald', sans-serif;

            font-size: 30px;

            font-weight: 700;

            margin: 0 0 30px 20px;

        }

        .top-products-grid {

            display: grid;

            grid-template-columns: repeat(3, 1fr);

            gap: 0;

            width: 100%;

        }

        .product-large,
        .product-small {

            position: relative;

            width: 100%;

            height: 620px;

            overflow: hidden;

            background: #f7f4f4;

        }

        .product-large img,
        .product-small img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            transition: .4s;

        }

        .product-large:hover img,
        .product-small:hover img {

            transform: scale(1.05);

        }

        .product-name {

            position: absolute;

            bottom: 25px;

            left: 0;

            width: 100%;

            text-align: center;

            color: #fff;

            font-family: 'Oswald', sans-serif;

            font-size: 24px;

            font-weight: 600;

            text-transform: uppercase;

            letter-spacing: 1px;

            text-shadow: 0 2px 8px rgba(249, 242, 242, 0.93);

        }

        .product-card {

            position: relative;

            height: 620px;

            overflow: hidden;

            background: #ffffff;

        }

        .product-card img {

            width: 100%;

            height: 100%;

            object-fit: cover;

            transition: .4s;

        }

        .product-card:hover img {

            transform: scale(1.05);

        }
    </style>

</head>

<body>

    <div id="toast">

        <i class="fa-solid fa-circle-check me-2"></i>

        Added to Cart!

    </div>

    <nav class="navbar navbar-expand-lg">

        <div class="container-fluid">

            <a class="navbar-brand" href="peakform.php">

                PeakForm

            </a>

            <button
                class="navbar-toggler bg-light"
                data-bs-toggle="collapse"
                data-bs-target="#menu">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div
                class="collapse navbar-collapse justify-content-end"
                id="menu">

                <div class="search-box me-4">

                    <i class="fa-solid fa-search text-dark"></i>

                    <input
                        type="text"
                        id="searchInput"
                        placeholder="Search Product">

                </div>

                <ul class="navbar-nav align-items-center">

                    <!-- CART -->

                    <li class="nav-item position-relative">

                        <a class="nav-link" href="cart.php">

                            <i class="fa-solid fa-cart-shopping fs-4"></i>

                            <span
                                id="cartCount"
                                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">

                                <?php echo $cartCount; ?>

                            </span>

                        </a>

                    </li>

                    <?php if (isset($_SESSION['user_id'])) { ?>

                        <!-- PROFILE -->

                        <li class="nav-item">

                            <a class="nav-link" href="profile.php">

                                <i class="fa-regular fa-user fs-5"></i>

                            </a>

                        </li>

                        <!-- LOGOUT -->

                        <li class="nav-item">

                            <a class="nav-link" href="logout.php">

                                <i class="fa-solid fa-right-from-bracket fs-5"></i>

                            </a>

                        </li>

                    <?php } else { ?>

                        <!-- LOGIN -->

                        <li class="nav-item ms-3">

                            <a href="login.php" class="btn btn-outline-light">

                                Login

                            </a>

                        </li>

                        <!-- REGISTER -->

                        <li class="nav-item ms-2">

                            <a href="register.php" class="btn btn-light">

                                Register

                            </a>

                        </li>

                    <?php } ?>

                </ul>

            </div>

        </div>

    </nav>

    <section class="hero">

        <video autoplay muted loop playsinline>

            <source src="hero.mp4" type="video/mp4">

        </video>

        <div class="hero-overlay">

            <div>

                <h1>

                    ONYX<br>
                </h1>

                <p>

                    50% OFF

                </p>



            </div>

        </div>

    </section>

    <!-- ================= COLLECTION ================= -->

    <section class="py-5 bg-black">

        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-6 mb-5 mb-lg-0">

                    <div class="collection-images">

                        <img src="carte2.jpg" class="img-back" alt="">

                        <img src="carte1.jpg" class="img-front" alt="">

                    </div>

                </div>

                <div class="col-lg-6">

                    <h1 class="collection-title">

                        THE GAIN<br>

                        COLLECTION<br>

                        RETURNED

                    </h1>

                    <p class="collection-text">

                        Designed for athletes who demand comfort, durability, and
                        performance. PeakForm apparel helps you stay focused on
                        every workout while looking your best inside and outside
                        the gym.

                    </p>

                    <a href="#catalog" class="btn btn-dark px-5 py-3">

                        SHOP NOW

                    </a>

                </div>

            </div>

        </div>

    </section>


    <!-- ================= TOP PRODUCTS ================= -->

    <section class="top-products">

        <h1 class="section-title">
            TOP PRODUCTS
        </h1>

        <div class="top-products-grid">

            <div class="product-card">

                <img src="top1.jpg" alt="">

                <div class="product-name">
                    GYMSHARK
                </div>

            </div>

            <div class="product-card">

                <img src="top2.jpg" alt="">

                <div class="product-name">
                    MYSTERIOUS SOUL
                </div>

            </div>

            <div class="product-card">

                <img src="top3.jpg" alt="">

                <div class="product-name">
                    YOUNGLA
                </div>

            </div>

        </div>

    </section>

    <!-- ================= SHOP CATALOG ================= -->

    <section class="py-5" id="catalog">

        <div class="container">

            <h1 class="text-center fw-bold mb-5">

                EXPLORE

            </h1>

            <div class="row justify-content-center g-4" id="productContainer">

                <?php while ($product = mysqli_fetch_assoc($productQuery)) { ?>

                    <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 productBox">

                        <div class="card product-card h-100 border-0 shadow">

                            <img
                                src="<?php echo $product['image']; ?>"
                                class="card-img-top product-image"
                                alt="">

                            <div class="card-body d-flex flex-column">

                                <h5 class="fw-bold productName">

                                    <?php echo $product['name']; ?>

                                </h5>

                                <p class="text-muted small">

                                    <?php echo $product['description']; ?>

                                </p>

                                <h4 class="fw-bold mb-3">

                                    ₱<?php echo number_format($product['price'], 2); ?>

                                </h4>

                                <div class="mt-auto">

                                    <div class="d-grid gap-2">

                                        <button
                                            type="button"
                                            class="btn btn-dark viewDetailsBtn"

                                            data-id="<?= $product['id']; ?>"
                                            data-name="<?= htmlspecialchars($product['name']); ?>"
                                            data-price="<?= $product['price']; ?>"
                                            data-stock="<?= $product['stock']; ?>"
                                            data-description="<?= htmlspecialchars($product['description']); ?>"
                                            data-image="<?= $product['image']; ?>">

                                            View Details

                                        </button>

                                        <form class="addCartForm w-100">

                                            <input
                                                type="hidden"
                                                name="product_id"
                                                value="<?= $product['id']; ?>">

                                            <button
                                                type="submit"
                                                class="btn btn-light w-100">

                                                <i class="fa-solid fa-cart-shopping me-2"></i>
                                                Add To Cart

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>

        </div>

    </section>

    <div class="modal fade" id="productModal">

        <div class="modal-dialog modal-xl modal-dialog-centered">

            <div class="modal-content bg-dark text-white">

                <div class="modal-body p-5">

                    <div class="row">

                        <div class="col-md-5">

                            <img
                                id="modalImage"
                                class="img-fluid rounded">

                        </div>

                        <div class="col-md-7">

                            <h2 id="modalName"></h2>

                            <h3 class="my-3">

                                ₱<span id="modalPrice"></span>

                            </h3>

                            <p id="modalDescription"></p>

                            <h5>

                                Stock:
                                <span id="modalStock"></span>

                            </h5>

                            <input
                                type="hidden"
                                id="modalProductId">

                            <input
                                type="hidden"
                                id="modalStockHidden">

                            <hr>

                            <!-- Quantity -->

                            <div class="d-flex align-items-center mt-4">

                                <button
                                    class="btn btn-outline-light"
                                    id="minusBtn">

                                    -

                                </button>

                                <input
                                    type="number"
                                    id="quantity"
                                    value="1"
                                    min="1"
                                    class="form-control text-center mx-3"
                                    style="width:90px;">

                                <button
                                    class="btn btn-outline-light"
                                    id="plusBtn">

                                    +

                                </button>

                            </div>

                            <div class="d-grid gap-3 mt-5">

                                <button
                                    class="btn btn-light"
                                    id="modalAddCart">

                                    Add To Cart

                                </button>

                                <button
                                    class="btn btn-warning"
                                    id="buyNow">

                                    Buy Now

                                </button>

                                <button
                                    class="btn btn-outline-light"
                                    data-bs-dismiss="modal">

                                    Back to Shopping

                                </button>

                                <hr>

                                <h5>Customer Reviews</h5>

                                <div id="reviewsContainer">

                                    No reviews yet.

                                </div>

                                <hr>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ================= FOOTER ================= -->

    <footer class="footer">

        <div class="container">

            <div class="row gy-5">

                <div class="col-lg-4">

                    <h2 class="footer-logo">

                        PeakForm

                    </h2>

                    <p class="footer-text">

                        PeakForm is built for athletes who never settle.
                        Premium gym apparel designed for strength,
                        comfort, and confidence.

                    </p>

                </div>

                <div class="col-lg-2">

                    <h5>

                        Shop

                    </h5>

                    <ul class="footer-links">

                        <li><a href="#catalog">Explore</a></li>

                        <li><a href="#">Top Products</a></li>

                        <li><a href="#">Collections</a></li>

                        <li><a href="cart.php">Cart</a></li>

                    </ul>

                </div>

                <div class="col-lg-2">

                    <h5>

                        Account

                    </h5>

                    <ul class="footer-links">

                        <li><a href="login.php">Login</a></li>

                        <li><a href="register.php">Register</a></li>

                        <li><a href="logout.php">Logout</a></li>

                    </ul>

                </div>

                <div class="col-lg-4">

                    <h5>

                        Follow Us

                    </h5>

                    <div class="social-icons">

                        <a href="#"><i class="fab fa-facebook-f"></i></a>

                        <a href="#"><i class="fab fa-instagram"></i></a>

                        <a href="#"><i class="fab fa-x-twitter"></i></a>

                        <a href="#"><i class="fab fa-youtube"></i></a>

                    </div>

                </div>

            </div>

            <hr>

            <div class="text-center copyright">

                © <?php echo date("Y"); ?> PeakForm.
                All Rights Reserved.

            </div>

        </div>

    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll(".addCartForm").forEach(form => {

            form.addEventListener("submit", function(e) {

                e.preventDefault();

                const data = new FormData(this);

                fetch("ajax_add_to_cart.php", {

                        method: "POST",

                        body: data

                    })

                    .then(response => response.json())

                    .then(data => {

                        if (data.success) {

                            document.getElementById("cartCount").innerHTML = data.count;

                            const toast = document.getElementById("toast");

                            toast.classList.add("show");

                            setTimeout(function() {

                                toast.classList.remove("show");

                            }, 1800);

                        } else {

                            alert("Please login or register first before adding products to your cart.");

                            window.location.href = "login.php";

                        }

                    });

            });

        });


        // SEARCH

        const search = document.getElementById("searchInput");

        search.addEventListener("keyup", function() {

            let filter = this.value.toUpperCase();

            let products = document.querySelectorAll(".productBox");

            products.forEach(function(product) {

                let name = product.querySelector(".productName").innerText;

                if (name.toUpperCase().indexOf(filter) > -1) {

                    product.style.display = "block";

                } else {

                    product.style.display = "none";

                }

            });

        });


        const modal = new bootstrap.Modal(
            document.getElementById("productModal")
        );

        let stock = 0;

        document.querySelectorAll(".viewDetailsBtn").forEach(button => {

            button.addEventListener("click", function() {

                document.getElementById("modalImage").src = this.dataset.image;

                document.getElementById("modalProductId").value = this.dataset.id;
                document.getElementById("modalStockHidden").value = this.dataset.stock;

                document.getElementById("modalName").innerHTML = this.dataset.name;

                document.getElementById("modalPrice").innerHTML = this.dataset.price;

                document.getElementById("modalDescription").innerHTML = this.dataset.description;

                document.getElementById("modalStock").innerHTML = this.dataset.stock;

                document.getElementById("quantity").value = 1;

                stock = parseInt(this.dataset.stock);

                fetch("load_reviews.php?product=" + this.dataset.id)

                    .then(response => response.text())

                    .then(data => {

                        document.getElementById("reviewsContainer").innerHTML = data;

                    });

                modal.show();

            });

        });

        document.getElementById("plusBtn").onclick = function() {

            let qty = document.getElementById("quantity");

            if (parseInt(qty.value) < stock) {

                qty.value++;

            }

        }

        document.getElementById("minusBtn").onclick = function() {

            let qty = document.getElementById("quantity");

            if (parseInt(qty.value) > 1) {

                qty.value--;

            }

        }

        document.getElementById("modalAddCart").onclick = function() {

            const id = document.getElementById("modalProductId").value;

            const qty = document.getElementById("quantity").value;

            fetch("ajax_add_to_cart.php", {

                    method: "POST",

                    body: new URLSearchParams({

                        product_id: id,

                        quantity: qty

                    })

                })

                .then(res => res.json())

                .then(data => {

                    if (data.success) {

                        document.getElementById("cartCount").innerHTML = data.count;

                        alert("Added to cart!");

                        bootstrap.Modal.getInstance(
                            document.getElementById("productModal")
                        ).hide();

                    } else {

                        alert("Please login/register first.");

                        window.location = "login.php";

                    }

                });

        }

        document.getElementById("buyNow").onclick = function() {

            const form = document.createElement("form");

            form.method = "POST";

            form.action = "buy_now.php";

            const p = document.createElement("input");

            p.type = "hidden";

            p.name = "product_id";

            p.value = document.getElementById("modalProductId").value;

            form.appendChild(p);

            const q = document.createElement("input");

            q.type = "hidden";

            q.name = "quantity";

            q.value = document.getElementById("quantity").value;

            form.appendChild(q);

            document.body.appendChild(form);

            form.submit();

        }
    </script>



</body>

</html>
<?php session_start(); ?>
<?php include 'koneksi.php';
// mendapatkan id_produk dari url
$id_produk = $_GET["id"];

// query ambil data
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
$detail = $ambil->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
	<title>detail produk</title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">

</head>
<body>

<!-- navbar -->
	<nav class="navbar navbar-default">
		<div class="container">
		
		<ul class="nav navbar-nav">
			<li><a href="index.php">Home</a></li>
			<li><a href="keranjang.php">Keranjang</a></li>
			<!--jika sudah login(ada session pelanggan) -->
			<?php if (isset($_SESSION["pelanggan"])): ?>
				<li><a href="logout.php">Logout</a></li>
			<!-- selain itu(blm ada session pelanggan) -->
			<?php else: ?>
			<li><a href="login.php">Login</a></li>
			<?php endif ?>
			<li><a href="checkout.php">Checkout</a></li>
		</ul>
	</div>
	</nav>

<section class="kontent">
		<div class="container">
			<div class="row">
				<div class="col-md-6">
					<img src="foto_produk/<?php echo $detail["foto_produk"]; ?>" alt="" class="img-responsive">
				</div>
				<div class="col-md-6">
					<h2><?php echo $detail["nama_produk"] ?></h2>
					<h4>Rp. <?php echo number_format($detail["harga produk"]); ?></h4>

					<h5>Stok: <?php echo $detail['stok_produk'] ?></h5>

					<form method="post">
						<div class="form-group">
							<div class="input-group">
								<input type="number" min="1" class="form-control" name="jumlah" max="<?php echo $detail['stok_produk'] ?>">
								<div class="input-group-btn">
									<button class="btn btn-primary" name="beli">Beli</button>
								</div>
							</div>
						</div>
					</form>

					<?php
					// jika ada tombol beli
					if (isset($_POST["beli"]))
					{
						// mendapatkan jumlah yang diinputkan
						$jumlah = $_POST["jumlah"];
						// masukkan di keranjang belanja
						$_SESSION["keranjang"][id_produk] = $jumlah;

						echo "<script>alert('produk telah masuk ke keranjang belanja');</script>";
						echo "<script>location='keranjang.php';</script>";
					}
					?>

					<p><?php echo $detail["deskripsi_produk"]; ?></p>
				</div>
			</div>
		</div>
	</section>

</body>
</html>
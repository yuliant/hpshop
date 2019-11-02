<?php
session_start();
//koneksi ke database
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>hpshop</title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>
<!-- navbar -->
<?php include 'menu.php'; ?>

	<!-- konten -->
	<section class="konten">
		<div class="container">
			<h1>Produk Terbaru</h1>
			<div class="row">
				
				<?php $ambil = $koneksi->query("SELECT * FROM produk"); ?>
				<?php while($perproduk = $ambil->fetch_assoc()){ ?>	
				<div class="col-md-3">
					<div class="thumbnail">
						<img src="foto_produk/<?php echo $perproduk['foto_produk']; ?>" alt="">
						<div class="caption">
							<h3><?php echo $perproduk['nama_produk']; ?></h3>
							<h5>Rp.  <?php echo number_format($perproduk['harga_produk']); ?></h5>
							<a href="beli.php?id=<?php echo $perproduk['id_produk']; ?>" class="btn btn-primary">Beli</a>
							<a href="detail.php?id=<?php echo $perproduk["id_produk"]; ?>" class="btn btn-default">Detail</a>
					</div>
				</div>
			</div>
		<?php } ?>

		</div>
	</section>

</body>
</html>
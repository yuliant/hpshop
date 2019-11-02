<?php
session_start();


//echo "<pre>";
//print_r($_SESSION['keranjang']);
//echo "</pre>";

include 'koneksi.php';

if(empty($_SESSION["keranjang"]) OR !isset($_SESSION["keranjang"]))
{
	echo "<script>alert('keranjang kosong, silahkan belanja dulu');</script>";
	echo "<script>location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>keranjang belanja</title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

		<!-- navbar -->
<?php include 'menu.php'; ?>

	<section class="konten">
		<div class="container">
			<h1>Keranjang Belaja</h1>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Produk</th>
						<th>Harga</th>
						<th>Jumlah</th>
						<th>Subharga</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php $nomor=1; ?>
					<?php foreach ($_SESSION["keranjang"] as $id_produk => $jumlah): ?>
						<!--menampilkan produk yang sedang diperulakan berdasarkan id_produk-->
						<?php
						$ambil = $koneksi->query("SELECT * FROM produk
							WHERE id_produk='$id_produk'");
						$pecah = $ambil->fetch_assoc();
						$subharga = $pecah["harga_produk"]*$jumlah;
					
						?>
					<tr>
						<td><?php echo $nomor; ?></td>
						<td><?php echo $pecah["nama_produk"]; ?></td>
						<td>Rp. <?php echo number_format($pecah["harga_produk"]); ?></td>
						<td><?php echo $jumlah; ?></td>
						<td>Rp. <?php echo number_format($subharga); ?></td>
						<td>
							<a href="hapuskeranjang.php?id=<?php echo $id_produk ?>" class="btn btn-danger btn-xs">hapus</a>
						</td>
					</tr>
					<?php $nomor++; ?>
					<?php endforeach ?>
				</tbody>
			</table>

			<a href="index.php" class="btn btn-default">Lanjutkan Belanja</a>
			<a href="checkout.php" class="btn btn-primary">Checkout</a>
		</div>
	</section>

</body>
</html>
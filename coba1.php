<?php
session_start();
$koneksi = new mysqli("localhost","root","","hpshop");

// jika tidak ada session pelanggan(blb login)maka dilarikan ke login.php
if (!isset($_SESSION["pelanggan"]))
{
	echo "<script>alert('silahkan login');</script>";
	echo "<script>location='login.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>checkout</title>
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

	<section class="konten">
		<div class="container">
			<h1>Keranjang Belanja</h1>
			<hr>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>No</th>
						<th>Produk</th>
						<th>Harga</th>
						<th>Jumlah</th>
						<th>Subharga</th>
					</tr>
				</thead>
				<tbody>
					<?php $nomor=1; ?>
					<?php $totalbelanja = 0; ?>
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
					</tr>
					<?php $nomor++; ?>
					<?php $totalbelanja+=$subharga; ?>
					<?php endforeach ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="4">Total Belanja</th>
						<th>Rp. <?php echo number_format($totalbelanja) ?></th>
					</tr>
				</tfoot>
			</table>


			<form method="post">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
					<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['nama_pelanggan'] ?>" class="form-control">
				</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
					<input type="text" readonly value="<?php echo $_SESSION["pelanggan"]['telepon_pelanggan'] ?>" class="form-control">
				</div>
					</div>
					<div class="col-md-4">
						<select class="form-control" name="id_ongkir">
							<option value="">Pilih Ongkos Kirim</option>
							<?php
							$ambil = $koneksi->query("SELECT * FROM ongkir");
							while ($perongkir = $ambil-> fetch_assoc()){
							?>
							<option value="<?php echo $perongkir["id_ongkir"] ?>">
								<?php echo $perongkir['nama_kota'] ?> -
								Rp. <?php echo number_format($perongkir['tarif']) ?>
							</option>
							<?php } ?>						
						</select>
					</div>
				</div>
				<button class="btn btn-primary" name="checkout">Checkout</button>
			</form>

			<?php
			if (isset($_POST["checkout"]))
			{
				$id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
				$id_ongkir = $_POST["id_ongkir"];
				$tanggal_pembelian = date("Y-m-d");

				$ambil = $koneksi->query("SELECT * FROM ongkir WHERE id_ongkir='$id_ongkir'");
				$arrayongkir = $ambil->fetch_assoc();
				$nama_kota = $arrayongkir['nama_kota'];
				$tarif  = $arrayongkir['tarif'];

				$total_pembelian = $totalbelanja + $tarif;

				// 1. menyimpan data ke tabel pembelian
				$koneksi->query("INSERT INTO pembelian (id_pelanggan,id_ongkir,tanggal_pembelian,total_pembelian,nama_kota,tarif) VALUES ('$id_pelanggan','$id_ongkir','$tanggal_pembelian','$total_pembelian','$nama_kota','$tarif') ");

				// mendapatkan id_pembelian barusan terjadi
				$id_pembelian_barusan = $koneksi->insert_id;

				foreach ($_SESSION["keranjang"] as $id_produk => $jumlah) 
				{
					//mendapatkan data produk berdasarkan id_produk
					$ambil=$koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
					$perproduk = $ambil->fetch_assoc();

					$nama = $perproduk['nama_produk'];
					$harga = $perproduk['harga_produk'];
					$berat = $perproduk['berat_produk'];

					$subberat = $perproduk['berat_produk']*$jumlah;
					$subharga = $perproduk['harga_produk']*$jumlah;
					$koneksi->query("INSERT INTO pembelian_produk (id_pembelian,id_produk,nama,harga,berat,subberat,subharga,jumlah)
					VALUES ('$id_pembelian_barusan','$id_produk','$nama','$harga','$berat','$subberat','$subharga','$jumlah') ");
				}

				// mengkosongkan keranjang belanja

				unset($_SESSION["keranjang"]);

				// tampilan diahlikan ke halaman nota, nota dari pembelian yang barusan
				echo "<script>alert('pembelian sukses');</script>";
				echo "<script>location='nota.php?id=$id_pembelian_barusan';</script>";

			}

			?>

		</div>
	</section>

</body>
</html>
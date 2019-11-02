<?php 
session_start();
include 'koneksi.php'; ?>


<!DOCTYPE html>
<html>
<head>
	<title>nota pembelian</title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

	<!-- navbar -->
	<?php include 'menu.php' ?>

<section class="konten">
	<div class="container">


		<! --nota disini copas dari nota yang ada do admin -->
		<h2>Detail Pembelian</h2>
<?php 
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan 
	ON pembelian.id_pelanggan=pelanggan.id_pelanggan 
	WHERE pembelian.id_pembelian='$_GET[id]'");
$detail = $ambil->fetch_assoc();
 ?>
 
<!-- <pre><?php //print_r($detail); ?></pre> -->

<!-- jika pelanggan yang beli tidak sama dengan yang login, maka dia dilarikan ke riwayat.php 
karena tidak berhah melihat nota orang lain-->
<!-- pelanggan yang beli harus pelanggan yang login -->
<?php 
//mendapatkan id_pelanggan yang beli
$idpelangganyangbeli = $detail["id_pelanggan"];

//mendapatkan id_pelanggan yang login
$idpelangganyanglogin = $_SESSION["pelanggan"]["id_pelanggan"];

if ($idpelangganyangbeli!==$idpelangganyanglogin) 
{
	echo "<script>alert('Maaf apa yang anda lakukan Ilegal');</script>";
	echo "<script>location='riwayat.php';</script>";
	exit();
}
 ?>

<div class="row">
	<div class="col-md-4">
		<h3>Pembelian</h3>
		<strong>No. Pembelian: <?php echo $detail['id_pembelian'] ?></strong><br>
		Tanggal: <?php echo $detail['tanggal_pembelian']; ?><br>
		Total: <?php echo number_format($detail['total_pembelian']) ?>
	</div>
	<div class="col-md-4">
		<h3>Pelanggan</h3>
		<strong><?php echo $detail['nama_pelanggan']; ?></strong> <br>
		<p>
			<?php echo $detail['telepon_pelanggan']; ?> <br>
			<?php echo $detail['email_pelanggan']; ?>
		</p>
	</div>
	<div class="col-md-4">
		<h3>Pengiriman</h3>
		<strong><?php echo $detail['nama_kota'] ?></strong><br>
		Ongkos Kirim: Rp. <?php echo number_format($detail['tarif']); ?><br>
		Alamat: <?php echo $detail['alamat_pengiriman'] ?>
	</div>
</div>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>no</th>
			<th>nama produk</th>
			<th>harga</th>
			<th>jumlah</th>
			<th>subtotal</th>
		</tr>
	</thead>
	<tbody>
		<?php $nomor=1; ?>
		<?php $ambil=$koneksi->query("SELECT * FROM pembelian_produk JOIN produk ON pembelian_produk.id_produk=produk.id_produk WHERE pembelian_produk.id_pembelian='$_GET[id]'"); ?>
		<?php while($pecah=$ambil->fetch_assoc()){ ?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama_produk']; ?></td>
			<td><?php echo $pecah['harga_produk']; ?></td>
			<td><?php echo $pecah['jumlah']; ?></td>
			<td>
				<?php echo $pecah['harga_produk']*$pecah['jumlah']; ?>
			</td>
		</tr>
		<?php $nomor++; ?>
		<?php } ?>
	</tbody>
</table>	


<div class="row">
	<div class="col-md-7">
		<div class="alert alert-info">
			<p>
				Silahkan melakukan pembayaran Rp. <?php echo number_format($detail['total_pembelian']); ?> ke <br>
				<strong>BANK MANDIRI 137-001088-3276 AN. HPShop</strong>

			</p>
		</div>
	</div>
</div>

	</div>
</section>

</body>
</html>
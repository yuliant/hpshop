<h2>Data Produk</h2>

<a href="index.php?halaman=tambahproduk" class="btn btn-primary">Tambah Produk</a>
<table class="table table-bordered">
	<head>
		<tr>
			<th>no</th>
			<th>nama</th>
			<th>harga</th>
			<th>berat</th>
			<th>foto</th>
			<th>aksi</th>
		</tr>
	</head>
	<tbody>
		<?php $nomor=1; ?>
		<?php $ambil=$koneksi->query("SELECT * FROM produk"); ?>
		<?php while($pecah = $ambil->fetch_assoc()){ ?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama_produk']; ?></td>
			<td><?php echo $pecah['harga_produk']; ?></td>
			<td><?php echo $pecah['berat_produk']; ?></td>
			<td>
				<img src="../foto_produk/<?php echo $pecah['foto_produk']; ?>"" width=100">
			</td>
			<td>
				<a href="index.php?halaman=ubahproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn btn-warning">Ubah</a>
				<a href="index.php?halaman=hapusproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn-danger btn">Hapus</a>
			</td>
		</tr>
		<?php $nomor++; ?>
	<?php } ?>
	</tbody>
</table>

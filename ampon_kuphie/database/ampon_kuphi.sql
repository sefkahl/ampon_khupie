CREATE TABLE IF NOT EXISTS tbl_satuan (
  id_satuan INT AUTO_INCREMENT PRIMARY KEY,
  nama_satuan VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tbl_supplier (
  id_supplier INT AUTO_INCREMENT PRIMARY KEY,
  kode_supplier VARCHAR(20) NOT NULL UNIQUE,
  nama_supplier VARCHAR(100) NOT NULL,
  alamat TEXT NULL,
  nomor_hp VARCHAR(20) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tbl_barang (
  id_barang INT AUTO_INCREMENT PRIMARY KEY,
  kode_barang VARCHAR(20) NOT NULL UNIQUE,
  nama_barang VARCHAR(100) NOT NULL,
  id_satuan INT NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  harga_average DECIMAL(15,2) NOT NULL DEFAULT 0,
  keterangan TEXT NULL,
  FOREIGN KEY (id_satuan) REFERENCES tbl_satuan(id_satuan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tbl_barang_masuk (
  id_barang_masuk INT AUTO_INCREMENT PRIMARY KEY,
  id_barang INT NOT NULL,
  id_supplier INT NOT NULL,
  jumlah INT NOT NULL,
  harga_beli DECIMAL(15,2) NOT NULL,
  tanggal DATE NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_barang) REFERENCES tbl_barang(id_barang),
  FOREIGN KEY (id_supplier) REFERENCES tbl_supplier(id_supplier)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS tbl_barang_keluar (
  id_barang_keluar INT AUTO_INCREMENT PRIMARY KEY,
  id_barang INT NOT NULL,
  jumlah INT NOT NULL,
  harga_pokok DECIMAL(15,2) NOT NULL DEFAULT 0,
  tanggal DATE NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_barang) REFERENCES tbl_barang(id_barang)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO tbl_satuan (nama_satuan) VALUES ('Pcs'), ('Dus'), ('Liter'), ('Kg');
INSERT IGNORE INTO tbl_supplier (kode_supplier, nama_supplier, alamat, nomor_hp) VALUES
('SUP-001', 'PT Kopi Nusantara', 'Jl. Merdeka No. 10, Bandung', '081234567890'),
('SUP-002', 'CV Susu Segar', 'Jl. Sudirman No. 5, Jakarta', '081298765432');
INSERT IGNORE INTO tbl_barang (kode_barang, nama_barang, id_satuan, stok, harga_average, keterangan) VALUES
('BRG-001', 'Kopi Arabika 250gr', 4, 0, 0, NULL),
('BRG-002', 'Susu UHT 1L', 3, 0, 0, NULL);

CREATE TABLE IF NOT EXISTS tbl_kartu_persediaan (
  id_kartu_persediaan INT AUTO_INCREMENT PRIMARY KEY,
  id_barang INT NOT NULL,
  id_barang_masuk INT NULL,
  id_barang_keluar INT NULL,
  tanggal DATE NOT NULL,
  jenis VARCHAR(10) NOT NULL,
  jumlah INT NOT NULL,
  harga DECIMAL(15,2) NOT NULL,
  total DECIMAL(15,2) NOT NULL,
  saldo_stok INT NOT NULL,
  saldo_nilai DECIMAL(15,2) NOT NULL,
  harga_average DECIMAL(15,2) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_barang) REFERENCES tbl_barang(id_barang),
  FOREIGN KEY (id_barang_masuk) REFERENCES tbl_barang_masuk(id_barang_masuk),
  FOREIGN KEY (id_barang_keluar) REFERENCES tbl_barang_keluar(id_barang_keluar)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

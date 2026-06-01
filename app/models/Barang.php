<?php
class Barang {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM barang ORDER BY kode_barang ASC");
        return $stmt->fetchAll();
    }

    public function getById($kode_barang) {
        $stmt = $this->pdo->prepare("SELECT * FROM barang WHERE kode_barang = ?");
        $stmt->execute([$kode_barang]);
        return $stmt->fetch();
    }

    public function insert($data) {
        $query = "INSERT INTO barang (kode_barang, nama_barang, jumlah, harga, satuan, lokasi, gambar, tanggal_masuk)
                  VALUES (:kode, :nama, :jumlah, :harga, :satuan, :lokasi, :gambar, :tanggal)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([
            ':kode'    => $data['kode_barang'],
            ':nama'    => $data['nama_barang'],
            ':jumlah'  => $data['jumlah'],
            ':harga'   => $data['harga'],
            ':satuan'  => $data['satuan'],
            ':lokasi'  => $data['lokasi'],
            ':gambar'  => $data['gambar'],
            ':tanggal' => $data['tanggal_masuk'],
        ]);
    }

    public function update($kode_barang, $data) {
        // Build SET clause dynamically based on data keys
        $fields = [];
        foreach ($data as $key => $val) {
            $fields[] = "$key = :$key";
        }
        $setClause = implode(', ', $fields);
        
        $query = "UPDATE barang SET $setClause WHERE kode_barang = :old_kode";
        $stmt = $this->pdo->prepare($query);
        
        $data['old_kode'] = $kode_barang;
        return $stmt->execute($data);
    }

    public function delete($kode_barang) {
        $stmt = $this->pdo->prepare("DELETE FROM barang WHERE kode_barang = ?");
        return $stmt->execute([$kode_barang]);
    }
}

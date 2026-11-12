
<?php

class Office {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Menampilkan data office
    public function getAll() {
        $sql = "SELECT * FROM offices ORDER BY id ASC";
        return mysqli_query($this->conn, $sql);
    }

    // Menambahkan office
    public function create($name, $address, $city, $phone) {
        $sql = "INSERT INTO offices
                (name, address, city, phone)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            "ssss",
            $name,
            $address,
            $city,
            $phone
        );

        return $stmt->execute();
    }

    // Menghapus office
    public function delete($id) {
        $sql = "DELETE FROM offices WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>

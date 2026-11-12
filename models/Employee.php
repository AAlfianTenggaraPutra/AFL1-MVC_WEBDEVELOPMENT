
<?php

class Employee {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Menampilkan data employee
    public function getAll() {
        $sql = "SELECT * FROM employees ORDER BY id ASC";
        return mysqli_query($this->conn, $sql);
    }

    // Menambahkan employee
    public function create($name, $position, $age) {
        $sql = "INSERT INTO employees
                (name, email, position, age)
                VALUES (?, '', ?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssi", $name, $position, $age);

        return $stmt->execute();
    }

    // Menghapus employee
    public function delete($id) {
        $sql = "DELETE FROM employees WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>

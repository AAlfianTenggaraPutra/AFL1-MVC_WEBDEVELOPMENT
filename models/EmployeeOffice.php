
<?php

class EmployeeOffice {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Menampilkan relasi employee dan office
    public function getAll() {
        $sql = "SELECT
                    eo.id,
                    e.name AS employee_name,
                    o.name AS office_name
                FROM employee_offices eo
                JOIN employees e ON eo.employee_id = e.id
                JOIN offices o ON eo.office_id = o.id
                ORDER BY eo.id ASC";

        return mysqli_query($this->conn, $sql);
    }

    // Menghubungkan employee dengan office
    public function assign($employee_id, $office_id) {
        $sql = "INSERT IGNORE INTO employee_offices
                (employee_id, office_id)
                VALUES (?, ?)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $employee_id, $office_id);

        return $stmt->execute();
    }

    // Menghapus hubungan employee dan office
    public function delete($id) {
        $sql = "DELETE FROM employee_offices WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}

?>

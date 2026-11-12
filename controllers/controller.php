
<?php

// ==========================================
// 1. MENGHUBUNGKAN FILE MODEL DAN DATABASE
// ==========================================

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Employee.php';
require_once __DIR__ . '/../models/Office.php';
require_once __DIR__ . '/../models/EmployeeOffice.php';

$employeeModel = new Employee($conn);
$officeModel = new Office($conn);
$employeeOfficeModel = new EmployeeOffice($conn);


// ==========================================
// 2. MEMPROSES FORM
// ==========================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    // --------------------------------------
    // TAMBAH EMPLOYEE
    // --------------------------------------

    if ($action === 'create_employee') {

        $name = trim($_POST['name'] ?? '');
        $position = trim($_POST['position'] ?? '');
        $age = filter_var(
            $_POST['age'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (
            $name !== '' &&
            $position !== '' &&
            $age !== false &&
            $age >= 0
        ) {
            $employeeModel->create(
                $name,
                $position,
                $age
            );
        }
    }

    // --------------------------------------
    // HAPUS EMPLOYEE
    // --------------------------------------

    elseif ($action === 'delete_employee') {

        $id = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($id !== false && $id > 0) {
            $employeeModel->delete($id);
        }
    }

    // --------------------------------------
    // TAMBAH OFFICE
    // --------------------------------------

    elseif ($action === 'create_office') {

        $name = trim($_POST['name'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $phone = trim($_POST['phone'] ?? '');

        if (
            $name !== '' &&
            $address !== '' &&
            $city !== '' &&
            $phone !== ''
        ) {
            $officeModel->create(
                $name,
                $address,
                $city,
                $phone
            );
        }
    }

    // --------------------------------------
    // HAPUS OFFICE
    // --------------------------------------

    elseif ($action === 'delete_office') {

        $id = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($id !== false && $id > 0) {
            $officeModel->delete($id);
        }
    }

    // --------------------------------------
    // MENGHUBUNGKAN EMPLOYEE DENGAN OFFICE
    // --------------------------------------

    elseif ($action === 'assign_employee') {

        $employee_id = filter_var(
            $_POST['employee_id'] ?? null,
            FILTER_VALIDATE_INT
        );

        $office_id = filter_var(
            $_POST['office_id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if (
            $employee_id !== false &&
            $employee_id > 0 &&
            $office_id !== false &&
            $office_id > 0
        ) {
            $employeeOfficeModel->assign(
                $employee_id,
                $office_id
            );
        }
    }

    // --------------------------------------
    // MENGHAPUS RELASI EMPLOYEE DAN OFFICE
    // --------------------------------------

    elseif ($action === 'delete_assignment') {

        $id = filter_var(
            $_POST['id'] ?? null,
            FILTER_VALIDATE_INT
        );

        if ($id !== false && $id > 0) {
            $employeeOfficeModel->delete($id);
        }
    }

    // KEMBALI KE HALAMAN UTAMA
    header("Location: index.php");
    exit;
}


// ==========================================
// 3. MENGAMBIL SELURUH DATA
// ==========================================

// Data employee
$employees = $employeeModel->getAll();

// Data office
$offices = $officeModel->getAll();

// Data relasi employee dan office
$employeeOffices = $employeeOfficeModel->getAll();

?>

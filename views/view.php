
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Employee Management System</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f4f4;
    margin: 0;
    padding: 30px;
}

.container {
    max-width: 1000px;
    margin: auto;
    background: white;
    padding: 25px;
    border-radius: 8px;
}

nav {
    background: #bde5f7;
    padding: 15px;
    margin-bottom: 25px;
}

nav a {
    text-decoration: none;
    color: black;
    font-weight: bold;
    margin-right: 20px;
}

h2, h3 {
    text-align: center;
}

section {
    margin-bottom: 50px;
    scroll-margin-top: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 25px;
}

th, td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

th {
    background: #292929;
    color: white;
}

input {
    width: 100%;
    padding: 10px;
    margin: 7px 0 15px;
    box-sizing: border-box;
}

button {
    background: #2878e8;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 4px;
}

.delete {
    background: #dc3545;
}

.form-box {
    max-width: 600px;
    margin: auto;
}
</style>
</head>

<body>

<div class="container">

<nav>
    <a href="#employee">Employee</a> |
    <a href="#office">Office</a> |
    <a href="#office-employees">Office-Employees</a>
</nav>

<!-- EMPLOYEE -->
<section id="employee">

<h2>List Karyawan</h2>

<table>
<tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Jabatan</th>
    <th>Usia</th>
    <th>Delete</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($employees)) : ?>
<tr>
    <td><?= (int)$row['id'] ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['position']) ?></td>
    <td><?= (int)$row['age'] ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="action"
                   value="delete_employee">
            <input type="hidden" name="id"
                   value="<?= (int)$row['id'] ?>">
            <button class="delete">Delete</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</table>

<h3>Tambah Karyawan</h3>

<div class="form-box">
<form method="POST">
    <input type="hidden" name="action"
           value="create_employee">

    <label>Nama</label>
    <input type="text" name="name" required>

    <label>Jabatan</label>
    <input type="text" name="position" required>

    <label>Usia</label>
    <input type="number" name="age" min="0" required>

    <button type="submit">Submit</button>
</form>
</div>

</section>

<hr>

<!-- OFFICE -->
<section id="office">

<h2>List Office</h2>

<table>
<tr>
    <th>ID</th>
    <th>Nama Office</th>
    <th>Address</th>
    <th>City</th>
    <th>Phone</th>
    <th>Delete</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($offices)) : ?>
<tr>
    <td><?= (int)$row['id'] ?></td>
    <td><?= htmlspecialchars($row['name']) ?></td>
    <td><?= htmlspecialchars($row['address']) ?></td>
    <td><?= htmlspecialchars($row['city']) ?></td>
    <td><?= htmlspecialchars($row['phone']) ?></td>
    <td>
        <form method="POST">
            <input type="hidden" name="action"
                   value="delete_office">
            <input type="hidden" name="id"
                   value="<?= (int)$row['id'] ?>">
            <button class="delete">Delete</button>
        </form>
    </td>
</tr>
<?php endwhile; ?>
</table>

<h3>Tambah Office</h3>

<div class="form-box">
<form method="POST">
    <input type="hidden" name="action"
           value="create_office">

    <label>Nama Office</label>
    <input type="text" name="name" required>

    <label>Address</label>
    <input type="text" name="address" required>

    <label>City</label>
    <input type="text" name="city" required>

    <label>Phone</label>
    <input type="text" name="phone" required>

    <button type="submit">Submit</button>
</form>
</div>

</section>

<hr>


<!-- OFFICE EMPLOYEES -->
<section id="office-employees">

<h2>Office Employees</h2>

<h3>Hubungkan Employee dengan Office</h3>

<div class="form-box">

<form method="POST">

    <input type="hidden" name="action"
           value="assign_employee">

    <label>Pilih Employee</label>

    <select name="employee_id" required
            style="width:100%;padding:10px;margin:10px 0 15px;">

        <option value="">-- Pilih Employee --</option>

        <?php
        $employeeOptions = $employeeModel->getAll();

        while ($employee = mysqli_fetch_assoc($employeeOptions)):
        ?>
            <option value="<?= (int)$employee['id'] ?>">
                <?= htmlspecialchars($employee['name']) ?>
            </option>
        <?php endwhile; ?>

    </select>

    <label>Pilih Office</label>

    <select name="office_id" required
            style="width:100%;padding:10px;margin:10px 0 15px;">

        <option value="">-- Pilih Office --</option>

        <?php
        $officeOptions = $officeModel->getAll();

        while ($office = mysqli_fetch_assoc($officeOptions)):
        ?>
            <option value="<?= (int)$office['id'] ?>">
                <?= htmlspecialchars($office['name']) ?>
            </option>
        <?php endwhile; ?>

    </select>

    <button type="submit">Assign Employee</button>

</form>

</div>

<h3>Daftar Employee dan Office</h3>

<table>

<tr>
    <th>ID</th>
    <th>Employee</th>
    <th>Office</th>
    <th>Delete</th>
</tr>

<?php while ($row = mysqli_fetch_assoc($employeeOffices)): ?>

<tr>
    <td><?= (int)$row['id'] ?></td>

    <td><?= htmlspecialchars($row['employee_name']) ?></td>

    <td><?= htmlspecialchars($row['office_name']) ?></td>

    <td>
        <form method="POST">

            <input type="hidden"
                   name="action"
                   value="delete_assignment">

            <input type="hidden"
                   name="id"
                   value="<?= (int)$row['id'] ?>">

            <button type="submit" class="delete">
                Delete
            </button>

        </form>
    </td>
</tr>

<?php endwhile; ?>

</table>

</section>


</div>

</body>
</html>

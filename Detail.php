<?php 
include 'db_connection.php'; // เชื่อมต่อฐานข้อมูล


$sql = "
    SELECT s.STID, s.Title, s.FName, s.LName, s.Address, h.HobbyNameEN
    FROM Students s
    JOIN Hobbies h ON s.HobbyID = h.HobbyID
    ORDER BY s.STID ASC
";


$students = $mysql->query($sql)->fetchAll(); 
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: "Kanit", sans-serif !important;
        }
    </style>
</head>

<body>
    <!-- nav -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand text-dark" href="#">Karnnapat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active text-dark" aria-current="page" href="Master.php">Masters</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="Detail.php">Details</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- table -->
    <div>
        <div class="p-5 h-100" style="background: linear-gradient(135deg, rgb(172, 106, 230), rgb(159, 59, 241), rgb(118, 25, 232));">
            <div class="container p-2 shadow h-100" style="position: relative; border-radius: 20px; background-color:white;">
                <h3 class="py-2" style="width:100%;text-align: center;border-bottom: 2px #dadada solid;">รายชื่อนักศึกษา</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-white">
                            <!-- Create Colum -->
                            <tr>
                                <th class="col-1 text-uppercase fw-semibold text-xs">STID</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">คำนำหน้า</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">ชื่อ</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">นามสกุล</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">ที่อยู่</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">งานอดิเรก</th>
                            </tr>
                        </thead>
                        <!-- SQL TABLE FORM DATABASE -->
                        <tbody class="text-body">
                            <?php
                            if ($students) {
                                foreach ($students as $index => $student) {
                                    $rowClass = ($index % 2 == 0) ? 'table-light' : '';
                                    echo "<tr class='$rowClass'>";
                                    echo "<td class='col-1 p-2'>{$student['STID']}</td>";
                                    echo "<td class='col-1 p-2'>{$student['Title']}</td>";
                                    echo "<td class='col-1 p-2'>{$student['FName']}</td>";
                                    echo "<td class='col-1 p-2'>{$student['LName']}</td>";
                                    echo "<td class='col-1 p-2'>{$student['Address']}</td>";
                                    echo "<td class='col-1 p-2'>{$student['HobbyNameEN']}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>ไม่พบข้อมูล</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    </div>

</body>

</html>
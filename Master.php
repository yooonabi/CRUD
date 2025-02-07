<?php
include 'db_connection.php'; // เชื่อมต่อฐานข้อมูล

// เรียกใช้ฟังก์ชันเพื่อเชื่อมต่อฐานข้อมูล
// เตรียมคำสั่ง SQL
$sql = "
SELECT s.STID, s.Title, s.FName, s.LName, s.Address, p.ProvinceName, c.CourseNameEN, h.HobbyNameEN
FROM Students s
JOIN Provinces p ON s.ProvinceID = p.ProvinceID
JOIN Courses c ON s.CourseID = c.CourseID
JOIN Hobbies h ON s.HobbyID = h.HobbyID
ORDER BY s.STID ASC
";

// ดึงผลลัพธ์ทั้งหมด
$students = $mysql->query($sql)->fetchAll();
$provinces = $mysql->query("SELECT * FROM Provinces")->fetchAll();
$courses = $mysql->query("SELECT * FROM Courses")->fetchAll();
$hobbys = $mysql->query("SELECT * FROM Hobbies")->fetchAll();

if (isset($_GET["getStudent"])) {
    $id = $_GET["getStudent"];
    exit(json_encode(["data" => $mysql->query("SELECT * FROM Students WHERE STID=?", [$id])->fetch()]));
} else if ($_GET["delete"]) {
    $id = $_GET['delete'];

    $res = $mysql->query("DELETE FROM Students where STID=?", [$id]);

    if ($res) {
        echo "ลบข้อมูลสำเร็จ!";
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล!";
    }
}

if (isset($_POST["do"])) {
    switch ($_POST["do"]) {
        case 'add':
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $title = $_POST['title'];
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $address = $_POST['address'];
                $province = $_POST['province'];
                $course = $_POST['course'];
                $hobby = $_POST['hobby'];

                $res = $mysql->query("INSERT INTO Students (Title, FName, LName, `Address`, ProvinceID, CourseID, HobbyID)
                 VALUES (?,?,?,?,?,?,?)", [$title, $fname, $lname, $address, $province, $course, $hobby]);

                if ($res) {
                    echo "เพิ่มข้อมูลสำเร็จ!";
                    header("Location: " . $_SERVER['PHP_SELF']);
                } else {
                    echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล!";
                }
            }
            break;
        case 'edit':
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $id = $_POST['id'];
                $title = $_POST['title'];
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $address = $_POST['address'];
                $province = $_POST['province'];
                $course = $_POST['course'];
                $hobby = $_POST['hobby'];

                $res = $mysql->query("UPDATE Students SET Title=?, FName=?, LName=?, `Address`=?, ProvinceID=?, CourseID=?, HobbyID=? WHERE STID=?", [$title, $fname, $lname, $address, $province, $course, $hobby, $id]);

                if ($res) {
                    echo "เพิ่มข้อมูลสำเร็จ!";
                    header("Location: " . $_SERVER['PHP_SELF']);
                } else {
                    echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล!";
                }
            }
            break;
        default:
            echo "ERROR";
            break;
    }
}
?>




<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <title>Master</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: "Kanit", sans-serif !important;
        }
    </style>
</head>

<body>
    <!-- Nav -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand text-dark" href="#">Karnnapat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
            <button id="Btn-add" type="button" class="btn btn-primary"> Add student </button>
        </div>
    </nav>

    <!-- table -->
    <div>
        <div class="p-5 h-100"
            style="background: linear-gradient(135deg, rgb(172, 106, 230), rgb(159, 59, 241), rgb(118, 25, 232));">
            <div class="container p-2 shadow h-100" style="position: relative; border-radius: 20px; background-color:white;">
                <h3 class="py-2" style="width:100%;text-align: center;border-bottom: 2px #dadada solid;">รายชื่อนักศึกษา</h3>
                <div class="table-responsive ">
                    <table class="table table-bordered table-striped table-hover align-middle text-center">
                        <thead class="table-white overflow-auto">
                            <!-- Create Colum -->
                            <tr>
                                <th class="col-1 text-uppercase fw-semibold text-xs">STID</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">คำนำหน้า</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">ชื่อ</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">นามสกุล</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">ที่อยู่</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">จังหวัด</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">หลักสูตร</th>
                                <th class="col-1 text-uppercase fw-semibold text-xs">Action</th>
                            </tr>
                        </thead>
                        <!-- SQL TABLE FORM DATABASE -->
                        <tbody>
                            <?php
                            if ($students) {
                                foreach ($students as $index => $student) {
                                    $rowClass = ($index % 2 == 0) ? 'table-light' : '';
                                    echo "<tr class='$rowClass'>";
                                    echo "<td class='col p-2'>{$student['STID']}</td>";
                                    echo "<td class='col p-2'>{$student['Title']}</td>";
                                    echo "<td class='col p-2'>{$student['FName']}</td>";
                                    echo "<td class='col p-2'>{$student['LName']}</td>";
                                    echo "<td class='col p-2'>{$student['Address']}</td>";
                                    echo "<td class='col p-2'>{$student['ProvinceName']}</td>";
                                    echo "<td class='col p-2'>{$student['CourseNameEN']}</td>";
                            ?>
                                    <td class='col p-2'>
                                        <div class="gap-3 d-flex">
                                            <button type="button" class="btn btn-danger bt-Edit" data-id="<?= $student['STID'] ?>">Edit</button>
                                            <button type=" button" class="btn btn-success bt-Delete" data-id="<?= $student['STID'] ?>">Delete</button>
                                        </div>
                                    </td>
                            <?php
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

    <div>
        <div class="modal fade" id="form" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">ฟอร์มเพิ่มข้อมูล</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <input type="hidden" name="do" value="add">
                            <input type="hidden" name="id" value="">

                            <label for="title">คำนำหน้า:</label>
                            <select id="title" name="title" required class="form-select form-select-sm"
                                aria-label="Small select example">
                                <option value="">เลือกคำนำหน้า</option>
                                <option value="Mr.">Ms.</option>
                                <option value="Ms.">Mr.</option>
                                <option value="Mrs.">Mrs.</option>
                            </select><br><br>

                            <label for="fname">ชื่อ:</label>
                            <input type="text" id="fname" name="fname" required><br><br>

                            <label for="lname">นามสกุล:</label>
                            <input type="text" id="lname" name="lname" required><br><br>

                            <label for="address">ที่อยู่:</label>
                            <input type="text" id="address" name="address" required><br><br>

                            <label for="province">จังหวัด:</label>
                            <select id="province" name="province" required class="form-select form-select-sm"
                                aria-label="Small select example">
                                <option value="">เลือกจังหวัด</option>
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?= $province['ProvinceID']; ?>"><?= $province['ProvinceName'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <br><br>

                            <label for="hobbies">งานอดิเรก:</label>
                            <select id="hobbies" name="hobby" required class="form-select form-select-sm"
                                aria-label="Small select example">
                                <option value="">เลือกงานอดิเรก</option>
                                <?php foreach ($hobbys as $hobby): ?>
                                    <option value="<?= $hobby['HobbyID'] ?>"><?= $hobby['HobbyNameEN'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <br><br>

                            <label for="course">หลักสูตร:</label>
                            <select id="course" name="course" required class="form-select form-select-sm"
                                aria-label="Small select example">
                                <option value="">เลือกหลักสูตร</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= $course['CourseID'] ?>"><?= $course['CourseNameEN'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">เพิ่มข้อมูล</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script>
        var modalForm = new bootstrap.Modal(document.getElementById('form'));
        const inputDo = document.querySelector("input[name='do']")


        document.querySelector("#Btn-add").addEventListener("click", e => {
            inputDo.value = "add"
            modalForm.show()
        })

        document.querySelectorAll(".bt-Edit").forEach(element => {
            element.addEventListener("click", async e => {
                inputDo.value = "edit"

                const res = await fetch("?getStudent=" + e.target.dataset.id)

                if (!res.ok) {
                    console.log(`Response status: ${res.status}`)
                    return
                }

                var student = (await res.json()).data;

                if (!student) {
                    console.log(`ไม่มีข้อมูล`)
                    return
                }

                document.querySelector(`input[name='id']`).value = student.STID
                document.querySelector(`select[name="title"] option[value='${student.Title}']`).selected = "true"
                document.querySelector(`input[name='fname']`).value = student.FName
                document.querySelector(`input[name='lname']`).value = student.LName
                document.querySelector(`input[name='address']`).value = student.Address
                document.querySelector(`select[name="hobby"] option[value='${student.HobbyID}']`).selected = "true"
                document.querySelector(`select[name="course"] option[value='${student.CourseID}']`).selected = "true"
                document.querySelector(`select[name="province"] option[value='${student.ProvinceID}']`).selected = "true"

                modalForm.show()
            })
        })

        document.querySelectorAll(".bt-Delete").forEach((element) => {
            element.addEventListener("click", async e => {
                const res = await fetch("?delete=" + e.target.dataset.id, {
                })

                if (res.ok) {
                    location.reload()
                }
            })
        })
    </script>
    </div>

</body>

</html>
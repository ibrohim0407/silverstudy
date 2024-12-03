<?php
$pdo = new PDO('mysql:host=localhost;dbname=school', 'root', ''); // MySQL ulanish

if (isset($_POST['submit_attendance'])) {
    $student_id = $_POST['submit_attendance'];
    $present = isset($_POST['present'][$student_id]) ? 1 : 0;
    $paid = isset($_POST['paid'][$student_id]) ? 1 : 0;

    // Davomatni qo'shish
    $attendanceQuery = $pdo->prepare("INSERT INTO attendance (student_id, date, present, paid) VALUES (?, NOW(), ?, ?)");
    $attendanceQuery->execute([$student_id, $present, $paid]);

    // Agar to'lov qilingan bo'lsa, attendance count ni yangilash
    if ($paid) {
        $updateAttendanceCount = $pdo->prepare("UPDATE students SET attendance_count = attendance_count + 1 WHERE id = ?");
        $updateAttendanceCount->execute([$student_id]);
    }

    header("Location: class.php?id=" . $_GET['id']);
}
?>

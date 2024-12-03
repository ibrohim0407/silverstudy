<?php
// JSON data file
$dataFile = 'data.json';

// Initialize data file if it doesn't exist
if (!file_exists($dataFile)) {
    file_put_contents($dataFile, json_encode(['classes' => []]));
}

// Load data from file
$data = json_decode(file_get_contents($dataFile), true);

// Add a new class
if (isset($_POST['add_class']) && !empty(trim($_POST['class_name']))) {
    $className = trim($_POST['class_name']);
    if (!isset($data['classes'][$className])) {
        $data['classes'][$className] = ['students' => []];
        file_put_contents($dataFile, json_encode($data));
    }
}

// Add a new student
if (isset($_POST['add_student']) && !empty(trim($_POST['student_name'])) && !empty($_POST['class_name'])) {
    $className = $_POST['class_name'];
    $studentName = trim($_POST['student_name']);
    if (isset($data['classes'][$className])) {
        $data['classes'][$className]['students'][] = [
            'name' => $studentName,
            'attendance_count' => 0,
            'present' => false
        ];
        file_put_contents($dataFile, json_encode($data));
    }
}

// Update attendance
if (isset($_POST['update_attendance']) && !empty($_POST['class_name'])) {
    $contents = file_get_contents("input.txt");
    if($contents!=date("Y-m-d")){
    $className = $_POST['class_name'];
    if (isset($data['classes'][$className])) {
        foreach ($data['classes'][$className]['students'] as $index => &$student) {
            if (isset($_POST['attendance'][$index])) {
                if (!$student['present']) {
                    $student['attendance_count']++;
                    $student['present'] = false;
                }
            }
        }
        file_put_contents($dataFile, json_encode($data));
    }
    file_put_contents("input.txt", date("Y-m-d"));
}
    else{
        $message="bugun uchun yangilanish bo'lgan";
        echo "<script>alert('$message');</script>";

    }
}

if (isset($_POST['delete_class']) && !empty($_POST['class_name'])) {
    $className = $_POST['class_name'];
    if (isset($data['classes'][$className])) {
        unset($data['classes'][$className]);
        file_put_contents($dataFile, json_encode($data));
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Attendance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        .class {
            margin-bottom: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        .button-container {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<h1>Class Attendance Management</h1>

<!-- Add New Class Form -->
<form method="POST">
    <label for="class_name">New Class Name:</label>
    <input type="text" id="class_name" name="class_name" required>
    <button type="submit" name="add_class">Add Class</button>
</form>

<?php if (!empty($data['classes'])): ?>
    <?php foreach ($data['classes'] as $className => $classData): ?>
        <div class="class">
            <h2><?= htmlspecialchars($className) ?></h2>

            <!-- Add Student Form -->
            <form method="POST">
                <label for="student_name">Add Student:</label>
                <input type="text" id="student_name" name="student_name" required>
                <input type="hidden" name="class_name" value="<?= htmlspecialchars($className) ?>">
                <button type="submit" name="add_student">Add Student</button>
            </form>

            <!-- Student Table -->
            <form method="POST">
                <input type="hidden" name="class_name" value="<?= htmlspecialchars($className) ?>">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Present</th>
                            <th>Attendance Count</th>
                            <th>Score (x28.5)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($classData['students'] as $index => $student): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars($student["name"]) ?></td>
                                <td><input type="checkbox" name="attendance[<?= $index ?>]" <?= $student['present'] ? 'checked' : '' ?>></td>
                                <td><?= $student['attendance_count'] ?></td>
                                <td><?= number_format($student['attendance_count'] * 28.5, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="button-container">
                    <button type="submit" name="update_attendance">Update Attendance</button>
                </div>
            </form>

            <!-- Delete Class Form -->
            <form method="POST" style="margin-top: 10px;">
                <input type="hidden" name="class_name" value="<?= htmlspecialchars($className) ?>">
                <button type="submit" name="delete_class" onclick="return confirm('Are you sure you want to delete this class?')">Delete Class</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No classes available. Please add a new class.</p>
<?php endif; ?>

</body>
</html>

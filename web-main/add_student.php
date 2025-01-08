<?php
include 'functions.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $studentID = $_POST['studentID'];
    $name = $_POST['name'];
    $gender = $_POST['Gender'];
    $birth_date = $_POST['birth_date'];

 
    $current_date = new DateTime();
    $birth_date_obj = DateTime::createFromFormat('Y-m-d', $birth_date);

    if ($birth_date_obj) {
        $age = $current_date->diff($birth_date_obj)->y;

        if (!empty($studentID) && !empty($name) && ($gender === 'Male' || $gender === 'Female') && !empty($birth_date) && $birth_date_obj <= $current_date && $age <= 100 && $age >= 0) {
           
            $birth_date = $birth_date_obj->format('d/m/Y');

            if (isUniqueID($studentID)) {
                addStudent([$studentID, $name, $gender, $birth_date]);
                header('Location: index.php');
                exit();
            } else {
                echo "Student code already exists!";
            }
        } else {
            echo "Invalid data!";
        }
    } else {
        echo "Invalid date format!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="css/add.css">

</head>

<body>
    <h2>Add Student</h2>
    <section class="form-section">
        <form id="add-form" action="add_student.php" method="POST" class="add-form">
            <div class="form-control">
                <label for="studentID">Student ID:</label>
                <input type="text" id="studentID" name="studentID" required>
                <div id="studentID-error" class="error-message">Student code must be numeric!</div>
            </div>
            <div class="form-control">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                <div id="name-error" class="error-message">Full name cannot be blank and cannot contain strange characters!</div>
            </div>
            <div class="form-control">
                <label for="Gender">Gender:</label>
                <select id="Gender" name="Gender">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
            <div class="form-control">
                <label for="birth_date">Date of Birth:</label>
                <input type="date" id="birth_date" name="birth_date" required>
            </div>
            <button type="submit" name="action" value="add">Add student</button>
            <button type="button" id="back-button" class="back-button">Back</button>
        </form>

    </section>

    <script>
        const fields = [{
                id: 'studentID',
                regex: /^\d+$/,
                errorId: 'studentID-error'
            },
            {
                id: 'name',
                regex: /^[A-Za-z\s]+$/,
                errorId: 'name-error'
            }
        ];

        fields.forEach(({
            id,
            regex,
            errorId
        }) => {
            const input = document.getElementById(id);
            const error = document.getElementById(errorId);

            input.addEventListener('input', () => {
                const value = input.value.trim();
                error.style.display = regex.test(value) ? 'none' : 'block';
            });
        });

        const form = document.getElementById('add-form');
        const birthDateInput = document.getElementById('birth_date');
        const birthDateError = document.createElement('div');
        birthDateError.className = 'error-message';
        birthDateError.id = 'birth_date-error';
        birthDateInput.parentNode.appendChild(birthDateError);

        form.addEventListener('submit', (event) => {
            let isValid = true;

            fields.forEach(({
                id,
                regex,
                errorId
            }) => {
                const input = document.getElementById(id);
                const error = document.getElementById(errorId);
                const value = input.value.trim();

                if (!regex.test(value)) {
                    error.style.display = 'block';
                    isValid = false;
                } else {
                    error.style.display = 'none';
                }
            });

            const birthDateValue = new Date(birthDateInput.value);
            const currentDate = new Date();
            const age = currentDate.getFullYear() - birthDateValue.getFullYear();
            const monthDiff = currentDate.getMonth() - birthDateValue.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && currentDate.getDate() < birthDateValue.getDate())) {
                age--;
            }

            if (birthDateValue > currentDate || age < 0 || age > 100) {
                birthDateError.textContent = 'Invalid date of birth!';
                birthDateError.style.display = 'block';
                isValid = false;
            } else {
                birthDateError.style.display = 'none';
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
        document.getElementById('back-button').addEventListener('click', () => {
            window.location.href = 'index.php';
        });
    </script>
</body>

</html>

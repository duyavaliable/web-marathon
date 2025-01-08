const form = document.getElementById("registerForm");

        form.addEventListener("submit", function (e) {
            e.preventDefault(); // Ngan chan form mac dinh
            let isValid = true;

            // Kiem tra ten nhap co dung khong
            const nameInput = document.getElementById("username");
            const nameError = document.getElementById("nameError");
            const nameValue = nameInput.value.trim();
            const nameRegex = /^[a-zA-Z\sÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂÊÔơưăêô\s]*$/;

            if (!nameValue) {
                nameError.textContent = "Name cannot be left blank";
                isValid = false;
            } else if (!nameRegex.test(nameValue)) {
                nameError.textContent = "Incorrect entry please re-enter";
                isValid = false;
            } else {
                nameError.textContent = "";
            }

            // Kiem tra tuoi
            const ageInput = document.getElementById("age");
            const ageError = document.getElementById("ageError");
            const ageValue = parseInt(ageInput.value, 10);

            if (isNaN(ageValue)) {
                ageError.textContent = "Age cannot be left blank";
                isValid = false;
            } else if (ageValue < 0) {
                ageError.textContent = "Incorrect entry please re-enter";
                isValid = false;
            } else if (ageValue >= 100) {
                ageError.textContent = "Age exceeding the prescribed limit";
                isValid = false;
            } else {
                ageError.textContent = "";
            }

            //Neu thoa man
            if (isValid) {
                form.submit();
            }
        });

        
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const marathonID = urlParams.get('marathonID'); // Mặc định là 2 nếu không có
            const marathonInput = document.getElementById('marathonID');
            if (marathonInput && marathonID) {
                marathonInput.value = marathonID;
            } else {
                //xu ly khi ko co marathonID 
                console.error('Marathon ID is missing in the URL.');
            }
        });
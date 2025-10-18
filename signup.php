<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password_raw = $_POST['password'];

    if (empty($name) || empty($email) || empty($password_raw)) {
        echo "<script>alert('Please fill all fields!'); window.location='index.html';</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format!'); window.location='index.html';</script>";
        exit;
    }

    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Check if email exists
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('Email already exists! Please login.'); window.location='index.html';</script>";
        exit;
    }

    // Insert user
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if (mysqli_query($conn, $sql)) {
        echo "
        <script>
            let overlay = document.createElement('div');
            overlay.style.cssText = `
                position: fixed;
                top: 0; left: 0;
                width: 100%; height: 100%;
                background: rgba(0,0,0,0.6);
                display: flex; align-items: center; justify-content: center;
                z-index: 9999;
            `;

            let popup = document.createElement('div');
            popup.style.cssText = `
                background: white;
                border-radius: 16px;
                box-shadow: 0 8px 20px rgba(0,0,0,0.25);
                padding: 40px;
                text-align: center;
                font-family: Poppins, sans-serif;
                animation: fadeIn 0.3s ease-in-out;
            `;
            popup.innerHTML = `
                <h2 style='color:#4CAF50;'>🎉 Sign-up Successful!</h2>
                <p>Welcome, ${'$name'}! Redirecting to main page...</p>
                <div style='
                    border: 4px solid #f3f3f3;
                    border-top: 4px solid #4CAF50;
                    border-radius: 50%;
                    width: 35px;
                    height: 35px;
                    margin: 15px auto;
                    animation: spin 1s linear infinite;
                '></div>
            `;

            overlay.appendChild(popup);
            document.body.appendChild(overlay);

            let style = document.createElement('style');
            style.innerHTML = `
                @keyframes spin {0% {transform: rotate(0deg);} 100% {transform: rotate(360deg);}}
                @keyframes fadeIn {from {opacity: 0;} to {opacity: 1;}}
            `;
            document.head.appendChild(style);

            // Redirect after 3 seconds
            setTimeout(() => { window.location.href = 'index.html'; }, 3000);
        </script>
        ";
    } else {
        echo "❌ MySQL Error: " . mysqli_error($conn);
    }
}
?>

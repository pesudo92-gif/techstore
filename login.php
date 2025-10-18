<?php
include 'connect.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row['name'];

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
                    <h2 style='color:#4CAF50;'>✅ Login Successful!</h2>
                    <p>Welcome back, ${'$row[name]'}!</p>
                    <div style='
                        border: 4px solid #f3f3f3;
                        border-top: 4px solid #4CAF50;
                        border-radius: 50%;
                        width: 35px;
                        height: 35px;
                        margin: 15px auto;
                        animation: spin 1s linear infinite;
                    '></div>

                    <div style='margin-top: 20px;'>
                        <button id='continueBtn' style='
                            background: #4CAF50;
                            border: none;
                            color: white;
                            padding: 12px 25px;
                            border-radius: 8px;
                            font-size: 16px;
                            cursor: pointer;
                            margin-right: 10px;
                            transition: background 0.3s;
                        '>Continue</button>
                        <button id='logoutBtn' style='
                            background: #e53935;
                            border: none;
                            color: white;
                            padding: 12px 25px;
                            border-radius: 8px;
                            font-size: 16px;
                            cursor: pointer;
                            transition: background 0.3s;
                        '>Logout</button>
                    </div>
                `;

                overlay.appendChild(popup);
                document.body.appendChild(overlay);

                let style = document.createElement('style');
                style.innerHTML = `
                    @keyframes spin {0% {transform: rotate(0deg);} 100% {transform: rotate(360deg);} }
                    @keyframes fadeIn {from {opacity: 0;} to {opacity: 1;} }
                    #continueBtn:hover { background: #388E3C; }
                    #logoutBtn:hover { background: #c62828; }
                `;
                document.head.appendChild(style);

                // Continue button → index.html
                document.getElementById('continueBtn').addEventListener('click', () => {
                    // Hide the logout button instantly
                    document.getElementById('logoutBtn').style.display = 'none';
                    document.getElementById('continueBtn').disabled = true;
                    setTimeout(() => { window.location.href = 'index.html'; }, 400);
                });

                // Logout button → logout.php
                document.getElementById('logoutBtn').addEventListener('click', () => {
                    // Hide the continue button instantly
                    document.getElementById('continueBtn').style.display = 'none';
                    document.getElementById('logoutBtn').disabled = true;
                    setTimeout(() => { window.location.href = 'home.html'; }, 400);
                });
            </script>
            ";
        }
    }
}
?>

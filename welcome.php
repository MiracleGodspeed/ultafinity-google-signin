<?php
require_once 'vendor/autoload.php';


$clientID = '935520943546-05s8lsuqglkuf5d3ef7uceh4oq5eg8l9.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost:8080/ultafinity-login/welcome.php';

$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");


$message = '';

if (isset($_GET['code'])) {
    try {
        
        $code = $_GET['code'];

        $token = $client->fetchAccessTokenWithAuthCode($code);
        if (isset($token['error'])) {
            throw new Exception($token['error_description']);
        }
        $client->setAccessToken($token['access_token']);

        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $name = $google_account_info->name;
        $email = $google_account_info->email;

        // Generate OTP
        $otp = rand(100000, 999999);

        $message = "Welcome $name! Your OTP is $otp";
    } catch (Exception $e) {
        $message = 'An error occurred: Please try again later.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In with Google</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="card shadow">
                    <div class="card-body">
                        <?php if (isset($_GET['code'])): ?>
                            <div class="alert alert-success text-center" id="otp_hold">
                                <?php echo htmlspecialchars($message); ?>
                            </div>
                            <span class="" id="count_hold" style="font-size: 13px;">OTP validity: <span id="validity_count"
                                    class="text-danger">0</span> seconds</span>
                        <?php else: ?>
                            <p>waiting...</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var otp_hold = document.getElementById("otp_hold");
        var count_hold = document.getElementById("count_hold");

        document.addEventListener('DOMContentLoaded', () => {

            // Total time in seconds
            let timeLeft = 30;

            const timerElement = document.getElementById('validity_count');

            function updateTimer() {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

                if (timeLeft > 0) {
                    timeLeft--;
                } else {
                    clearInterval(countdownInterval);
                    otp_hold.innerHTML = "OTP is now invalid"
                    count_hold.style.display = "none"
                }
            }
            updateTimer();
            const countdownInterval = setInterval(updateTimer, 1000);
        });
    </script>
</body>

</html>
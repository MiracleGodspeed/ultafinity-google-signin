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

$authUrl = $client->createAuthUrl();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In with Google</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
            .google-btn {
            background-color: #4285F4;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 20px;
        }

        .google-btn img {
            width: 20px;
            height: 20px;
            margin-right: 10px;
        }

        .google-btn:hover {
            background-color: #357ae8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="card shadow">
                    <div class="card-title text-center border-bottom">
                        <h2 class="p-3">Login</h2>
                    </div>
                    <div class="card-body">
                    <input type="text" class="form-control" placeholder="Enter Username"/>
                    <input type="password" class="form-control mt-3" placeholder="Enter Password"/>
                    <a href="#" class="btn btn-outline-primary w-100 mt-3">Sign In</a>
                <p class="text-center mt-2">OR</p>
                            <a href="<?php echo htmlspecialchars($authUrl); ?>" class="google-btn">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTCWKGr_E3qM7B-B-_xwIZyF12n3sK3eM1q5w&s" alt="Google logo">
                            Sign In with Google
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

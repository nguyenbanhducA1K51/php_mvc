<?php use app\core\Application;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<title>
    <?php echo $this->title ?>
</title>
    </head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">

                        <a class="nav-link" href="/contact">Contact</a>
                    </li>

                </ul>
                    <?php if (Application::isGuest() ) :?>
                    <ul class="navbar-nav ml-auto ">
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/register">Register</a>
                    </li>
                </ul>
                <?php else: ?>
                    <ul class="navbar-nav ml-auto ">
                       <li class="nav-item">
                        <a class="nav-link" href="/profile">Profile 
                            </a>
                    
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/logout">Welcome <?php echo Application::$app->user->getDisplayName() ?>  (Logout)</a> 
                    
                    </li>
                    
                </ul>
                <?php endif;?>
                    
            </div>
        </div>
    </nav>
    <?php if (Application::$app->session->getFlash('success')): ?>
        <div class="alert alert-success">

            <?php echo Application::$app->session->getFlash('success') ?>
        </div>
    <?php endif ?>
    <div class="container">
        {{content}}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>
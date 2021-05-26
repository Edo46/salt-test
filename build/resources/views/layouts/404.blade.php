
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gogi - Admin and Dashboard Template</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ url('assets/assets/media/image/favicon.png') }}"/>

    <!-- Plugin styles -->
    <link rel="stylesheet" href="{{ url('assets/vendors/bundle.css') }}" type="text/css">

    <!-- App styles -->
    <link rel="stylesheet" href="{{ url('assets/assets/css/app.min.css') }}" type="text/css">
</head>
<body class="error-page">

<div>
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <img class="img-fluid" src="{{ url('assets/assets/media/svg/404.svg') }}" alt="...">
            <h3>Page not found</h3>
            <p class="text-muted">The page you want to go is not currently available</p>
            <a href="{{ url('home') }}" class="btn btn-primary">Home Page</a>
        </div>
    </div>
</div>

<!-- Plugin scripts -->
<script src="{{ url('assets/vendors/bundle.js') }}"></script>

<!-- App scripts -->
<script src="{{ url('assets/assets/js/app.min.js') }}"></script>
</body>
</html>

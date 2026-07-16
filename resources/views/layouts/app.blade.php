<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EDL-GEN')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anuphan:wght@100..700&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Phetsarath:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', 'Anuphan', 'Phetsarath', sans-serif;
            height: 100vh;
            width: 600px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        ul {
            list-style-type: none;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        li a {
            text-decoration: none;
            color: #333;
            font-size: 24px;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about">About</a></li>
        <li><a href="/contact">Contact</a></li>
    </ul>
    @yield('content')
</body>
</html>
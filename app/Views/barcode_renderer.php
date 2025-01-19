<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presence with QR Code</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        div {
            display: flex;
            justify-content: center;
        }

        img {
            width: 50%;
            height: 100vh;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div>
        <img src="<?= $image ?>" alt="">
    </div>
</body>

</html>
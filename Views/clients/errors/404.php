<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Không tìm thấy trang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            height: 100vh;
            justify-content: center;
            align-items: center;
            margin: 0;
        }
        .error-container {
            text-align: center;
            max-width: 600px;
        }
        .error-container h1 {
            font-size: 6rem;
            font-weight: bold;
            color: #dc3545;
        }
        .error-container p {
            font-size: 1.25rem;
            margin-top: 1rem;
        }
        .btn-custom {
            font-size: 1.1rem;
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-custom:hover {
            background-color: #0056b3;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <h1>404</h1>
        <p>Trang bạn yêu cầu không tồn tại.</p>
        <a href="<?= BASE_URL ?>" class="btn-custom">Về trang chủ</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

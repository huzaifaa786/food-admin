<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Onboarding Successful</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f8f9fa;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
        }

        .checkmark {
            width: 80px;
            height: 80px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            background-color: #198754;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .checkmark i {
            font-size: 2rem;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container text-center">
        <div class="card p-5">
            <div class="checkmark">
                <i class="bi bi-check2"></i>
            </div>
            <h2 class="mb-3 text-success">Onboarding Complete!</h2>
            <p class="mb-4">Your Stripe account has been successfully connected. You can now start accepting payments
                directly.</p>

        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</body>

</html>

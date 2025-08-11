<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đăng nhập</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .input-group-text {
      background-color: #fff;
      cursor: pointer;
    }

    .form-icon {
      width: 1.2rem;
      height: 1.2rem;
    }
  </style>
</head>

<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="min-width: 500px;">
      <h3 class="text-center mb-4">Meteor Shop</h3>
      <?php if (isset($_SESSION['error'])) { ?>
        <p class="text-danger text-center"><?php echo $_SESSION['error']; ?></p>
        <?php unset($_SESSION['error']); ?>
      <?php } else { ?>
        <p class="text-center">Vui lòng đăng nhập</p>
      <?php } ?>

      <form action="<?= BASE_URL . '?act=check-login' ?>" method="POST">
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mật khẩu</label>
          <div class="input-group">
            <input type="password" class="form-control" id="password" name="password" placeholder="Nhập mật khẩu" required>
            <span class="input-group-text" id="togglePassword">
              <!-- Icon con mắt -->
              <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="form-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7S3.732 16.057 2.458 12z" />
              </svg>
              <!-- Icon con mắt bị gạch -->
              <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="form-icon d-none">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.542-7a9.961 9.961 0 012.406-4.258m1.737-1.612A9.96 9.96 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.972 9.972 0 01-4.293 5.147M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9 9l15-15" />
              </svg>
            </span>
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mb-2">Đăng nhập</button>
        <a href="?act=register" class="link-custom">Sign Up</a>
      </form>
    </div>
  </div>

  <script>
    // Toggle hiển thị mật khẩu
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");
    const eyeOpen = document.getElementById("eyeOpen");
    const eyeClosed = document.getElementById("eyeClosed");

    togglePassword.addEventListener("click", () => {
      const isPassword = passwordInput.getAttribute("type") === "password";
      passwordInput.setAttribute("type", isPassword ? "text" : "password");

      eyeOpen.classList.toggle("d-none");
      eyeClosed.classList.toggle("d-none");
    });
  </script>

</body>

</html>
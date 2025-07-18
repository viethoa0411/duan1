<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <div class="container-fluid">
        <span class="navbar-brand">Admin Dashboard</span>
        <div class="d-flex align-items-center">
            <span class="text-white me-3">Xin chào, Admin</span>
            <a href="#" class="btn btn-outline-light btn-sm">Đăng xuất</a>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark text-white min-vh-100">
            <div class="d-flex flex-column align-items-sm-start px-3 pt-2">
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link text-white">Dashboard</a>
                    </li>
                    <li>
                        <a href="?controller=category&act=index" class="nav-link text-white">Quản lý danh mục</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">Quản lý sản phẩm</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">Quản lý người dùng</a>
                    </li>
                    <li>
                        <a href="#" class="nav-link text-white">Quản lý đơn hàng</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main content -->
        <div class="col py-3">

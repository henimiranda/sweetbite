<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
<title>SweetBite</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body {
    margin:0;
    background: linear-gradient(to right, #f8f9fa, #e0f7fa);
}

/* SIDEBAR */
.sidebar {
    width: 220px;
    height: 100vh;
    position: fixed;
    background: linear-gradient(#ff6b6b, #ff4757);
    padding-top: 20px;
    color: white;
}

.sidebar a {
    display: block;
    color: white;
    padding: 12px;
    text-decoration: none;
}

.sidebar a:hover {
    background: rgba(255,255,255,0.2);
}

/* CONTENT */
.content {
    margin-left: 220px;
    padding: 20px;
}

/* CARD */
.card {
    border-radius: 15px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
</style>

</head>

<body>

<div class="sidebar">
    <h4 class="text-center">🍰 SweetBite</h4>
    <a href="dashboard.php">Dashboard</a>
    <a href="scm_bahan.php">SCM</a>
    <a href="manufacturing.php">Manufacturing</a>
    <a href="sales.php">Sales</a>
    <a href="crm.php">CRM</a>
    <a href="logout.php">Logout</a>
</div>

<div class="content">
```

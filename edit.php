<?php
include "koneksi.php";

 $id = $_GET['id'];
 $q = mysqli_query($conn, "SELECT * FROM tugas WHERE id=$id");
 $tugas = mysqli_fetch_assoc($q);

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $prioritas = $_POST['prioritas'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];

    $query = "UPDATE tugas SET 
        nama_tugas='$nama', 
        prioritas='$prioritas', 
        tanggal='$tanggal',
        status='$status'
        WHERE id=$id";
    mysqli_query($conn, $query);
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4a6cf7;
            --secondary-color: #f5f7ff;
            --accent-color: #6c63ff;
            --text-color: #333;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7ff 0%, #e4e8ff 100%);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 500px;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: var(--primary-color);
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-color);
        }

        input, select {
            padding: 12px 15px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: var(--transition);
        }

        input:focus, select:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.2);
        }

        .btn {
            padding: 12px 20px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn:hover {
            background: var(--accent-color);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            margin-left: 10px;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .back-link:hover {
            color: var(--accent-color);
            text-decoration: underline;
        }

        .priority-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .priority-high { background-color: var(--danger-color); }
        .priority-medium { background-color: var(--warning-color); }
        .priority-low { background-color: var(--success-color); }

        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        /* Tema Warna */
        .theme-selector {
            position: fixed;
            top: 20px;
            right: 20px;
            background: white;
            padding: 10px;
            border-radius: 8px;
            box-shadow: var(--card-shadow);
            z-index: 1000;
        }

        .theme-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin: 0 5px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: var(--transition);
        }

        .theme-btn:hover {
            transform: scale(1.1);
            border-color: #333;
        }

        .theme-btn.active {
            border-color: #333;
            box-shadow: 0 0 0 2px white, 0 0 0 4px #333;
        }

        /* Tema Biru (Default) */
        body.blue-theme {
            --primary-color: #4a6cf7;
            --secondary-color: #f5f7ff;
            --accent-color: #6c63ff;
        }

        /* Tema Hijau */
        body.green-theme {
            --primary-color: #28a745;
            --secondary-color: #f0fff4;
            --accent-color: #20c997;
        }

        /* Tema Ungu */
        body.purple-theme {
            --primary-color: #6f42c1;
            --secondary-color: #f8f5ff;
            --accent-color: #9c27b0;
        }

        /* Tema Oranye */
        body.orange-theme {
            --primary-color: #fd7e14;
            --secondary-color: #fff8f0;
            --accent-color: #ff9800;
        }

        /* Tema Merah */
        body.red-theme {
            --primary-color: #dc3545;
            --secondary-color: #fff5f5;
            --accent-color: #e91e63;
        }
    </style>
</head>
<body>
    <div class="theme-selector">
        <button class="theme-btn active" style="background-color: #4a6cf7;" onclick="setTheme('blue-theme')"></button>
        <button class="theme-btn" style="background-color: #28a745;" onclick="setTheme('green-theme')"></button>
        <button class="theme-btn" style="background-color: #6f42c1;" onclick="setTheme('purple-theme')"></button>
        <button class="theme-btn" style="background-color: #fd7e14;" onclick="setTheme('orange-theme')"></button>
        <button class="theme-btn" style="background-color: #dc3545;" onclick="setTheme('red-theme')"></button>
    </div>

    <div class="container">
        <h2><i class="fas fa-edit"></i> Edit Tugas</h2>
        <form method="post">
            <div class="form-group">
                <label>Nama Tugas:</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($tugas['nama_tugas']) ?>" required>
            </div>

            <div class="form-group">
                <label>Prioritas:</label>
                <select name="prioritas">
                    <option value="Tinggi" <?= $tugas['prioritas']=='Tinggi'?'selected':'' ?>>
                        <span class="priority-indicator priority-high"></span>Tinggi
                    </option>
                    <option value="Sedang" <?= $tugas['prioritas']=='Sedang'?'selected':'' ?>>
                        <span class="priority-indicator priority-medium"></span>Sedang
                    </option>
                    <option value="Rendah" <?= $tugas['prioritas']=='Rendah'?'selected':'' ?>>
                        <span class="priority-indicator priority-low"></span>Rendah
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal:</label>
                <input type="date" name="tanggal" value="<?= $tugas['tanggal'] ?>" required>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select name="status">
                    <option value="Belum Selesai" <?= $tugas['status']=='Belum Selesai'?'selected':'' ?>>Belum Selesai</option>
                    <option value="Selesai" <?= $tugas['status']=='Selesai'?'selected':'' ?>>Selesai</option>
                </select>
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="btn">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
                <a href="index.php" class="back-link">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>

    <script>
        function setTheme(theme) {
            document.body.className = theme;
            
            // Update active button
            document.querySelectorAll('.theme-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            
            // Save theme preference
            localStorage.setItem('todo-theme', theme);
        }

        // Load saved theme
        window.onload = function() {
            const savedTheme = localStorage.getItem('todo-theme');
            if (savedTheme) {
                document.body.className = savedTheme;
                
                // Update active button
                document.querySelectorAll('.theme-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                const themeColors = {
                    'blue-theme': '#4a6cf7',
                    'green-theme': '#28a745',
                    'purple-theme': '#6f42c1',
                    'orange-theme': '#fd7e14',
                    'red-theme': '#dc3545'
                };
                
                document.querySelectorAll('.theme-btn').forEach(btn => {
                    if (btn.style.backgroundColor === themeColors[savedTheme]) {
                        btn.classList.add('active');
                    }
                });
            }
        };
    </script>
</body>
</html>
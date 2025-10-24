<?php
include "koneksi.php";

// Tambah tugas baru
if (isset($_POST['tambah'])) {
    $nama = trim($_POST['nama']);
    $prioritas = $_POST['prioritas'];
    $tanggal = $_POST['tanggal'];

    if ($nama != "") {
        $query = "INSERT INTO tugas (nama_tugas, prioritas, tanggal) VALUES ('$nama', '$prioritas', '$tanggal')";
        mysqli_query($conn, $query);
        $pesan = "Tugas berhasil ditambahkan!";
    } else {
        $pesan = "Nama tugas tidak boleh kosong!";
    }
}

// Tandai selesai
if (isset($_GET['selesai'])) {
    $id = $_GET['selesai'];
    mysqli_query($conn, "UPDATE tugas SET status='Selesai' WHERE id=$id");
}

// Hapus tugas
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tugas WHERE id=$id");
}

 $tugas = mysqli_query($conn, "SELECT * FROM tugas ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List APK</title>
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
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .container:hover {
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

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            background-color: var(--secondary-color);
            color: var(--primary-color);
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-container {
            background-color: var(--secondary-color);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            flex: 1;
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

        .task-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-top: 20px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .task-table thead {
            background-color: var(--primary-color);
            color: white;
        }

        .task-table th {
            padding: 15px;
            text-align: left;
            font-weight: 500;
        }

        .task-table tbody tr {
            border-bottom: 1px solid #eee;
            transition: var(--transition);
        }

        .task-table tbody tr:hover {
            background-color: rgba(74, 108, 247, 0.05);
        }

        .task-table td {
            padding: 15px;
        }

        .task-name {
            font-weight: 500;
        }

        .selesai {
            text-decoration: line-through;
            color: #999;
        }

        .priority-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .priority-high {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }

        .priority-medium {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }

        .priority-low {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .status-selesai {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success-color);
        }

        .status-belum {
            background-color: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 8px 10px;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: var(--transition);
            font-size: 14px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-complete {
            background-color: var(--success-color);
        }

        .btn-edit {
            background-color: var(--primary-color);
        }

        .btn-delete {
            background-color: var(--danger-color);
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 15px;
            color: #ddd;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
            }
            
            .task-table {
                font-size: 14px;
            }
            
            .task-table th, .task-table td {
                padding: 10px 5px;
            }
            
            .action-buttons {
                flex-direction: column;
            }
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
        <h2><i class="fas fa-tasks"></i> Aplikasi To-Do List (PHP + MySQL)</h2>

        <?php if (isset($pesan)): ?>
            <div class="alert">
                <i class="fas fa-check-circle"></i>
                <?= $pesan ?>
            </div>
        <?php endif; ?>

        <div class="form-container">
            <form method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label>Nama Tugas:</label>
                        <input type="text" name="nama" placeholder="Contoh: Belajar PHP" required>
                    </div>
                    <div class="form-group">
                        <label>Prioritas:</label>
                        <select name="prioritas">
                            <option value="Tinggi">Tinggi</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Rendah">Rendah</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Tanggal:</label>
                        <input type="date" name="tanggal" required>
                    </div>
                    <div class="form-group" style="display: flex; align-items: flex-end;">
                        <button type="submit" name="tambah" class="btn">
                            <i class="fas fa-plus"></i> Tambah Tugas
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <h3><i class="fas fa-list"></i> Daftar Tugas</h3>
        
        <?php if (mysqli_num_rows($tugas) > 0): ?>
            <table class="task-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Tugas</th>
                        <th>Status</th>
                        <th>Prioritas</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while($row = mysqli_fetch_assoc($tugas)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="task-name <?= $row['status']=='Selesai'?'selesai':'' ?>"><?= htmlspecialchars($row['nama_tugas']) ?></td>
                        <td>
                            <span class="status-badge <?= $row['status']=='Selesai'?'status-selesai':'status-belum' ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td>
                            <span class="priority-badge priority-<?= strtolower($row['prioritas']) ?>">
                                <?= $row['prioritas'] ?>
                            </span>
                        </td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                        <td>
                            <div class="action-buttons">
                                <?php if ($row['status'] == 'Belum Selesai'): ?>
                                    <a href="?selesai=<?= $row['id'] ?>" class="action-btn btn-complete">
                                        <i class="fas fa-check"></i> Selesai
                                    </a>
                                <?php endif; ?>
                                <a href="edit.php?id=<?= $row['id'] ?>" class="action-btn btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="?hapus=<?= $row['id'] ?>" class="action-btn btn-delete" onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-clipboard-list"></i>
                <p>Belum ada tugas. Tambah tugas baru untuk memulai!</p>
            </div>
        <?php endif; ?>
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
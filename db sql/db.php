CREATE DATABASE todo_app;
USE todo_app;

CREATE TABLE tugas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_tugas VARCHAR(100) NOT NULL,
    status VARCHAR(20) DEFAULT 'Belum Selesai',
    prioritas VARCHAR(20),
    tanggal DATE
);
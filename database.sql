-- ============================================================
--  DATABASE: Thu Vien CD Bach Khoa
--  Schema gop: quan ly doc gia day du + quan ly kho sach
--  Import vao phpMyAdmin: http://localhost/phpmyadmin
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `thuvien_db`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `thuvien_db`;

DROP TABLE IF EXISTS `loans`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `books`;
DROP TABLE IF EXISTS `doc_gia`;

-- ------------------------------------------------------------
-- Bang doc_gia: thong tin ca nhan day du
-- ------------------------------------------------------------
CREATE TABLE `doc_gia` (
  `id_doc_gia`    INT AUTO_INCREMENT PRIMARY KEY,
  `ma_doc_gia`    VARCHAR(10)  NOT NULL UNIQUE COMMENT 'VD: DG001',
  `ho_ten`        VARCHAR(100) NOT NULL,
  `ngay_sinh`     DATE         DEFAULT NULL,
  `gioi_tinh`     VARCHAR(10)  DEFAULT NULL,
  `so_dien_thoai` VARCHAR(15)  DEFAULT NULL,
  `dia_chi`       VARCHAR(255) DEFAULT NULL,
  `email`         VARCHAR(100) DEFAULT NULL,
  `created_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Bang users: tai khoan dang nhap
-- role: admin = toan quyen | user = chi muon sach cua minh
-- ------------------------------------------------------------
CREATE TABLE `users` (
  `id`            INT AUTO_INCREMENT PRIMARY KEY,
  `username`      VARCHAR(50)  NOT NULL UNIQUE,
  `password`      VARCHAR(255) NOT NULL,
  `role`          ENUM('admin','user') NOT NULL DEFAULT 'user',
  `status`        TINYINT(1)   NOT NULL DEFAULT 1 COMMENT '1=hoat dong, 0=bi khoa',
  `id_doc_gia`    INT          DEFAULT NULL COMMENT 'Lien ket ho so doc gia',
  `created_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_users_docgia` FOREIGN KEY (`id_doc_gia`)
    REFERENCES `doc_gia`(`id_doc_gia`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Bang books: sach + quan ly kho
-- ------------------------------------------------------------
CREATE TABLE `books` (
  `id`           INT AUTO_INCREMENT PRIMARY KEY,
  `title`        VARCHAR(200) NOT NULL,
  `author`       VARCHAR(150) NOT NULL,
  `category`     VARCHAR(100) NOT NULL,
  `publisher`    VARCHAR(150) DEFAULT NULL,
  `publish_year` INT          DEFAULT NULL,
  `quantity`     INT          NOT NULL DEFAULT 0 COMMENT 'Tong so luong',
  `available`    INT          NOT NULL DEFAULT 0 COMMENT 'So luong con lai',
  `description`  TEXT,
  `cover_image`  VARCHAR(255) DEFAULT NULL,
  `created_at`   TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Bang loans: phieu muon tra
-- ------------------------------------------------------------
CREATE TABLE `loans` (
  `id`          INT AUTO_INCREMENT PRIMARY KEY,
  `user_id`     INT NOT NULL,
  `book_id`     INT NOT NULL,
  `borrow_date` DATE NOT NULL,
  `due_date`    DATE NOT NULL,
  `return_date` DATE DEFAULT NULL,
  `renew_count` INT NOT NULL DEFAULT 0 COMMENT 'So lan gia han',
  `status`      ENUM('pending','borrowed','returned','overdue','rejected')
                NOT NULL DEFAULT 'borrowed',
  `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT `fk_loans_user` FOREIGN KEY (`user_id`)
    REFERENCES `users`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_loans_book` FOREIGN KEY (`book_id`)
    REFERENCES `books`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
--  DU LIEU: DOC GIA THAT (chuyen tu quanlythuvien, bo phieu muon cu)
-- ============================================================
INSERT INTO `doc_gia` (`id_doc_gia`, `ma_doc_gia`, `ho_ten`, `ngay_sinh`, `gioi_tinh`, `so_dien_thoai`, `dia_chi`, `email`) VALUES
(1, 'DG001', 'Nguyễn Văn An',   '2007-03-15', 'Nam', '0912345678', 'Hà Nội',     'an@example.com'),
(2, 'DG002', 'Trần Minh Anh',   '2006-07-22', 'Nữ',  '0987654321', 'Hà Nội',     'anh@example.com'),
(3, 'DG003', 'Lê Hoàng Nam',    '2007-01-10', 'Nam', '0901234567', 'Ninh Bình',  'nam@example.com'),
(4, 'DG004', 'Phạm Thu Hà',     '2006-11-05', 'Nữ',  '0934567890', 'Bắc Ninh',   'ha@example.com'),
(5, 'DG005', 'Đỗ Minh Quân',    '2007-08-18', 'Nam', '0978123456', 'Thanh Hóa',  'quan@example.com'),
(6, 'DG006', 'Lê Hoàng Thắng',  '2006-02-14', 'Nam', '0987654232', 'Hà Nội',     'thang@example.com');

-- ============================================================
--  DU LIEU: SACH THAT (chuyen tu quanlythuvien + bo sung kho)
-- ============================================================
INSERT INTO `books`
(`id`, `title`, `author`, `category`, `publisher`, `publish_year`, `quantity`, `available`, `description`, `cover_image`) VALUES
(1, 'Có hai con mèo ngồi bên cửa sổ', 'Nguyễn Nhật Ánh', 'Đồng thoại', 'NXB Trẻ',        2019, 5, 5, 'Câu chuyện trong trẻo về tình bạn tuổi thơ qua góc nhìn của hai chú mèo.', 'Có hai con mèo ngồi bên cửa sổ.jpg'),
(2, 'Hồ Điệp và Kình Ngư',            'Tuế Kiến',        'Tiểu thuyết','NXB Văn Học',    2020, 4, 4, 'Tiểu thuyết thanh xuân vườn trường nhẹ nhàng, giàu cảm xúc.',              'ho-diep-va-kinh-ngu_17307_1.jpg'),
(3, 'Làm bạn với bầu trời',           'Nguyễn Nhật Ánh', 'Truyện dài', 'NXB Trẻ',        2018, 3, 3, 'Hành trình chữa lành của cậu bé Tèo và tình cảm gia đình ấm áp.',          '(Pdf) Làm bạn với bầu trời - Nguyễn Nhật Ánh.jpg'),
(4, 'Harry Potter và hòn đá phù thủy','J.K. Rowling',    'Fantasy',    'NXB Trẻ',        2001, 6, 6, 'Tập đầu tiên của loạt truyện phép thuật nổi tiếng thế giới.',              'harry-potter-1.jpg'),
(5, 'Tuổi trẻ đáng giá bao nhiêu?',   'Rosie Nguyễn',    'Kỹ năng sống','NXB Hội Nhà Văn',2016, 4, 4, 'Những chia sẻ truyền cảm hứng về học tập, trải nghiệm và trưởng thành.',   '6aa6a74a1055d.jpg');

-- ============================================================
--  DU LIEU: TAI KHOAN
-- Mat khau hash bang password_hash(PASSWORD_DEFAULT):
--   admin / admin123
--   an|anh|nam|ha|quan|thang / 123456
-- ============================================================
INSERT INTO `users` (`username`, `password`, `role`, `status`, `id_doc_gia`) VALUES
('admin',  '$2y$10$wM/nAysmi1rVimziCdKE.uaVJq.i5HOA9ux/xlFivyV3.kGkAnB6K', 'admin', 1, NULL),
('an',     '$2y$10$GcOAOdw0ardPstH09JXHU.hqs7CAjVnvTraxexPiDyv2.cBBFTzyq', 'user',  1, 1),
('anh',    '$2y$10$GcOAOdw0ardPstH09JXHU.hqs7CAjVnvTraxexPiDyv2.cBBFTzyq', 'user',  1, 2),
('nam',    '$2y$10$GcOAOdw0ardPstH09JXHU.hqs7CAjVnvTraxexPiDyv2.cBBFTzyq', 'user',  1, 3),
('ha',     '$2y$10$GcOAOdw0ardPstH09JXHU.hqs7CAjVnvTraxexPiDyv2.cBBFTzyq', 'user',  1, 4),
('quan',   '$2y$10$GcOAOdw0ardPstH09JXHU.hqs7CAjVnvTraxexPiDyv2.cBBFTzyq', 'user',  1, 5),
('thang',  '$2y$10$GcOAOdw0ardPstH09JXHU.hqs7CAjVnvTraxexPiDyv2.cBBFTzyq', 'user',  1, 6);

-- ============================================================
--  QUY TAC ID: KHONG TAI SU DUNG ID DA XOA
-- ============================================================
-- Cac bang deu dung AUTO_INCREMENT, chi TANG va KHONG BAO GIO GIAM.
-- Vi vay khi xoa ban ghi (vd DG006) roi them moi, ban ghi moi se co
-- id/ma MOI (DG007), khong quay lai dung id/ma cu.
--
-- QUAN TRONG: KHONG dat lai AUTO_INCREMENT (khong dung ALTER TABLE ... AUTO_INCREMENT = N)
-- va KHONG dung TRUNCATE TABLE, vi se lam ID bat dau lai tu dau -> tai su dung ID cu.
-- Muon xoa sach du lieu thi dung DELETE FROM (khong dung TRUNCATE).

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
--  GHI CHU
-- ============================================================
-- Database nay gop tu 2 project:
--   - library        -> quan ly kho (quantity/available), upload anh bia, bao mat day du
--   - quanlythuvien  -> ho so doc gia day du (ngay sinh, gioi tinh, SDT, dia chi), ma DGxxx
--
-- Phieu muon cu KHONG chuyen sang (coi nhu du lieu demo cua project cu).
-- De doi mat khau: mo http://localhost/thuvien/generate_password.php
-- ============================================================

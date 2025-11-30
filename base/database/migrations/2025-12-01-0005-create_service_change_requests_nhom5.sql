-- Migration for nhom5 DB: add service_change_requests table
-- Run: mysql -u root -p du_an1 < 2025-12-01-0005-create_service_change_requests_nhom5.sql

CREATE TABLE IF NOT EXISTS service_change_requests (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  booking_id BIGINT UNSIGNED NOT NULL,
  `request` TEXT NOT NULL,
  `status` VARCHAR(50) DEFAULT 'pending',
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
) ENGINE=InnoDB;

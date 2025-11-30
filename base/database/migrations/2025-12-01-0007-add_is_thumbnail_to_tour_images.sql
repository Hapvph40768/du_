-- Migration for nhom5 DB: add is_thumbnail to tour_images if missing
-- Run: mysql -u root -p du_an1 < 2025-12-01-0007-add_is_thumbnail_to_tour_images.sql

ALTER TABLE `tour_images`
  ADD COLUMN IF NOT EXISTS `is_thumbnail` TINYINT(1) NOT NULL DEFAULT 0;

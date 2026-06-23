-- Migration: Add customer fields to bookings (idempotent on MySQL 8+)
-- Adds: customer_name, customer_phone, customer_email

ALTER TABLE bookings
  ADD COLUMN IF NOT EXISTS customer_name VARCHAR(150) NULL AFTER total_price,
  ADD COLUMN IF NOT EXISTS customer_phone VARCHAR(50) NULL AFTER customer_name,
  ADD COLUMN IF NOT EXISTS customer_email VARCHAR(150) NULL AFTER customer_phone;

-- If your MySQL version does not support "IF NOT EXISTS" on ADD COLUMN,
-- run the following guarded statements instead (uncomment and adjust DB name):
--
-- SET @db := DATABASE();
-- SELECT COUNT(*) INTO @cnt FROM INFORMATION_SCHEMA.COLUMNS
--  WHERE TABLE_SCHEMA=@db AND TABLE_NAME='bookings' AND COLUMN_NAME='customer_name';
-- PREPARE stmt FROM 'ALTER TABLE bookings ADD COLUMN customer_name VARCHAR(150) NULL AFTER total_price';
-- IF @cnt = 0 THEN EXECUTE stmt; END IF;
-- DEALLOCATE PREPARE stmt;
-- (Repeat checks for other columns)

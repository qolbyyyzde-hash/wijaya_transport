-- Migration: Add driver_option and pickup_option to bookings
-- Adds booking metadata for driver service and pickup method.

-- MySQL 8+ supports adding columns conditionally by checking INFORMATION_SCHEMA first.
-- This migration is intentionally written to be safe when executed manually.

SET @db_name := DATABASE();

SELECT COUNT(*) INTO @count_driver FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA=@db_name AND TABLE_NAME='bookings' AND COLUMN_NAME='driver_option';

SELECT COUNT(*) INTO @count_pickup FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA=@db_name AND TABLE_NAME='bookings' AND COLUMN_NAME='pickup_option';

SET @sql_driver = IF(@count_driver = 0, 'ALTER TABLE bookings ADD COLUMN driver_option VARCHAR(100) NULL AFTER total_price', 'SELECT 1');
SET @sql_pickup = IF(@count_pickup = 0, 'ALTER TABLE bookings ADD COLUMN pickup_option VARCHAR(100) NULL AFTER driver_option', 'SELECT 1');

PREPARE stmt_driver FROM @sql_driver; EXECUTE stmt_driver; DEALLOCATE PREPARE stmt_driver;
PREPARE stmt_pickup FROM @sql_pickup; EXECUTE stmt_pickup; DEALLOCATE PREPARE stmt_pickup;

-- Migration: Add foto_ktp and foto_sim to bookings
-- Adds uploaded identity documents for customer bookings.

SET @db_name := DATABASE();

SELECT COUNT(*) INTO @count_ktp FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA=@db_name AND TABLE_NAME='bookings' AND COLUMN_NAME='foto_ktp';

SELECT COUNT(*) INTO @count_sim FROM INFORMATION_SCHEMA.COLUMNS
  WHERE TABLE_SCHEMA=@db_name AND TABLE_NAME='bookings' AND COLUMN_NAME='foto_sim';

SET @sql_ktp = IF(@count_ktp = 0, 'ALTER TABLE bookings ADD COLUMN foto_ktp VARCHAR(255) NULL AFTER pickup_option', 'SELECT 1');
SET @sql_sim = IF(@count_sim = 0, 'ALTER TABLE bookings ADD COLUMN foto_sim VARCHAR(255) NULL AFTER foto_ktp', 'SELECT 1');

PREPARE stmt_ktp FROM @sql_ktp;
EXECUTE stmt_ktp;
DEALLOCATE PREPARE stmt_ktp;

PREPARE stmt_sim FROM @sql_sim;
EXECUTE stmt_sim;
DEALLOCATE PREPARE stmt_sim;

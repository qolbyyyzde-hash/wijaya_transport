-- Migration: Add proof_image column to payments
-- Adds support for uploaded payment proof files

ALTER TABLE payments
  ADD COLUMN IF NOT EXISTS proof_image VARCHAR(255) NULL AFTER payment_date;

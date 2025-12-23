-- ============================================
-- Fix Missing Columns - Run di phpMyAdmin
-- ============================================

-- Add is_published column to testimonials table
ALTER TABLE `testimonials` 
ADD COLUMN `is_published` tinyint(1) NOT NULL DEFAULT 1 AFTER `is_featured`;

-- Verify the change
DESCRIBE `testimonials`;

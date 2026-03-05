ALTER TABLE `appointments`
  ADD COLUMN `appointment_end_time` TIME NULL DEFAULT NULL AFTER `appointment_time`,
  ADD COLUMN `appointment_end_datetime` DATETIME NULL DEFAULT NULL AFTER `appointment_datetime`;


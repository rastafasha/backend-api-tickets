# TODO: Fix Foreign Key Constraint Error in Payments Migration

## Steps to Complete:
- [x] Rename the `eventos` migration file to an earlier timestamp (e.g., 2025_05_28_131430_create_eventos_table.php) to ensure it runs before the `payments` migration.
- [x] Run `php artisan migrate` to apply the migrations in the correct order.
- [x] Verify that all migrations run successfully without errors.
- [x] The `payments` table already exists in the database, so we need to drop it manually or skip the migration.
- [x] Drop the existing `payments` table from the database to allow the migration to run.
- [x] Run `php artisan migrate` again to complete the remaining migrations.

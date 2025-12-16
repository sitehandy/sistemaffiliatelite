<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Add default_url to affiliate_programs (if not exists)
        if (!Schema::hasColumn('affiliate_programs', 'default_url')) {
            Schema::table('affiliate_programs', function (Blueprint $table) {
                $table->string('default_url')->nullable()->after('invitation_code');
            });
        }

        // Get the database name
        $database = DB::getDatabaseName();

        // Get foreign key name for product_id
        $foreignKey = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = '{$database}'
            AND TABLE_NAME = 'tracking_links'
            AND COLUMN_NAME = 'product_id'
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        // Drop foreign key first if exists
        if ($foreignKey) {
            DB::statement("ALTER TABLE tracking_links DROP FOREIGN KEY {$foreignKey->CONSTRAINT_NAME}");
        }

        // Drop unique index if exists
        try {
            DB::statement("ALTER TABLE tracking_links DROP INDEX tracking_links_user_id_product_id_program_id_unique");
        } catch (\Exception $e) {
            // Index might not exist, continue
        }

        // Modify column to be nullable
        DB::statement('ALTER TABLE tracking_links MODIFY product_id BIGINT UNSIGNED NULL');

        // Re-add foreign key with nullOnDelete
        Schema::table('tracking_links', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('affiliate_programs', 'default_url')) {
            Schema::table('affiliate_programs', function (Blueprint $table) {
                $table->dropColumn('default_url');
            });
        }

        $database = DB::getDatabaseName();

        // Get foreign key name for product_id
        $foreignKey = DB::selectOne("
            SELECT CONSTRAINT_NAME
            FROM information_schema.KEY_COLUMN_USAGE
            WHERE TABLE_SCHEMA = '{$database}'
            AND TABLE_NAME = 'tracking_links'
            AND COLUMN_NAME = 'product_id'
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if ($foreignKey) {
            DB::statement("ALTER TABLE tracking_links DROP FOREIGN KEY {$foreignKey->CONSTRAINT_NAME}");
        }

        // Delete rows with NULL product_id
        DB::statement('DELETE FROM tracking_links WHERE product_id IS NULL');

        // Make column NOT NULL again
        DB::statement('ALTER TABLE tracking_links MODIFY product_id BIGINT UNSIGNED NOT NULL');

        Schema::table('tracking_links', function (Blueprint $table) {
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();
            $table->unique(['user_id', 'product_id', 'program_id']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'appointment_types',
            'appointments',
            'availability_windows',
            'bills',
            'collections',
            'contacts',
            'departments',
            'ecats',
            'holidays',
            'invoices',
            'modes',
            'options',
            'patients',
            'payments',
            'products',
            'responses',
            'rooms',
            'services',
            'sliders',
            'sms_logs',
            'sms_templates',
            'zoom_meetings',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                if (!Schema::hasColumn($tableName, 'isDeleted')) {
                    $table->tinyInteger('isDeleted')->default(0)->after('id');
                }
                if (!Schema::hasColumn($tableName, 'deletedBy')) {
                    $table->unsignedBigInteger('deletedBy')->nullable()->after('isDeleted');
                }
                if (!Schema::hasColumn($tableName, 'deleted_at')) {
                    $table->timestamp('deleted_at')->nullable()->after('deletedBy');
                }
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'appointment_types',
            'appointments',
            'availability_windows',
            'bills',
            'collections',
            'contacts',
            'departments',
            'ecats',
            'holidays',
            'invoices',
            'modes',
            'options',
            'patients',
            'payments',
            'products',
            'responses',
            'rooms',
            'services',
            'sliders',
            'sms_logs',
            'sms_templates',
            'zoom_meetings',
        ];

        foreach ($tables as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('isDeleted');
                $table->dropColumn('deletedBy');
                $table->dropColumn('deleted_at');
            });
        }
    }
};

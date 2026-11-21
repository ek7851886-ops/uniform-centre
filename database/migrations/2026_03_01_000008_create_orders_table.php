<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('quotation_id')->nullable()->constrained('quotation_requests')->nullOnDelete();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', [
                'order_confirmed', 'fabric_arranged', 'cutting', 'stitching',
                'embroidery_printing', 'quality_check', 'ready_for_delivery',
                'out_for_delivery', 'delivered',
            ])->default('order_confirmed');
            $table->date('expected_delivery_date')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

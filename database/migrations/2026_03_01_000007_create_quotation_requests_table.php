<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotation_requests', function (Blueprint $table) {
            $table->id();
            $table->string('quote_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();

            $table->string('company_name');
            $table->string('contact_person');
            $table->string('email');
            $table->string('phone');
            $table->text('company_address')->nullable();

            $table->string('category')->nullable();
            $table->integer('quantity');
            $table->string('preferred_fabric')->nullable();
            $table->string('preferred_color')->nullable();
            $table->json('sizes')->nullable();

            $table->boolean('logo_required')->default(false);
            $table->string('logo_path')->nullable();
            $table->boolean('embroidery_required')->default(false);
            $table->boolean('printing_required')->default(false);
            $table->boolean('reflective_strips_required')->default(false);
            $table->boolean('name_embroidery_required')->default(false);
            $table->text('additional_requirements')->nullable();

            $table->date('required_delivery_date')->nullable();
            $table->string('delivery_city')->nullable();
            $table->text('delivery_address')->nullable();

            $table->enum('status', ['pending', 'under_review', 'quoted', 'approved', 'rejected'])->default('pending');
            $table->decimal('price_per_unit', 10, 2)->nullable();
            $table->decimal('embroidery_charges', 10, 2)->default(0);
            $table->decimal('printing_charges', 10, 2)->default(0);
            $table->decimal('delivery_charges', 10, 2)->default(0);
            $table->decimal('other_charges', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_requests');
    }
};

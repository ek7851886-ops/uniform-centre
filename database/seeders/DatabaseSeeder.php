<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Client;
use App\Models\PortfolioItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@company.com'],
            ['name' => 'Admin', 'company_name' => 'Uniform Manufacturing Co.', 'contact_person' => 'Admin', 'phone' => '03000000000', 'password' => Hash::make('admin12345'), 'role' => 'admin']
        );

        $categoryNames = [
            'Corporate Uniforms' => 'Sharp, professional attire for office and administrative staff.',
            'Industrial Uniforms' => 'Durable workwear built for factories and industrial environments.',
            'Security Uniforms' => 'Distinctive, authoritative uniforms for security personnel.',
            'Hospitality Uniforms' => 'Elegant front-of-house attire for hotels and restaurants.',
            'Housekeeping Uniforms' => 'Practical, comfortable uniforms for housekeeping teams.',
            'Restaurant Uniforms' => 'Functional kitchen and service wear for food & beverage staff.',
            'Workwear' => 'Rugged everyday workwear for demanding job sites.',
            'Custom Uniforms' => 'Fully bespoke uniform design for unique business needs.',
        ];

        $categories = [];
        foreach ($categoryNames as $name => $desc) {
            $categories[$name] = Category::firstOrCreate(['slug' => Str::slug($name)], ['name' => $name, 'description' => $desc, 'is_active' => true]);
        }

        $products = [
            ['name' => 'Hospitality Front-of-House Set', 'category' => 'Hospitality Uniforms', 'description' => 'Waistcoat and tailored trouser set for hotel and restaurant front-of-house staff, with tunic-collar variant for housekeeping supervisors. Fully customizable with company logo embroidery.', 'fabric_options' => 'Cotton Blend, Poly-Viscose', 'color_options' => 'Olive, Charcoal, Navy', 'customization' => ['logo', 'name_embroidery', 'custom_measurements'], 'image' => 'hospitality-uniform-set.jpg'],
            ['name' => 'Corporate Polo Shirt', 'category' => 'Corporate Uniforms', 'description' => 'Smart-casual polo shirt for corporate and fleet-management teams, with embroidered company logo on the chest.', 'fabric_options' => 'Pique Cotton', 'color_options' => 'Royal Blue, White, Grey', 'customization' => ['logo', 'printing'], 'image' => 'corporate-polo-nkc.jpg'],
            ['name' => 'Housekeeping Coverall', 'category' => 'Housekeeping Uniforms', 'description' => 'Durable long-sleeve coverall for mall and facility housekeeping staff, with reflective strips for visibility and back embroidery.', 'fabric_options' => 'Poly-Cotton Twill', 'color_options' => 'Steel Blue, Grey', 'customization' => ['logo', 'reflective', 'name_embroidery'], 'image' => 'housekeeping-uniform-amazonmall.jpg'],
            ['name' => 'Security & Facilities Shirt', 'category' => 'Security Uniforms', 'description' => 'Structured shirt for security and facilities-management personnel, embroidered with company branding.', 'fabric_options' => 'Cotton Twill', 'color_options' => 'Bottle Green, Navy, Grey', 'customization' => ['logo', 'name_embroidery', 'custom_measurements'], 'image' => 'security-shirt-pfm.jpg'],
            ['name' => 'Industrial Embroidered Workshirt', 'category' => 'Industrial Uniforms', 'description' => 'Heavy-duty workshirt for engineering and industrial service teams, with full-color logo embroidery.', 'fabric_options' => 'Twill, Ripstop', 'color_options' => 'Charcoal, Navy', 'customization' => ['logo', 'printing', 'reflective'], 'image' => 'embroidery-design-continental.jpg'],
            ['name' => 'Custom Branded Uniform', 'category' => 'Custom Uniforms', 'description' => 'Fully bespoke uniform piece — fabric, cut, and embroidery designed to your specification, like this custom logo work.', 'fabric_options' => 'Client Specified', 'color_options' => 'Client Specified', 'customization' => ['logo', 'printing', 'name_embroidery', 'custom_measurements'], 'image' => 'embroidery-detail-mm.jpg'],
        ];

        foreach ($products as $p) {
            $cat = $categories[$p['category']];
            $product = Product::firstOrCreate(
                ['slug' => Str::slug($p['name'])],
                ['category_id' => $cat->id, 'name' => $p['name'], 'description' => $p['description'], 'fabric_options' => $p['fabric_options'], 'color_options' => $p['color_options'], 'customization_options' => $p['customization'], 'is_active' => true]
            );
            if ($product->images()->count() === 0) {
                ProductImage::create(['product_id' => $product->id, 'image_path' => 'products/' . $p['image'], 'is_primary' => true, 'sort_order' => 0]);
            }
        }

        // ---- Clients (from real business relationships) ----
        $clientNames = [
            'Internet Security (Pvt) Ltd', 'Avalon Private Housekeeping', 'J.J. Interprice (Pvt) Ltd',
            'M.M. Associates (Pvt) Ltd', 'Continental Engineering Services (Pvt) Ltd', 'Kolachi',
            'OPL', 'Giga Mall', 'Excellent (Pvt) Ltd', 'Amazon Mall', 'Angro',
        ];
        foreach ($clientNames as $i => $name) {
            Client::firstOrCreate(['company_name' => $name], ['display_order' => $i, 'is_active' => true]);
        }

        // ---- Portfolio (using real uniform photos) ----
        $portfolioItems = [
            ['title' => 'Amazon Mall Housekeeping Uniform', 'category' => 'Industrial', 'image' => 'products/housekeeping-uniform-amazonmall.jpg', 'client_name' => 'Amazon Mall'],
            ['title' => 'M.M. Associates Embroidery', 'category' => 'Embroidery', 'image' => 'products/embroidery-detail-mm.jpg', 'client_name' => 'M.M. Associates (Pvt) Ltd'],
            ['title' => 'Corporate Fleet Polo', 'category' => 'Corporate', 'image' => 'products/corporate-polo-nkc.jpg', 'client_name' => null],
            ['title' => 'Hospitality Front-of-House Set', 'category' => 'Hospitality', 'image' => 'products/hospitality-uniform-set.jpg', 'client_name' => null],
            ['title' => 'Security & Facilities Uniform', 'category' => 'Security', 'image' => 'products/security-shirt-pfm.jpg', 'client_name' => null],
            ['title' => 'Continental Engineering Logo Design', 'category' => 'Embroidery', 'image' => 'products/embroidery-design-continental.jpg', 'client_name' => 'Continental Engineering Services (Pvt) Ltd'],
        ];
        foreach ($portfolioItems as $p) {
            PortfolioItem::firstOrCreate(
                ['title' => $p['title']],
                ['category' => $p['category'], 'image_path' => $p['image'], 'client_name' => $p['client_name'], 'is_active' => true]
            );
        }
    }
}

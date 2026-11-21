<?php

namespace App\Http\Controllers;

class CustomizationController extends Controller
{
    public function index()
    {
        $sections = [
            ['title' => 'Company Logo Embroidery', 'image' => 'products/embroidery-detail-mm.jpg',
             'desc' => 'Precision embroidery of your company logo on every piece — clean lines, accurate colors, and durable stitching that holds up to daily wear and repeated washing.'],
            ['title' => 'Fabric Selection', 'image' => 'products/hospitality-uniform-set.jpg',
             'desc' => 'Choose from a range of fabrics suited to your work environment — breathable cotton blends for hospitality, rugged twill for industrial use, and moisture-wicking options for active roles.'],
            ['title' => 'Color Selection & Custom Design', 'image' => 'products/security-shirt-pfm.jpg',
             'desc' => 'Match your uniforms to your brand colors, or work with us on a fully custom design — cut, trims, and piping detail included.'],
            ['title' => 'Employee Sizes & Name Embroidery', 'image' => 'products/corporate-polo-nkc.jpg',
             'desc' => 'Full size ranges from XS to XXL, plus custom measurements for individual employees. Add name embroidery for a personalized, professional finish.'],
            ['title' => 'Reflective Material & Special Requirements', 'image' => 'products/housekeeping-uniform-amazonmall.jpg',
             'desc' => 'Reflective strips for visibility on job sites, plus any special requirements your business needs — pockets, badge holders, or reinforced stitching.'],
        ];

        return view('products.customization', compact('sections'));
    }
}

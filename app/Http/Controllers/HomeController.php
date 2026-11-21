<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    private function features(): array
    {
        return [
            ['icon' => '🧵', 'title' => 'Custom Uniform Manufacturing', 'desc' => 'Every uniform manufactured to your exact specifications, from fabric to fit.'],
            ['icon' => '📦', 'title' => 'Bulk Corporate Orders', 'desc' => 'Reliable capacity for orders of any size, from small teams to entire workforces.'],
            ['icon' => '🧷', 'title' => 'Logo Embroidery', 'desc' => 'Precision embroidery of your company logo on every uniform we produce.'],
            ['icon' => '🎨', 'title' => 'Custom Colors & Designs', 'desc' => 'Match your brand identity with tailored color schemes and design details.'],
            ['icon' => '✅', 'title' => 'Quality Fabric', 'desc' => 'Durable, comfortable materials sourced for demanding work environments.'],
            ['icon' => '📏', 'title' => 'Size Customization', 'desc' => 'Full size ranges plus custom measurements for a consistent workforce look.'],
            ['icon' => '🚚', 'title' => 'Reliable Delivery', 'desc' => 'Dependable production timelines and delivery you can plan around.'],
        ];
    }

    public function index()
    {
        $features = $this->features();

        return view('home.index', compact('features'));
    }

    public function about()
    {
        $features = $this->features();
        $stats = [
            ['value' => 15, 'suffix' => '+', 'label' => 'Years of Experience'],
            ['value' => 40, 'suffix' => '+', 'label' => 'Corporate Clients'],
            ['value' => 50000, 'suffix' => '+', 'label' => 'Uniforms Delivered'],
            ['value' => 1200, 'suffix' => '+', 'label' => 'Completed Orders'],
        ];

        return view('home.about', compact('stats', 'features'));
    }
}

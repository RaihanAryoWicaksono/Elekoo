<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Admin User
        $admin = User::create([
            'name'     => 'Admin Elekoo',
            'email'    => 'admin@elekoo.id',
            'password' => bcrypt('password'), // password: password
            'role'     => 'admin',
            'phone'    => '081234567890',
            'address'  => 'Jl. Teknologi No. 1, Jakarta Pusat',
        ]);

        // Buat Customer Biasa
        $customer1 = User::create([
            'name'     => 'John Doe Customer',
            'email'    => 'customer@gmail.com',
            'password' => bcrypt('password'),
            'role'     => 'customer',
            'phone'    => '089876543210',
            'address'  => 'Jl. Sudirman No. 10, Jakarta Selatan',
        ]);

        $customer2 = User::create([
            'name'     => 'Jane Smith',
            'email'    => 'jane@gmail.com',
            'password' => bcrypt('password'),
            'role'     => 'customer',
            'phone'    => '081122334455',
            'address'  => 'Jl. Thamrin No. 5, Jakarta Pusat',
        ]);

        // Buat Kategori
        $categories = [
            ['name' => 'Laptops', 'slug' => 'laptops'],
            ['name' => 'Smartphones', 'slug' => 'smartphones'],
            ['name' => 'Audio', 'slug' => 'audio'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // Buat Produk
        $productsData = [
            [
                'category_id'    => 1, // Laptops
                'name'           => 'MacBook Pro M3 Max 14-inch',
                'description'    => 'Laptop super bertenaga untuk para profesional. Chip M3 Max memberikan performa luar biasa untuk rendering 3D, editing video 8K, dan coding.',
                'specifications' => "Chip: Apple M3 Max 14-core CPU, 30-core GPU\nRAM: 36GB Unified Memory\nStorage: 1TB SSD\nLayar: 14.2-inch Liquid Retina XDR display",
                'price'          => 45000000,
                'original_price' => 48000000,
                'stock'          => 10,
                'brand'          => 'Apple',
                'is_featured'    => true,
                'rating'         => 4.9,
                'review_count'   => 124,
                'image'          => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'category_id'    => 1, // Laptops
                'name'           => 'ASUS ROG Zephyrus G14',
                'description'    => 'Laptop gaming tipis dan ringan dengan performa luar biasa. Dilengkapi dengan prosesor AMD Ryzen 9 dan GPU NVIDIA RTX 4070.',
                'specifications' => "Prosesor: AMD Ryzen 9 7940HS\nGPU: NVIDIA GeForce RTX 4070 8GB GDDR6\nRAM: 16GB DDR5\nStorage: 1TB PCIe 4.0 NVMe M.2 SSD\nLayar: 14-inch QHD+ 165Hz Nebula Display",
                'price'          => 32999000,
                'original_price' => 34999000,
                'stock'          => 15,
                'brand'          => 'ASUS',
                'is_featured'    => true,
                'rating'         => 4.8,
                'review_count'   => 85,
                'image'          => 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'category_id'    => 1, // Laptops
                'name'           => 'Dell XPS 15 9530',
                'description'    => 'Desain premium dengan layar OLED yang memukau. Cocok untuk kreator konten dan profesional yang membutuhkan performa tinggi.',
                'specifications' => "Prosesor: Intel Core i7-13700H\nGPU: NVIDIA GeForce RTX 4050\nRAM: 16GB DDR5\nStorage: 512GB M.2 PCIe NVMe\nLayar: 15.6-inch 3.5K OLED Touch",
                'price'          => 35500000,
                'original_price' => null,
                'stock'          => 8,
                'brand'          => 'Dell',
                'is_featured'    => false,
                'rating'         => 4.7,
                'review_count'   => 56,
                'image'          => 'https://images.unsplash.com/photo-1593642702821-c8f0c4bb2f2c?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'category_id'    => 2, // Smartphones
                'name'           => 'Samsung Galaxy S24 Ultra',
                'description'    => 'Smartphone flagship dengan fitur Galaxy AI. Dilengkapi dengan material titanium dan kamera 200MP untuk hasil foto malam hari yang sempurna.',
                'specifications' => "Layar: 6.8-inch Dynamic LTPO AMOLED 2X\nProsesor: Snapdragon 8 Gen 3\nRAM: 12GB\nStorage: 512GB\nKamera: 200MP (wide), 50MP (telephoto)",
                'price'          => 21999000,
                'original_price' => 23999000,
                'stock'          => 15,
                'brand'          => 'Samsung',
                'is_featured'    => true,
                'rating'         => 4.8,
                'review_count'   => 89,
                'image'          => 'https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'category_id'    => 2, // Smartphones
                'name'           => 'iPhone 15 Pro Max',
                'description'    => 'iPhone pertama berbahan titanium dengan chip A17 Pro yang revolusioner. Action button baru dan kamera yang ditingkatkan.',
                'specifications' => "Layar: 6.7-inch Super Retina XDR OLED\nProsesor: Apple A17 Pro (3 nm)\nRAM: 8GB\nStorage: 256GB\nKamera: 48MP (wide), 12MP (periscope telephoto)",
                'price'          => 24999000,
                'original_price' => null,
                'stock'          => 25,
                'brand'          => 'Apple',
                'is_featured'    => true,
                'rating'         => 4.9,
                'review_count'   => 215,
                'image'          => 'https://images.unsplash.com/photo-1696446701796-da61225697cc?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'category_id'    => 2, // Smartphones
                'name'           => 'Google Pixel 8 Pro',
                'description'    => 'Smartphone Android terbaik dengan pengalaman kamera dan AI murni dari Google.',
                'specifications' => "Layar: 6.7-inch LTPO OLED\nProsesor: Google Tensor G3\nRAM: 12GB\nStorage: 128GB\nKamera: 50MP (wide), 48MP (telephoto)",
                'price'          => 15500000,
                'original_price' => 16500000,
                'stock'          => 12,
                'brand'          => 'Google',
                'is_featured'    => false,
                'rating'         => 4.6,
                'review_count'   => 67,
                'image'          => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'category_id'    => 3, // Audio
                'name'           => 'Sony WH-1000XM5 Wireless Headphones',
                'description'    => 'Headphone noise-canceling terbaik dari Sony. Desain baru yang lebih ringan dan nyaman dipakai seharian.',
                'specifications' => "Tipe: Over-ear, Wireless\nNoise Canceling: Ya, dengan Auto NC Optimizer\nBaterai: Hingga 30 jam\nBluetooth: 5.2",
                'price'          => 5499000,
                'original_price' => null,
                'stock'          => 20,
                'brand'          => 'Sony',
                'is_featured'    => true,
                'rating'         => 4.7,
                'review_count'   => 210,
                'image'          => 'https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'category_id'    => 3, // Audio
                'name'           => 'AirPods Pro (2nd generation)',
                'description'    => 'Pengalaman audio imersif dengan Active Noise Cancellation yang 2x lebih kuat. Adaptive Transparency untuk mendengar lingkungan sekitar.',
                'specifications' => "Tipe: In-ear, Wireless\nChip: Apple H2 headphone chip\nBaterai: Hingga 6 jam (dengan ANC aktif)\nKonektivitas: Bluetooth 5.3",
                'price'          => 3999000,
                'original_price' => 4299000,
                'stock'          => 50,
                'brand'          => 'Apple',
                'is_featured'    => false,
                'rating'         => 4.8,
                'review_count'   => 340,
                'image'          => 'https://images.unsplash.com/photo-1600294037681-c80b4cb5b434?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'category_id'    => 4, // Accessories
                'name'           => 'Logitech MX Master 3S',
                'description'    => 'Mouse produktivitas nirkabel terbaik. Klik senyap dan sensor 8000 DPI untuk pelacakan yang presisi di semua permukaan.',
                'specifications' => "Sensor: 8000 DPI Darkfield\nTombol: 7 tombol yang dapat dikustomisasi\nScroll Wheel: MagSpeed Electromagnetic\nBaterai: Hingga 70 hari",
                'price'          => 1650000,
                'original_price' => 1850000,
                'stock'          => 30,
                'brand'          => 'Logitech',
                'is_featured'    => true,
                'rating'         => 4.8,
                'review_count'   => 450,
                'image'          => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&q=80&w=1000'
            ],
            [
                'category_id'    => 4, // Accessories
                'name'           => 'Keychron Q1 Pro',
                'description'    => 'Keyboard mekanikal kustom nirkabel premium. Desain full aluminum dengan gasket mount untuk pengalaman mengetik terbaik.',
                'specifications' => "Layout: 75%\nMaterial: Full CNC aluminum\nKonektivitas: Bluetooth 5.1 & Type-C wired\nBaterai: 4000 mAh",
                'price'          => 3150000,
                'original_price' => null,
                'stock'          => 18,
                'brand'          => 'Keychron',
                'is_featured'    => false,
                'rating'         => 4.9,
                'review_count'   => 85,
                'image'          => 'https://images.unsplash.com/photo-1595225476474-87563907a212?auto=format&fit=crop&q=80&w=1000'
            ],
        ];

        $createdProducts = [];
        foreach ($productsData as $prod) {
            $prod['slug'] = Str::slug($prod['name']) . '-' . Str::random(4);
            $createdProducts[] = Product::create($prod);
        }

        // Buat Dummy Orders
        $order1 = Order::create([
            'user_id' => $customer1->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'subtotal' => 45000000 + 1650000,
            'shipping_cost' => 50000,
            'total' => 45000000 + 1650000 + 50000,
            'status' => 'delivered',
            'payment_method' => 'transfer',
            'payment_status' => 'paid',
            'shipping_name' => $customer1->name,
            'shipping_phone' => $customer1->phone,
            'shipping_address' => $customer1->address,
            'shipping_city' => 'Jakarta Selatan',
            'shipping_province' => 'DKI Jakarta',
            'shipping_postal_code' => '12190',
            'notes' => 'Tolong dipacking kayu ya.',
            'created_at' => Carbon::now()->subDays(5)
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $createdProducts[0]->id, // MacBook Pro
            'product_name' => $createdProducts[0]->name,
            'product_price' => $createdProducts[0]->price,
            'quantity' => 1,
            'subtotal' => $createdProducts[0]->price
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $createdProducts[8]->id, // Logitech MX Master
            'product_name' => $createdProducts[8]->name,
            'product_price' => $createdProducts[8]->price,
            'quantity' => 1,
            'subtotal' => $createdProducts[8]->price
        ]);


        $order2 = Order::create([
            'user_id' => $customer2->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'subtotal' => 24999000,
            'shipping_cost' => 25000,
            'total' => 24999000 + 25000,
            'status' => 'processing',
            'payment_method' => 'credit_card',
            'payment_status' => 'paid',
            'shipping_name' => $customer2->name,
            'shipping_phone' => $customer2->phone,
            'shipping_address' => $customer2->address,
            'shipping_city' => 'Jakarta Pusat',
            'shipping_province' => 'DKI Jakarta',
            'shipping_postal_code' => '10310',
            'notes' => null,
            'created_at' => Carbon::now()->subDays(1)
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $createdProducts[4]->id, // iPhone 15 Pro Max
            'product_name' => $createdProducts[4]->name,
            'product_price' => $createdProducts[4]->price,
            'quantity' => 1,
            'subtotal' => $createdProducts[4]->price
        ]);

        $order3 = Order::create([
            'user_id' => $customer1->id,
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'subtotal' => 5499000,
            'shipping_cost' => 30000,
            'total' => 5499000 + 30000,
            'status' => 'pending',
            'payment_method' => 'transfer',
            'payment_status' => 'unpaid',
            'shipping_name' => $customer1->name,
            'shipping_phone' => $customer1->phone,
            'shipping_address' => $customer1->address,
            'shipping_city' => 'Jakarta Selatan',
            'shipping_province' => 'DKI Jakarta',
            'shipping_postal_code' => '12190',
            'notes' => null,
            'created_at' => Carbon::now()
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'product_id' => $createdProducts[6]->id, // Sony WH-1000XM5
            'product_name' => $createdProducts[6]->name,
            'product_price' => $createdProducts[6]->price,
            'quantity' => 1,
            'subtotal' => $createdProducts[6]->price
        ]);
    }
}

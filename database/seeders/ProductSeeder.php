<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get brands
        $bosch = Brand::where('slug', 'bosch')->first();
        $varta = Brand::where('slug', 'varta')->first();
        $exide = Brand::where('slug', 'exide')->first();
        $optima = Brand::where('slug', 'optima')->first();
        $odyssey = Brand::where('slug', 'odyssey')->first();
        $acdelco = Brand::where('slug', 'acdelco')->first();
        $diehard = Brand::where('slug', 'diehard')->first();
        $interstate = Brand::where('slug', 'interstate')->first();
        $banner = Brand::where('slug', 'banner')->first();
        $moll = Brand::where('slug', 'moll')->first();
        $tudor = Brand::where('slug', 'tudor')->first();
        $centra = Brand::where('slug', 'centra')->first();
        $fiamm = Brand::where('slug', 'fiamm')->first();
        $yuasa = Brand::where('slug', 'yuasa')->first();

        // Get categories
        $standardFlooded = Category::where('slug', 'standard-flooded')->first();
        $agmCar = Category::where('slug', 'agm-car')->first();
        $efb = Category::where('slug', 'efb')->first();
        $lithiumCar = Category::where('slug', 'lithium-car')->first();
        $group31 = Category::where('slug', 'group-31')->first();
        $deepCycle = Category::where('slug', 'deep-cycle')->first();
        $dualPurpose = Category::where('slug', 'dual-purpose')->first();
        $agmMarine = Category::where('slug', 'agm-marine')->first();
        $lithiumMarine = Category::where('slug', 'lithium-marine')->first();

        $products = [
            // Bosch Car Batteries
            [
                'brand_id' => $bosch->id,
                'category_id' => $standardFlooded->id,
                'name' => 'Bosch S4 001 Silver Battery',
                'slug' => 'bosch-s4-001-silver',
                'sku' => 'BOS-S4-001',
                'short_description' => 'Reliable starting power for everyday driving',
                'description' => 'The Bosch S4 Silver series delivers dependable starting power for standard vehicle applications. Designed with advanced grid technology for longer life and better corrosion resistance.',
                'price' => 129.99,
                'sale_price' => 119.99,
                'stock_quantity' => 25,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/bosch-s4-001.jpg',
                'seo' => ['meta_title' => 'Bosch S4 001 Silver Car Battery', 'meta_description' => 'Buy Bosch S4 001 Silver battery online. 36 month warranty. Fast shipping.'],
            ],
            [
                'brand_id' => $bosch->id,
                'category_id' => $agmCar->id,
                'name' => 'Bosch S5 AGM Battery',
                'slug' => 'bosch-s5-agm',
                'sku' => 'BOS-S5-AGM',
                'short_description' => 'Premium AGM for start-stop vehicles',
                'description' => 'The Bosch S5 AGM is engineered for vehicles with start-stop systems and high electrical demands. Absorbent Glass Mat technology provides superior cycling capability and vibration resistance.',
                'price' => 249.99,
                'sale_price' => 229.99,
                'stock_quantity' => 15,
                'warranty' => '48 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/bosch-s5-agm.jpg',
                'seo' => ['meta_title' => 'Bosch S5 AGM Start-Stop Battery', 'meta_description' => 'Bosch S5 AGM battery for start-stop vehicles. 48 month warranty.'],
            ],
            [
                'brand_id' => $bosch->id,
                'category_id' => $efb->id,
                'name' => 'Bosch S4 EFB Battery',
                'slug' => 'bosch-s4-efb',
                'sku' => 'BOS-S4-EFB',
                'short_description' => 'Enhanced flooded battery for start-stop',
                'description' => 'Bosch S4 EFB offers improved charge acceptance and cyclic durability compared to standard flooded batteries. Ideal for vehicles with basic start-stop functionality.',
                'price' => 179.99,
                'sale_price' => 169.99,
                'stock_quantity' => 20,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/bosch-s4-efb.jpg',
                'seo' => ['meta_title' => 'Bosch S4 EFB Start-Stop Battery', 'meta_description' => 'Bosch S4 EFB enhanced flooded battery. 36 month warranty.'],
            ],

            // Varta Car Batteries
            [
                'brand_id' => $varta->id,
                'category_id' => $standardFlooded->id,
                'name' => 'Varta Blue Dynamic',
                'slug' => 'varta-blue-dynamic',
                'sku' => 'VAR-BLUE-DYN',
                'short_description' => 'European quality for everyday reliability',
                'description' => 'Varta Blue Dynamic batteries provide reliable starting power with PowerFrame grid technology for improved durability and corrosion resistance.',
                'price' => 119.99,
                'sale_price' => 109.99,
                'stock_quantity' => 30,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/varta-blue-dynamic.jpg',
                'seo' => ['meta_title' => 'Varta Blue Dynamic Car Battery', 'meta_description' => 'Varta Blue Dynamic battery with PowerFrame technology. 36 month warranty.'],
            ],
            [
                'brand_id' => $varta->id,
                'category_id' => $agmCar->id,
                'name' => 'Varta Silver Dynamic AGM',
                'slug' => 'varta-silver-dynamic-agm',
                'sku' => 'VAR-SILVER-AGM',
                'short_description' => 'Top-tier AGM for demanding vehicles',
                'description' => 'Varta Silver Dynamic AGM delivers maximum performance for vehicles with advanced start-stop systems and regenerative braking. 3x cycle life vs conventional batteries.',
                'price' => 279.99,
                'sale_price' => 259.99,
                'stock_quantity' => 12,
                'warranty' => '48 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/varta-silver-agm.jpg',
                'seo' => ['meta_title' => 'Varta Silver Dynamic AGM Battery', 'meta_description' => 'Varta Silver Dynamic AGM for start-stop vehicles. 48 month warranty.'],
            ],

            // Exide Car Batteries
            [
                'brand_id' => $exide->id,
                'category_id' => $standardFlooded->id,
                'name' => 'Exide Premium',
                'slug' => 'exide-premium',
                'sku' => 'EXI-PREMIUM',
                'short_description' => 'OE quality replacement battery',
                'description' => 'Exide Premium batteries are designed to meet or exceed OE specifications. Features advanced calcium-calcium technology for maintenance-free operation.',
                'price' => 109.99,
                'sale_price' => 99.99,
                'stock_quantity' => 35,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/exide-premium.jpg',
                'seo' => ['meta_title' => 'Exide Premium Car Battery', 'meta_description' => 'Exide Premium OE quality battery. 36 month warranty.'],
            ],
            [
                'brand_id' => $exide->id,
                'category_id' => $agmCar->id,
                'name' => 'Exide AGM',
                'slug' => 'exide-agm',
                'sku' => 'EXI-AGM',
                'short_description' => 'AGM technology for modern vehicles',
                'description' => 'Exide AGM batteries provide superior starting power and deep cycle capability. Ideal for vehicles with high electrical loads and start-stop systems.',
                'price' => 219.99,
                'sale_price' => 199.99,
                'stock_quantity' => 18,
                'warranty' => '48 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/exide-agm.jpg',
                'seo' => ['meta_title' => 'Exide AGM Car Battery', 'meta_description' => 'Exide AGM battery for start-stop vehicles. 48 month warranty.'],
            ],

            // Optima Batteries
            [
                'brand_id' => $optima->id,
                'category_id' => $agmCar->id,
                'name' => 'Optima RedTop 34/78',
                'slug' => 'optima-redtop-34-78',
                'sku' => 'OPT-RED-34-78',
                'short_description' => 'High-performance starting battery',
                'description' => 'The Optima RedTop uses SPIRALCELL TECHNOLOGY with 99.99% pure lead plates. Provides strong 5-second starting burst and 2x longer life than conventional batteries.',
                'price' => 289.99,
                'sale_price' => 269.99,
                'stock_quantity' => 10,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/optima-redtop.jpg',
                'seo' => ['meta_title' => 'Optima RedTop 34/78 Battery', 'meta_description' => 'Optima RedTop high-performance AGM battery. SPIRALCELL technology.'],
            ],
            [
                'brand_id' => $optima->id,
                'category_id' => $dualPurpose->id,
                'name' => 'Optima YellowTop D34/78',
                'slug' => 'optima-yellowtop-d34-78',
                'sku' => 'OPT-YEL-D34-78',
                'short_description' => 'Dual-purpose deep cycle and starting',
                'description' => 'Optima YellowTop delivers both cranking power and deep cycling ability. Perfect for vehicles with high accessory loads like winches, audio systems, and off-road lighting.',
                'price' => 319.99,
                'sale_price' => 299.99,
                'stock_quantity' => 8,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/optima-yellowtop.jpg',
                'seo' => ['meta_title' => 'Optima YellowTop D34/78 Battery', 'meta_description' => 'Optima YellowTop dual-purpose AGM battery. Deep cycle + starting.'],
            ],
            [
                'brand_id' => $optima->id,
                'category_id' => $deepCycle->id,
                'name' => 'Optima BlueTop D27M',
                'slug' => 'optima-bluetop-d27m',
                'sku' => 'OPT-BLU-D27M',
                'short_description' => 'Marine deep cycle AGM battery',
                'description' => 'Optima BlueTop D27M is a dual-purpose marine battery with deep cycle capability. SPIRALCELL technology provides vibration resistance 15x better than conventional batteries.',
                'price' => 339.99,
                'sale_price' => 319.99,
                'stock_quantity' => 6,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/optima-bluetop.jpg',
                'seo' => ['meta_title' => 'Optima BlueTop D27M Marine Battery', 'meta_description' => 'Optima BlueTop marine AGM battery. Deep cycle + starting. 15x vibration resistance.'],
            ],

            // Odyssey Batteries
            [
                'brand_id' => $odyssey->id,
                'category_id' => $agmCar->id,
                'name' => 'Odyssey PC680',
                'slug' => 'odyssey-pc680',
                'sku' => 'ODY-PC680',
                'short_description' => 'Extreme power in compact size',
                'description' => 'Odyssey PC680 uses pure lead plates for maximum surface area. Delivers 170 CCA in a compact package. 3-10 year service life. 400 cycles at 80% DOD.',
                'price' => 199.99,
                'sale_price' => 179.99,
                'stock_quantity' => 14,
                'warranty' => '48 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/odyssey-pc680.jpg',
                'seo' => ['meta_title' => 'Odyssey PC680 Battery', 'meta_description' => 'Odyssey PC680 extreme AGM battery. 170 CCA. 48 month warranty.'],
            ],
            [
                'brand_id' => $odyssey->id,
                'category_id' => $group31->id,
                'name' => 'Odyssey 31-PC2150S',
                'slug' => 'odyssey-31-pc2150s',
                'sku' => 'ODY-31-PC2150',
                'short_description' => 'Heavy-duty Group 31 commercial battery',
                'description' => 'Odyssey 31-PC2150S delivers 1150 CCA and 205 Ah capacity. Pure lead AGM design for extreme conditions. 400 cycles at 80% DOD. Ideal for commercial fleets.',
                'price' => 449.99,
                'sale_price' => 419.99,
                'stock_quantity' => 5,
                'warranty' => '48 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/odyssey-31-pc2150.jpg',
                'seo' => ['meta_title' => 'Odyssey 31-PC2150S Group 31 Battery', 'meta_description' => 'Odyssey Group 31 commercial AGM. 1150 CCA. 48 month warranty.'],
            ],

            // ACDelco
            [
                'brand_id' => $acdelco->id,
                'category_id' => $standardFlooded->id,
                'name' => 'ACDelco Gold 48AGM',
                'slug' => 'acdelco-gold-48agm',
                'sku' => 'ACD-GOLD-48AGM',
                'short_description' => 'OE spec AGM for GM vehicles',
                'description' => 'ACDelco Gold 48AGM is the original equipment battery for many GM vehicles. High density negative paste for improved performance. Calcium lead positive grid.',
                'price' => 239.99,
                'sale_price' => 219.99,
                'stock_quantity' => 22,
                'warranty' => '42 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/acdelco-gold-48agm.jpg',
                'seo' => ['meta_title' => 'ACDelco Gold 48AGM Battery', 'meta_description' => 'ACDelco Gold 48AGM OE replacement. 42 month warranty.'],
            ],
            [
                'brand_id' => $acdelco->id,
                'category_id' => $standardFlooded->id,
                'name' => 'ACDelco Silver 65AGM',
                'slug' => 'acdelco-silver-65agm',
                'sku' => 'ACD-SIL-65AGM',
                'short_description' => 'Quality AGM at value price',
                'description' => 'ACDelco Silver 65AGM provides reliable starting power with AGM technology. Maintenance-free design with pressurized valve system.',
                'price' => 189.99,
                'sale_price' => 169.99,
                'stock_quantity' => 28,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/acdelco-silver-65agm.jpg',
                'seo' => ['meta_title' => 'ACDelco Silver 65AGM Battery', 'meta_description' => 'ACDelco Silver 65AGM battery. 36 month warranty.'],
            ],

            // DieHard
            [
                'brand_id' => $diehard->id,
                'category_id' => $standardFlooded->id,
                'name' => 'DieHard Gold 35',
                'slug' => 'diehard-gold-35',
                'sku' => 'DIE-GOLD-35',
                'short_description' => 'Legendary reliability for daily driving',
                'description' => 'DieHard Gold batteries feature Stamped Grid Technology for improved durability and 2x corrosion resistance. Designed for reliable starts in all climates.',
                'price' => 149.99,
                'sale_price' => 134.99,
                'stock_quantity' => 20,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/diehard-gold-35.jpg',
                'seo' => ['meta_title' => 'DieHard Gold 35 Battery', 'meta_description' => 'DieHard Gold 35 battery with Stamped Grid Technology. 36 month warranty.'],
            ],
            [
                'brand_id' => $diehard->id,
                'category_id' => $agmCar->id,
                'name' => 'DieHard Platinum AGM',
                'slug' => 'diehard-platinum-agm',
                'sku' => 'DIE-PLAT-AGM',
                'short_description' => 'Premium AGM for maximum power',
                'description' => 'DieHard Platinum AGM delivers 2x the cycle life of conventional batteries. Designed for vehicles with start-stop technology and high electrical demands.',
                'price' => 259.99,
                'sale_price' => 239.99,
                'stock_quantity' => 12,
                'warranty' => '48 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/diehard-platinum-agm.jpg',
                'seo' => ['meta_title' => 'DieHard Platinum AGM Battery', 'meta_description' => 'DieHard Platinum AGM for start-stop. 48 month warranty. 2x cycle life.'],
            ],

            // Interstate
            [
                'brand_id' => $interstate->id,
                'category_id' => $standardFlooded->id,
                'name' => 'Interstate MT-34',
                'slug' => 'interstate-mt-34',
                'sku' => 'INT-MT-34',
                'short_description' => 'America\'s #1 replacement battery',
                'description' => 'Interstate MT-34 provides dependable starting power with robust construction. Designed for long life in extreme temperatures. Maintenance-free.',
                'price' => 139.99,
                'sale_price' => 124.99,
                'stock_quantity' => 40,
                'warranty' => '30 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/interstate-mt-34.jpg',
                'seo' => ['meta_title' => 'Interstate MT-34 Battery', 'meta_description' => 'Interstate MT-34 car battery. America\'s #1 replacement. 30 month warranty.'],
            ],
            [
                'brand_id' => $interstate->id,
                'category_id' => $deepCycle->id,
                'name' => 'Interstate SRM-27',
                'slug' => 'interstate-srm-27',
                'sku' => 'INT-SRM-27',
                'short_description' => 'Deep cycle marine/RV battery',
                'description' => 'Interstate SRM-27 is a true deep cycle battery for marine and RV applications. Thick plates for repeated deep discharges. 105 Ah @ 20hr rate.',
                'price' => 179.99,
                'sale_price' => 159.99,
                'stock_quantity' => 15,
                'warranty' => '24 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/interstate-srm-27.jpg',
                'seo' => ['meta_title' => 'Interstate SRM-27 Deep Cycle Battery', 'meta_description' => 'Interstate SRM-27 marine/RV deep cycle. 105 Ah. 24 month warranty.'],
            ],
            [
                'brand_id' => $interstate->id,
                'category_id' => $group31->id,
                'name' => 'Interstate 31-MHD',
                'slug' => 'interstate-31-mhd',
                'sku' => 'INT-31-MHD',
                'short_description' => 'Commercial Group 31 battery',
                'description' => 'Interstate 31-MHD heavy-duty commercial battery. 950 CCA, 190 Ah reserve capacity. Built for fleet applications with vibration-resistant construction.',
                'price' => 299.99,
                'sale_price' => 279.99,
                'stock_quantity' => 8,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/interstate-31-mhd.jpg',
                'seo' => ['meta_title' => 'Interstate 31-MHD Group 31 Battery', 'meta_description' => 'Interstate 31-MHD commercial Group 31. 950 CCA. 36 month warranty.'],
            ],

            // Additional Marine/RV
            [
                'brand_id' => $varta->id,
                'category_id' => $agmMarine->id,
                'name' => 'Varta Marine AGM 105Ah',
                'slug' => 'varta-marine-agm-105',
                'sku' => 'VAR-MAR-AGM-105',
                'short_description' => 'AGM deep cycle for marine use',
                'description' => 'Varta Marine AGM 105Ah provides reliable deep cycle power for marine electronics, trolling motors, and house loads. Spill-proof, maintenance-free.',
                'price' => 289.99,
                'sale_price' => 269.99,
                'stock_quantity' => 10,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/varta-marine-agm.jpg',
                'seo' => ['meta_title' => 'Varta Marine AGM 105Ah Battery', 'meta_description' => 'Varta Marine AGM deep cycle 105Ah. Spill-proof. 36 month warranty.'],
            ],
            [
                'brand_id' => $bosch->id,
                'category_id' => $lithiumMarine->id,
                'name' => 'Bosch LiFePO4 100Ah Marine',
                'slug' => 'bosch-lifepo4-100ah-marine',
                'sku' => 'BOS-LFP-100-MAR',
                'short_description' => 'Lightweight lithium marine battery',
                'description' => 'Bosch LiFePO4 100Ah marine battery weighs 60% less than lead-acid. 3000+ cycles at 80% DOD. Built-in BMS. Perfect for trolling motors and house power.',
                'price' => 899.99,
                'sale_price' => 849.99,
                'stock_quantity' => 4,
                'warranty' => '84 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/bosch-lifepo4-marine.jpg',
                'seo' => ['meta_title' => 'Bosch LiFePO4 100Ah Marine Battery', 'meta_description' => 'Bosch LiFePO4 100Ah marine lithium. 3000+ cycles. 7-year warranty.'],
            ],
            
            // Banner (Austrian)
            [
                'brand_id' => $banner->id,
                'category_id' => $standardFlooded->id,
                'name' => 'Banner Starting Bull 48Ah',
                'slug' => 'banner-starting-bull-48',
                'sku' => 'BAN-SB-48',
                'short_description' => 'Austrian quality for everyday starting',
                'description' => 'Banner Starting Bull provides reliable starting power with calcium-calcium technology. Maintenance-free design with high cranking performance.',
                'price' => 109.99,
                'sale_price' => 99.99,
                'stock_quantity' => 30,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/banner-starting-bull.jpg',
                'seo' => ['meta_title' => 'Banner Starting Bull 48Ah', 'meta_description' => 'Banner Starting Bull calcium battery. Austrian quality. 36 month warranty.'],
            ],
            [
                'brand_id' => $banner->id,
                'category_id' => $agmCar->id,
                'name' => 'Banner Running Bull AGM',
                'slug' => 'banner-running-bull-agm',
                'sku' => 'BAN-RB-AGM',
                'short_description' => 'Premium AGM for start-stop systems',
                'description' => 'Banner Running Bull AGM is designed for vehicles with start-stop and regenerative braking. Excellent cycle stability and charge acceptance.',
                'price' => 239.99,
                'sale_price' => 219.99,
                'stock_quantity' => 15,
                'warranty' => '48 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/banner-running-bull-agm.jpg',
                'seo' => ['meta_title' => 'Banner Running Bull AGM', 'meta_description' => 'Banner Running Bull AGM for start-stop. 48 month warranty.'],
            ],
            [
                'brand_id' => $banner->id,
                'category_id' => $deepCycle->id,
                'name' => 'Banner Energy Bull 100Ah',
                'slug' => 'banner-energy-bull-100',
                'sku' => 'BAN-EB-100',
                'short_description' => 'Deep cycle for solar and marine',
                'description' => 'Banner Energy Bull is a deep cycle battery for solar systems, marine, and camping. High cycle life with robust plate construction.',
                'price' => 189.99,
                'sale_price' => 169.99,
                'stock_quantity' => 12,
                'warranty' => '24 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/banner-energy-bull.jpg',
                'seo' => ['meta_title' => 'Banner Energy Bull 100Ah Deep Cycle', 'meta_description' => 'Banner Energy Bull deep cycle 100Ah. Solar and marine use.'],
            ],

            // Moll (German)
            [
                'brand_id' => $moll->id,
                'category_id' => $standardFlooded->id,
                'name' => 'Moll 840 48Ah',
                'slug' => 'moll-840-48',
                'sku' => 'MOL-840-48',
                'short_description' => 'German precision engineering',
                'description' => 'Moll 840 series uses advanced grid technology for maximum starting power and long service life. German manufactured to highest standards.',
                'price' => 119.99,
                'sale_price' => 109.99,
                'stock_quantity' => 25,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/moll-840.jpg',
                'seo' => ['meta_title' => 'Moll 840 48Ah Battery', 'meta_description' => 'Moll 840 German battery. 36 month warranty.'],
            ],
            [
                'brand_id' => $moll->id,
                'category_id' => $agmCar->id,
                'name' => 'Moll AGM Start-Stop',
                'slug' => 'moll-agm-start-stop',
                'sku' => 'MOL-AGM-SS',
                'short_description' => 'AGM for modern vehicles',
                'description' => 'Moll AGM provides exceptional cold cranking performance and cycle life for vehicles with start-stop systems. Vibration resistant design.',
                'price' => 249.99,
                'sale_price' => 229.99,
                'stock_quantity' => 18,
                'warranty' => '48 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/moll-agm.jpg',
                'seo' => ['meta_title' => 'Moll AGM Start-Stop Battery', 'meta_description' => 'Moll AGM German start-stop battery. 48 month warranty.'],
            ],
            [
                'brand_id' => $moll->id,
                'category_id' => $efb->id,
                'name' => 'Moll EFB Enhanced',
                'slug' => 'moll-efb-enhanced',
                'sku' => 'MOL-EFB-ENH',
                'short_description' => 'Enhanced flooded for start-stop',
                'description' => 'Moll EFB offers improved charge acceptance over standard flooded batteries. Ideal for vehicles with basic start-stop functionality.',
                'price' => 169.99,
                'sale_price' => 154.99,
                'stock_quantity' => 20,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/moll-efb.jpg',
                'seo' => ['meta_title' => 'Moll EFB Enhanced Battery', 'meta_description' => 'Moll EFB enhanced flooded. German quality. 36 month warranty.'],
            ],

            // Tudor (Spanish)
            [
                'brand_id' => $tudor->id,
                'category_id' => $standardFlooded->id,
                'name' => 'Tudor Technica 55Ah',
                'slug' => 'tudor-technica-55',
                'sku' => 'TUD-TEC-55',
                'short_description' => 'Spanish battery specialist since 1895',
                'description' => 'Tudor Technica provides reliable starting power with advanced plate design. European manufactured with calcium-calcium technology.',
                'price' => 99.99,
                'sale_price' => 89.99,
                'stock_quantity' => 35,
                'warranty' => '30 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/tudor-technica.jpg',
                'seo' => ['meta_title' => 'Tudor Technica 55Ah', 'meta_description' => 'Tudor Technica Spanish battery. 30 month warranty.'],
            ],
            [
                'brand_id' => $tudor->id,
                'category_id' => $agmCar->id,
                'name' => 'Tudor AGM Professional',
                'slug' => 'tudor-agm-professional',
                'sku' => 'TUD-AGM-PRO',
                'short_description' => 'Professional AGM for high demands',
                'description' => 'Tudor AGM Professional delivers high cranking power and excellent cycle stability. Designed for vehicles with advanced start-stop and energy recovery.',
                'price' => 229.99,
                'sale_price' => 209.99,
                'stock_quantity' => 15,
                'warranty' => '48 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/tudor-agm.jpg',
                'seo' => ['meta_title' => 'Tudor AGM Professional', 'meta_description' => 'Tudor AGM Spanish battery. 48 month warranty.'],
            ],

            // Centra (European)
            [
                'brand_id' => $centra->id,
                'category_id' => $standardFlooded->id,
                'name' => 'Centra CB12-48',
                'slug' => 'centra-cb12-48',
                'sku' => 'CEN-CB12-48',
                'short_description' => 'European automotive battery',
                'description' => 'Centra CB series offers reliable performance for European vehicles. Maintenance-free with good cold cranking performance.',
                'price' => 89.99,
                'sale_price' => 79.99,
                'stock_quantity' => 40,
                'warranty' => '24 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/centra-cb12.jpg',
                'seo' => ['meta_title' => 'Centra CB12-48 Battery', 'meta_description' => 'Centra European battery. 24 month warranty.'],
            ],
            [
                'brand_id' => $centra->id,
                'category_id' => $deepCycle->id,
                'name' => 'Centra Deep Cycle 90Ah',
                'slug' => 'centra-deep-cycle-90',
                'sku' => 'CEN-DC-90',
                'short_description' => 'Deep cycle for leisure and solar',
                'description' => 'Centra Deep Cycle provides reliable power for caravans, boats, and solar systems. Thick plates for repeated deep discharges.',
                'price' => 149.99,
                'sale_price' => 134.99,
                'stock_quantity' => 18,
                'warranty' => '24 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/centra-deep-cycle.jpg',
                'seo' => ['meta_title' => 'Centra Deep Cycle 90Ah', 'meta_description' => 'Centra deep cycle 90Ah. Leisure and solar.'],
            ],

            // Fiamm (Italian)
            [
                'brand_id' => $fiamm->id,
                'category_id' => $standardFlooded->id,
                'name' => 'Fiamm Titanium 55Ah',
                'slug' => 'fiamm-titanium-55',
                'sku' => 'FIA-TI-55',
                'short_description' => 'Italian energy storage solutions',
                'description' => 'Fiamm Titanium uses advanced lead-calcium technology for maintenance-free operation. High starting power and corrosion resistance.',
                'price' => 104.99,
                'sale_price' => 94.99,
                'stock_quantity' => 28,
                'warranty' => '30 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/fiamm-titanium.jpg',
                'seo' => ['meta_title' => 'Fiamm Titanium 55Ah', 'meta_description' => 'Fiamm Italian battery. 30 month warranty.'],
            ],
            [
                'brand_id' => $fiamm->id,
                'category_id' => $agmCar->id,
                'name' => 'Fiamm AGM Start-Stop',
                'slug' => 'fiamm-agm-start-stop',
                'sku' => 'FIA-AGM-SS',
                'short_description' => 'Italian AGM for start-stop',
                'description' => 'Fiamm AGM provides excellent cold cranking and cycle life. Designed for European vehicles with start-stop and regenerative braking.',
                'price' => 219.99,
                'sale_price' => 199.99,
                'stock_quantity' => 14,
                'warranty' => '42 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/fiamm-agm.jpg',
                'seo' => ['meta_title' => 'Fiamm AGM Start-Stop', 'meta_description' => 'Fiamm AGM Italian battery. 42 month warranty.'],
            ],

            // Yuasa (Japanese-European)
            [
                'brand_id' => $yuasa->id,
                'category_id' => $standardFlooded->id,
                'name' => 'Yuasa YBX3000 48Ah',
                'slug' => 'yuasa-ybx3000-48',
                'sku' => 'YUA-YBX3-48',
                'short_description' => 'Powersport and automotive specialist',
                'description' => 'Yuasa YBX3000 provides reliable starting power with maintenance-free design. Trusted by OEMs worldwide for motorcycles and cars.',
                'price' => 114.99,
                'sale_price' => 104.99,
                'stock_quantity' => 22,
                'warranty' => '36 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/yuasa-ybx3000.jpg',
                'seo' => ['meta_title' => 'Yuasa YBX3000 48Ah', 'meta_description' => 'Yuasa battery for auto and powersports. 36 month warranty.'],
            ],
            [
                'brand_id' => $yuasa->id,
                'category_id' => $agmCar->id,
                'name' => 'Yuasa AGM 70Ah',
                'slug' => 'yuasa-agm-70',
                'sku' => 'YUA-AGM-70',
                'short_description' => 'Premium AGM for European vehicles',
                'description' => 'Yuasa AGM delivers exceptional performance for start-stop vehicles. High vibration resistance and fast recharge capability.',
                'price' => 259.99,
                'sale_price' => 239.99,
                'stock_quantity' => 12,
                'warranty' => '48 months',
                'is_active' => true,
                'is_featured' => true,
                'main_image' => 'products/yuasa-agm.jpg',
                'seo' => ['meta_title' => 'Yuasa AGM 70Ah', 'meta_description' => 'Yuasa AGM for start-stop. 48 month warranty.'],
            ],
            [
                'brand_id' => $yuasa->id,
                'category_id' => $dualPurpose->id,
                'name' => 'Yuasa YTX20HL-BS Powersport',
                'slug' => 'yuasa-ytx20hl-bs',
                'sku' => 'YUA-YTX20HL',
                'short_description' => 'Powersport AGM battery',
                'description' => 'Yuasa YTX20HL-BS is a high-performance AGM battery for motorcycles, ATVs, and personal watercraft. Factory activated, spill-proof.',
                'price' => 139.99,
                'sale_price' => 129.99,
                'stock_quantity' => 25,
                'warranty' => '24 months',
                'is_active' => true,
                'is_featured' => false,
                'main_image' => 'products/yuasa-ytx20hl.jpg',
                'seo' => ['meta_title' => 'Yuasa YTX20HL-BS Powersport', 'meta_description' => 'Yuasa powersport AGM. Motorcycle and ATV.'],
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create($productData);

            // Add attribute values for each product
            $this->addAttributeValues($product);
        }
    }

    private function addAttributeValues(Product $product): void
    {
        // Get attributes
        $voltageAttr = Attribute::where('slug', 'voltage')->first();
        $capacityAttr = Attribute::where('slug', 'capacity')->first();
        $ccaAttr = Attribute::where('slug', 'cca')->first();
        $reserveAttr = Attribute::where('slug', 'reserve_capacity')->first();
        $batteryTypeAttr = Attribute::where('slug', 'battery_type')->first();
        $groupSizeAttr = Attribute::where('slug', 'group_size')->first();
        $terminalAttr = Attribute::where('slug', 'terminal_type')->first();
        $polarityAttr = Attribute::where('slug', 'polarity')->first();
        $warrantyAttr = Attribute::where('slug', 'warranty_months')->first();
        $chemistryAttr = Attribute::where('slug', 'chemistry')->first();
        $makeAttr = Attribute::where('slug', 'make')->first();
        $yearAttr = Attribute::where('slug', 'year')->first();
        $modelAttr = Attribute::where('slug', 'model')->first();
        $engineAttr = Attribute::where('slug', 'engine')->first();

        // Vehicle compatibility data based on product
        $vehicleData = $this->getVehicleCompatibility($product->name);

        // Default values based on product category/name
        $values = [];

        if (str_contains($product->name, 'S4 001') || str_contains($product->name, 'Blue Dynamic') || str_contains($product->name, 'Premium') || str_contains($product->name, 'Gold 35') || str_contains($product->name, 'MT-34')) {
            // Standard flooded
            $values = [
                $voltageAttr->id => '12',
                $capacityAttr->id => '60',
                $ccaAttr->id => '550',
                $reserveAttr->id => '90',
                $batteryTypeAttr->id => 'Flooded',
                $groupSizeAttr->id => '48',
                $terminalAttr->id => 'Top Post',
                $polarityAttr->id => 'Standard (Positive Right)',
                $warrantyAttr->id => '36',
                $chemistryAttr->id => 'Lead-Acid',
            ];
        } elseif (str_contains($product->name, 'S5 AGM') || str_contains($product->name, 'Silver Dynamic AGM') || str_contains($product->name, 'Exide AGM') || str_contains($product->name, 'Platinum AGM') || str_contains($product->name, 'Gold 48AGM') || str_contains($product->name, 'Silver 65AGM')) {
            // AGM car
            $values = [
                $voltageAttr->id => '12',
                $capacityAttr->id => '70',
                $ccaAttr->id => '760',
                $reserveAttr->id => '120',
                $batteryTypeAttr->id => 'AGM',
                $groupSizeAttr->id => '48',
                $terminalAttr->id => 'Top Post',
                $polarityAttr->id => 'Standard (Positive Right)',
                $warrantyAttr->id => '48',
                $chemistryAttr->id => 'AGM',
            ];
        } elseif (str_contains($product->name, 'S4 EFB')) {
            // EFB
            $values = [
                $voltageAttr->id => '12',
                $capacityAttr->id => '65',
                $ccaAttr->id => '650',
                $reserveAttr->id => '100',
                $batteryTypeAttr->id => 'EFB',
                $groupSizeAttr->id => '48',
                $terminalAttr->id => 'Top Post',
                $polarityAttr->id => 'Standard (Positive Right)',
                $warrantyAttr->id => '36',
                $chemistryAttr->id => 'Lead-Acid',
            ];
        } elseif (str_contains($product->name, 'RedTop') || str_contains($product->name, 'YellowTop') || str_contains($product->name, 'BlueTop')) {
            // Optima
            $values = [
                $voltageAttr->id => '12',
                $capacityAttr->id => '55',
                $ccaAttr->id => '800',
                $reserveAttr->id => '100',
                $batteryTypeAttr->id => 'AGM',
                $groupSizeAttr->id => '34',
                $terminalAttr->id => 'Dual Terminal',
                $polarityAttr->id => 'Standard (Positive Right)',
                $warrantyAttr->id => '36',
                $chemistryAttr->id => 'AGM',
            ];
        } elseif (str_contains($product->name, 'PC680')) {
            // Odyssey PC680
            $values = [
                $voltageAttr->id => '12',
                $capacityAttr->id => '16',
                $ccaAttr->id => '170',
                $reserveAttr->id => '24',
                $batteryTypeAttr->id => 'AGM',
                $groupSizeAttr->id => '',
                $terminalAttr->id => 'Top Post',
                $polarityAttr->id => 'Standard (Positive Right)',
                $warrantyAttr->id => '48',
                $chemistryAttr->id => 'AGM',
            ];
        } elseif (str_contains($product->name, '31-PC2150')) {
            // Odyssey 31
            $values = [
                $voltageAttr->id => '12',
                $capacityAttr->id => '205',
                $ccaAttr->id => '1150',
                $reserveAttr->id => '205',
                $batteryTypeAttr->id => 'AGM',
                $groupSizeAttr->id => '31',
                $terminalAttr->id => 'Stud Terminal',
                $polarityAttr->id => 'Standard (Positive Right)',
                $warrantyAttr->id => '48',
                $chemistryAttr->id => 'AGM',
            ];
        } elseif (str_contains($product->name, 'SRM-27')) {
            // Interstate Deep Cycle
            $values = [
                $voltageAttr->id => '12',
                $capacityAttr->id => '105',
                $ccaAttr->id => '600',
                $reserveAttr->id => '160',
                $batteryTypeAttr->id => 'Flooded',
                $groupSizeAttr->id => '27',
                $terminalAttr->id => 'Dual Terminal',
                $polarityAttr->id => 'Standard (Positive Right)',
                $warrantyAttr->id => '24',
                $chemistryAttr->id => 'Lead-Acid',
            ];
        } elseif (str_contains($product->name, '31-MHD')) {
            // Interstate 31-MHD
            $values = [
                $voltageAttr->id => '12',
                $capacityAttr->id => '190',
                $ccaAttr->id => '950',
                $reserveAttr->id => '190',
                $batteryTypeAttr->id => 'Flooded',
                $groupSizeAttr->id => '31',
                $terminalAttr->id => 'Stud Terminal',
                $polarityAttr->id => 'Standard (Positive Right)',
                $warrantyAttr->id => '36',
                $chemistryAttr->id => 'Lead-Acid',
            ];
        } elseif (str_contains($product->name, 'Marine AGM 105')) {
            // Varta Marine AGM
            $values = [
                $voltageAttr->id => '12',
                $capacityAttr->id => '105',
                $ccaAttr->id => '800',
                $reserveAttr->id => '180',
                $batteryTypeAttr->id => 'AGM',
                $groupSizeAttr->id => '31',
                $terminalAttr->id => 'Dual Terminal',
                $polarityAttr->id => 'Standard (Positive Right)',
                $warrantyAttr->id => '36',
                $chemistryAttr->id => 'AGM',
            ];
        } elseif (str_contains($product->name, 'LiFePO4')) {
            // Bosch Lithium
            $values = [
                $voltageAttr->id => '12',
                $capacityAttr->id => '100',
                $ccaAttr->id => '1000',
                $reserveAttr->id => '200',
                $batteryTypeAttr->id => 'Lithium',
                $groupSizeAttr->id => '31',
                $terminalAttr->id => 'Stud Terminal',
                $polarityAttr->id => 'Standard (Positive Right)',
                $warrantyAttr->id => '84',
                $chemistryAttr->id => 'LiFePO4',
            ];
        }

        foreach ($values as $attributeId => $value) {
            if ($value) {
                ProductAttributeValue::create([
                    'product_id' => $product->id,
                    'attribute_id' => $attributeId,
                    'value' => $value,
                ]);
            }
        }

        // Add vehicle compatibility attributes
        if ($makeAttr && isset($vehicleData['make'])) {
            ProductAttributeValue::create([
                'product_id' => $product->id,
                'attribute_id' => $makeAttr->id,
                'value' => $vehicleData['make'],
            ]);
        }
        if ($yearAttr && isset($vehicleData['year'])) {
            ProductAttributeValue::create([
                'product_id' => $product->id,
                'attribute_id' => $yearAttr->id,
                'value' => $vehicleData['year'],
            ]);
        }
        if ($modelAttr && isset($vehicleData['model'])) {
            ProductAttributeValue::create([
                'product_id' => $product->id,
                'attribute_id' => $modelAttr->id,
                'value' => $vehicleData['model'],
            ]);
        }
        if ($engineAttr && isset($vehicleData['engine'])) {
            ProductAttributeValue::create([
                'product_id' => $product->id,
                'attribute_id' => $engineAttr->id,
                'value' => $vehicleData['engine'],
            ]);
        }
    }

    private function getVehicleCompatibility(string $productName): array
    {
        // Return sample vehicle compatibility data based on product name
        if (str_contains($productName, 'Bosch S4 001') || str_contains($productName, 'Blue Dynamic') || str_contains($productName, 'Premium') || str_contains($productName, 'Gold 35') || str_contains($productName, 'MT-34')) {
            return ['make' => 'Volkswagen', 'year' => '2018', 'model' => 'Golf', 'engine' => '1.4 TSI'];
        } elseif (str_contains($productName, 'S5 AGM') || str_contains($productName, 'Silver Dynamic AGM') || str_contains($productName, 'Exide AGM') || str_contains($productName, 'Platinum AGM') || str_contains($productName, 'Gold 48AGM') || str_contains($productName, 'Silver 65AGM')) {
            return ['make' => 'BMW', 'year' => '2020', 'model' => '3 Series', 'engine' => '2.0 TwinPower Turbo'];
        } elseif (str_contains($productName, 'S4 EFB')) {
            return ['make' => 'Ford', 'year' => '2019', 'model' => 'Focus', 'engine' => '1.0 EcoBoost'];
        } elseif (str_contains($productName, 'RedTop') || str_contains($productName, 'YellowTop') || str_contains($productName, 'BlueTop')) {
            return ['make' => 'Jeep', 'year' => '2021', 'model' => 'Wrangler', 'engine' => '3.6 Pentastar'];
        } elseif (str_contains($productName, 'PC680')) {
            return ['make' => 'Honda', 'year' => '2017', 'model' => 'Civic', 'engine' => '1.5 Turbo'];
        } elseif (str_contains($productName, '31-PC2150')) {
            return ['make' => 'Ford', 'year' => '2022', 'model' => 'F-150', 'engine' => '3.5 EcoBoost'];
        } elseif (str_contains($productName, 'SRM-27')) {
            return ['make' => 'Chevrolet', 'year' => '2019', 'model' => 'Silverado', 'engine' => '5.3 V8'];
        } elseif (str_contains($productName, '31-MHD')) {
            return ['make' => 'RAM', 'year' => '2020', 'model' => '1500', 'engine' => '5.7 HEMI'];
        } elseif (str_contains($productName, 'Marine AGM 105')) {
            return ['make' => 'Volvo Penta', 'year' => '2021', 'model' => 'D4', 'engine' => '3.0 Diesel'];
        } elseif (str_contains($productName, 'LiFePO4')) {
            return ['make' => 'Tesla', 'year' => '2022', 'model' => 'Model 3', 'engine' => 'Electric'];
        } elseif (str_contains($productName, 'Varta')) {
            return ['make' => 'Mercedes-Benz', 'year' => '2019', 'model' => 'C-Class', 'engine' => '2.0 Turbo'];
        } elseif (str_contains($productName, 'Exide')) {
            return ['make' => 'Audi', 'year' => '2020', 'model' => 'A4', 'engine' => '2.0 TFSI'];
        } elseif (str_contains($productName, 'Optima')) {
            return ['make' => 'Toyota', 'year' => '2021', 'model' => 'Camry', 'engine' => '2.5 Hybrid'];
        } elseif (str_contains($productName, 'Odyssey')) {
            return ['make' => 'Subaru', 'year' => '2018', 'model' => 'Outback', 'engine' => '2.5 Boxer'];
        } elseif (str_contains($productName, 'ACDelco')) {
            return ['make' => 'Chevrolet', 'year' => '2020', 'model' => 'Equinox', 'engine' => '1.5 Turbo'];
        } elseif (str_contains($productName, 'DieHard')) {
            return ['make' => 'Ford', 'year' => '2019', 'model' => 'Escape', 'engine' => '2.0 EcoBoost'];
        } elseif (str_contains($productName, 'Interstate')) {
            return ['make' => 'Honda', 'year' => '2021', 'model' => 'CR-V', 'engine' => '1.5 Turbo'];
        } elseif (str_contains($productName, 'Banner')) {
            return ['make' => 'Volkswagen', 'year' => '2020', 'model' => 'Passat', 'engine' => '2.0 TSI'];
        } elseif (str_contains($productName, 'Moll')) {
            return ['make' => 'BMW', 'year' => '2019', 'model' => 'X3', 'engine' => '2.0 TwinPower Turbo'];
        } elseif (str_contains($productName, 'Tudor')) {
            return ['make' => 'Renault', 'year' => '2021', 'model' => 'Clio', 'engine' => '1.0 TCe'];
        } elseif (str_contains($productName, 'Centra')) {
            return ['make' => 'Peugeot', 'year' => '2018', 'model' => '308', 'engine' => '1.2 PureTech'];
        } elseif (str_contains($productName, 'Fiamm')) {
            return ['make' => 'Fiat', 'year' => '2020', 'model' => '500', 'engine' => '1.0 Hybrid'];
        } elseif (str_contains($productName, 'Yuasa')) {
            return ['make' => 'Mazda', 'year' => '2021', 'model' => 'CX-5', 'engine' => '2.5 SkyActiv'];
        }

        return ['make' => 'Universal', 'year' => '2020', 'model' => 'Various', 'engine' => 'Various'];
    }
}

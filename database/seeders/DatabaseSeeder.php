<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Game;
use App\Models\Account;
use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Users (Admin & regular User)
        $admin = User::create([
            'name' => 'Quản Trị Viên (Admin)',
            'email' => 'admin@gameshop.com',
            'password' => Hash::make('adminpassword'),
            'role' => 'admin',
            'balance' => 10000000, // 10,000,000đ
        ]);

        $user = User::create([
            'name' => 'Khách Hàng Trải Nghiệm',
            'email' => 'user@gameshop.com',
            'password' => Hash::make('userpassword'),
            'role' => 'user',
            'balance' => 2500000, // 2,500,000đ
        ]);

        // 2. Create Game Categories
        $lol = Game::create([
            'name' => 'Liên Minh Huyền Thoại',
            'slug' => 'lien-minh-huyen-thoai',
            'image' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=600',
            'description' => 'Shop acc Liên Minh Huyền Thoại (LOL) uy tín, giá rẻ. Đầy đủ các mức rank, nhiều skin tuyệt phẩm, thần thoại và full tướng thả ga chiến game.',
        ]);

        $valorant = Game::create([
            'name' => 'Valorant',
            'slug' => 'valorant',
            'image' => 'https://images.unsplash.com/photo-1624138784614-87fd1b6528f8?q=80&w=600',
            'description' => 'Shop acc Valorant cực chất. Rank cao ngút ngàn Bạch Kim, Kim Cương, Immortal. Sở hữu súng nâng cấp Kuronami, Reaver, Prime hiệu ứng đỉnh chóp.',
        ]);

        $ff = Game::create([
            'name' => 'Free Fire',
            'slug' => 'free-fire',
            'image' => 'https://images.unsplash.com/photo-1589241062272-c0a000072dfa?q=80&w=600',
            'description' => 'Cửa hàng mua bán nick Free Fire uy tín. Đầy đủ trang phục súng nâng cấp huyền thoại như AK Rồng Xanh, M1014 Tiếng Hét và vô vàn hành động chất lừ.',
        ]);

        $genshin = Game::create([
            'name' => 'Genshin Impact',
            'slug' => 'genshin-impact',
            'image' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?q=80&w=600',
            'description' => 'Shop acc Genshin Impact VIP. Tài khoản AR cao, sở hữu cực nhiều nhân vật 5 sao Raiden Shogun, Nahida, Furina cùng vũ khí trấn tinh luyện khủng.',
        ]);

        // 3. Create Accounts
        // --- LOL Accounts ---
        Account::create([
            'game_id' => $lol->id,
            'title' => 'Acc LOL Siêu VIP - 250 Skins - Full Tướng - Rank Cao Thủ bền vững',
            'price' => 1250000,
            'rank' => 'Cao Thủ',
            'status' => 'available',
            'images' => [
                'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=800',
                'https://images.unsplash.com/photo-1511512578047-dfb367046420?q=80&w=800',
                'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?q=80&w=800'
            ],
            'description' => "Tài khoản Liên Minh Huyền Thoại cực xịn, sở hữu 250 skin đầy đủ các dòng tuyệt phẩm, tối thượng và thần thoại.\n- Rank hiện tại: Cao Thủ mùa giải hiện tại bền vững.\n- Số tướng: Full tướng, dư 50k Tinh Hoa Lam thoải mái đổi tên.\n- Skin Hot: Yasuo Ma Kiếm, Lux Thập Đại Nguyên Tố, Lee Sin Tuyệt Vô Thần.\n- Bảo hành vĩnh viễn 100% không lo tranh chấp.",
            'login_details' => 'admin_lol_supervip | pass_lol123456',
            'is_featured' => true
        ]);

        Account::create([
            'game_id' => $lol->id,
            'title' => 'Acc LOL Khá - 65 Skins đẹp - Rank Kim Cương IV - Đủ tướng leo rank',
            'price' => 320000,
            'rank' => 'Kim Cương IV',
            'status' => 'available',
            'images' => [
                'https://images.unsplash.com/photo-1511512578047-dfb367046420?q=80&w=800',
                'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?q=80&w=800'
            ],
            'description' => "Acc thích hợp leo rank trung cấp cho game thủ cứng.\n- Rank hiện tại: Kim Cương IV.\n- Số skin: 65 trang phục đa dạng.\n- Tướng: Hơn 120 tướng thông dụng.\n- Giao dịch tự động bàn giao ngay lập tức.",
            'login_details' => 'lol_midlevel_01 | passmid123',
            'is_featured' => false
        ]);

        Account::create([
            'game_id' => $lol->id,
            'title' => 'Acc Lol Smurf Rank Vàng I - Giá Hạt Dẻ Học Sinh Sinh Viên',
            'price' => 89000,
            'rank' => 'Vàng I',
            'status' => 'available',
            'images' => [
                'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?q=80&w=800'
            ],
            'description' => "Acc thích hợp smurf giải trí cùng bạn bè ngày cuối tuần.\n- Rank hiện tại: Vàng I.\n- Tinh hoa lam dư dả, giao dịch bảo mật an toàn.",
            'login_details' => 'lol_smurf_gold | passsmurf99',
            'is_featured' => false
        ]);

        // --- Valorant Accounts ---
        Account::create([
            'game_id' => $valorant->id,
            'title' => 'Acc Valorant Siêu Phẩm - Kuronami Vandal, Elderflame Dagger - Rank Immortal III',
            'price' => 2200000,
            'rank' => 'Immortal III',
            'status' => 'available',
            'images' => [
                'https://images.unsplash.com/photo-1624138784614-87fd1b6528f8?q=80&w=800',
                'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=800',
                'https://images.unsplash.com/photo-1511512578047-dfb367046420?q=80&w=800'
            ],
            'description' => "Siêu phẩm Valorant rank Immortal III cực chất cho dân tryhard.\n- Skin súng: Kuronami Vandal (Full nâng cấp hiệu ứng), Elderflame Dagger (Dao rồng lửa huyền thoại), Prime Specter.\n- Đặc vụ: Full đặc vụ, mở khóa toàn bộ.\n- Rank: Immortal III bền vững.\n- Sẵn sàng bàn giao tự động sau 1s click mua.",
            'login_details' => 'val_immortal_reaver | passval78900',
            'is_featured' => true
        ]);

        Account::create([
            'game_id' => $valorant->id,
            'title' => 'Acc Valorant Giá Rẻ - Prime Vandal Cực Mượt - Rank Bạch Kim II',
            'price' => 450000,
            'rank' => 'Bạch Kim II',
            'status' => 'available',
            'images' => [
                'https://images.unsplash.com/photo-1542751371-adc38448a05e?q=80&w=800'
            ],
            'description' => "Tài khoản Valorant tầm trung siêu đẹp.\n- Skin súng: Prime Vandal huyền thoại bắn siêu đầm tay.\n- Rank hiện tại: Bạch Kim II cực đẹp leo rank mượt.\n- Đầy đủ thông tin, bảo hành 100% đổi trả nếu lỗi.",
            'login_details' => 'val_plat_kuro | passkuro111',
            'is_featured' => false
        ]);

        // --- Free Fire Accounts ---
        Account::create([
            'game_id' => $ff->id,
            'title' => 'Acc Free Fire Cực Khủng - Quỷ Kiếm Dạ Xoa, M1014 Tiếng Hét Cấp Max - Rank Thách Đấu',
            'price' => 1750000,
            'rank' => 'Thách Đấu',
            'status' => 'available',
            'images' => [
                'https://images.unsplash.com/photo-1589241062272-c0a000072dfa?q=80&w=800',
                'https://images.unsplash.com/photo-1511512578047-dfb367046420?q=80&w=800'
            ],
            'description' => "Acc Thách Đấu Free Fire VIP cực khét của streamer.\n- Trang phục: Quỷ Kiếm Dạ Xoa huyền thoại, hành động hiếm cực nhiều.\n- Súng nâng cấp: M1014 Tiếng Hét cấp tối đa cực đẹp.\n- Rank hiện tại: Thách Đấu leo top.\n- Hỗ trợ đổi thông tin nhanh chóng.",
            'login_details' => 'ff_legend_thachdau | passffthachdau99',
            'is_featured' => true
        ]);

        Account::create([
            'game_id' => $ff->id,
            'title' => 'Acc Free Fire Giá Học Sinh - AK Rồng Xanh Cấp 4 - Rank Kim Cương',
            'price' => 270000,
            'rank' => 'Kim Cương',
            'status' => 'available',
            'images' => [
                'https://images.unsplash.com/photo-1589241062272-c0a000072dfa?q=80&w=800'
            ],
            'description' => "Tài khoản sở hữu AK Rồng Xanh cấp 4 cực chất, hành động biến hình rồng đẹp mắt.\n- Rank hiện tại: Kim Cương.\n- Mua bán tự động, an toàn tuyệt đối.",
            'login_details' => 'ff_student_ak | passffstudent00',
            'is_featured' => false
        ]);

        // --- Genshin Impact Accounts ---
        Account::create([
            'game_id' => $genshin->id,
            'title' => 'Acc Genshin Impact AR58 - Raiden Shogun C2 + Trấn, Furina, Nahida - 15 Tướng 5 Sao VIP',
            'price' => 1650000,
            'rank' => 'AR 58',
            'status' => 'available',
            'images' => [
                'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?q=80&w=800',
                'https://images.unsplash.com/photo-1552820728-8b83bb6b773f?q=80&w=800'
            ],
            'description' => "Acc siêu mạnh AR 58 gánh La Hoàn 36 sao cực kỳ dễ dàng.\n- Nhân vật 5 sao: Lôi Thần Raiden Shogun Cung Mệnh 2 + Trấn Đoạn Thảo Trường Ca. Nahida C0, Furina C0, Kazuha C0, Yelan C0 và hơn 10 tướng 5 sao khác.\n- Thánh di vật: Build cực chuẩn, chỉ số khủng gánh damage.\n- Bản đồ: Khám phá đầy đủ, dư nhiều tài nguyên.",
            'login_details' => 'gi_ar58_raiden | passgi58raiden',
            'is_featured' => true
        ]);

        Account::create([
            'game_id' => $genshin->id,
            'title' => 'Acc Genshin Impact Starter - Arlecchino + Trấn Hoà Phác Đao - AR10 Giá Siêu Rẻ',
            'price' => 189000,
            'rank' => 'AR 10',
            'status' => 'available',
            'images' => [
                'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?q=80&w=800'
            ],
            'description' => "Tài khoản Starter hoàn hảo cho người mới gia nhập Teyvat.\n- Nhân vật 5 sao: Arlecchino (Cha) cực mạnh giai đoạn đầu game kèm vũ khí xịn.\n- Rank mạo hiểm: AR 10.\n- Acc sạch 100%, bảo hành lỗi ban trọn đời.",
            'login_details' => 'gi_starter_arlec | passgiarlec123',
            'is_featured' => false
        ]);

        // 4. Create Promo Coupons
        Coupon::create([
            'code' => 'WELCOME100',
            'discount_amount' => 100000, // 100k discount
            'discount_type' => 'fixed',
            'min_spend' => 500000, // On orders of 500k+
            'expires_at' => now()->addDays(30),
            'active' => true
        ]);

        Coupon::create([
            'code' => 'GAMING10',
            'discount_amount' => 10, // 10% discount
            'discount_type' => 'percent',
            'min_spend' => 200000,
            'expires_at' => now()->addDays(15),
            'active' => true
        ]);

        Coupon::create([
            'code' => 'KM50K',
            'discount_amount' => 50000, // 50k discount
            'discount_type' => 'fixed',
            'min_spend' => 150000,
            'expires_at' => now()->addDays(7),
            'active' => true
        ]);

        Coupon::create([
            'code' => 'CYBERPUNK',
            'discount_amount' => 15, // 15% discount
            'discount_type' => 'percent',
            'min_spend' => 1000000,
            'expires_at' => now()->addDays(60),
            'active' => true
        ]);
    }
}

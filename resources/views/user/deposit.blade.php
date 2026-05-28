@extends('layouts.app')

@section('title', 'Nạp Tiền Vào Ví - GameShop')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="depositManager()">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Sidebar Navigation Dashboard Menu (col-span-3) -->
        <div class="lg:col-span-3 bg-gaming-card border border-gaming-border p-6 rounded-2xl space-y-6 shadow-glass">
            <div class="flex flex-col items-center text-center space-y-3 pb-6 border-b border-gaming-border">
                <img class="h-20 w-20 rounded-full border-4 border-gaming-purple object-cover" src="{{ Auth::user()->avatar ?? 'https://api.dicebear.com/7.x/bottts/svg?seed=' . Auth::user()->email }}" alt="Avatar">
                <div>
                    <h2 class="font-display font-bold text-white text-base">{{ Auth::user()->name }}</h2>
                    <span class="text-3xs text-gaming-neon font-bold font-gaming tracking-widest uppercase">{{ Auth::user()->role }}</span>
                </div>
            </div>
            
            <nav class="flex flex-col gap-2 text-sm text-gray-400 font-semibold">
                <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-user mr-3 text-base"></i>Thông tin cá nhân</a>
                <a href="{{ route('user.deposit') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white transition-all bg-gaming-purple text-white"><i class="fa-solid fa-wallet mr-3 text-base text-gaming-neon"></i>Nạp tiền vào ví</a>
                <a href="{{ route('user.transactions') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-history mr-3 text-base"></i>Lịch sử ví ảo</a>
                <a href="{{ route('user.purchased') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-key mr-3 text-base"></i>Kho Acc Đã Mua</a>
                <a href="{{ route('user.wishlist') }}" class="flex items-center px-4 py-2.5 rounded-xl hover:text-white hover:bg-gaming-dark transition-all"><i class="fa-solid fa-heart mr-3 text-base text-gaming-pink"></i>Acc đã lưu</a>
            </nav>
        </div>

        <!-- Deposit Main Area (col-span-9) -->
        <div class="lg:col-span-9 grid grid-cols-1 md:grid-cols-12 gap-8 items-start">
            <!-- Amount select card (col-span-7) -->
            <div class="md:col-span-7 bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass space-y-6">
                <h2 class="font-display font-bold text-lg text-white border-b border-gaming-border pb-3 flex items-center">
                    <i class="fa-solid fa-money-bill-transfer text-gaming-neon mr-3"></i>Chọn Số Tiền Nạp
                </h2>

                <!-- Quick amount presets selector -->
                <div class="grid grid-cols-3 gap-3">
                    <template x-for="val in presets" :key="val">
                        <button type="button" @click="selectPreset(val)"
                            class="py-3 px-2 border rounded-xl text-xs font-bold font-gaming transition-all hover:-translate-y-0.5"
                            :class="amount === val ? 'bg-gaming-purple/20 border-gaming-purple text-gaming-neon shadow-neon-purple/20' : 'bg-gaming-dark/40 border-gaming-border hover:border-gaming-purple text-gray-300'">
                            <span x-text="formatCurrency(val)"></span>
                        </button>
                    </template>
                </div>

                <!-- Custom input -->
                <div class="space-y-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400">Hoặc nhập số tiền tự chọn (đ)</label>
                    <input type="number" x-model.number="amount" min="20000" @input="updateQR"
                        class="bg-gaming-dark block w-full px-3 py-3 border border-gaming-border rounded-xl text-gray-200 text-sm focus:outline-none focus:border-gaming-purple focus:ring-1 focus:ring-gaming-purple"
                        placeholder="Số tiền cần nạp (Tối thiểu 20.000đ)">
                </div>

                <!-- Simulative Warning -->
                <div class="bg-gaming-dark/60 border border-gaming-border p-4 rounded-xl space-y-2 text-xs text-gray-400 leading-relaxed">
                    <p class="font-bold text-gaming-purple uppercase tracking-wider flex items-center"><i class="fa-solid fa-code mr-1.5"></i>CHẾ ĐỘ MÔ PHỎNG NẠP TIỀN</p>
                    <p>Vì đây là phiên bản thử nghiệm phát triển cục bộ (XAMPP/Localhost), bạn có thể nạp tiền giả lập ngay lập tức mà không cần chuyển khoản thật. Nhấn nút <strong>"Xác Nhận Nạp Thành Công"</strong> bên cạnh để cộng số dư ảo ngay lập tức và tiếp tục trải nghiệm quy trình thanh toán mua account game.</p>
                </div>
            </div>

            <!-- VietQR and Simulator trigger block (col-span-5) -->
            <div class="md:col-span-5 bg-gaming-card border border-gaming-border p-6 rounded-2xl shadow-glass flex flex-col items-center justify-between text-center relative overflow-hidden group">
                <h3 class="font-display font-bold text-sm text-white tracking-wider uppercase mb-3 flex items-center"><i class="fa-solid fa-qrcode text-gaming-purple mr-2"></i>CỔNG THANH TOÁN VIETQR</h3>
                
                <!-- QR Image Frame -->
                <div class="bg-white p-3 rounded-xl shadow-glass border border-gray-200 w-52 h-52 relative flex items-center justify-center overflow-hidden">
                    <img :src="qrUrl" alt="VietQR Mock" class="w-full h-full object-cover">
                </div>

                <div class="mt-4 space-y-2 w-full">
                    <span class="block text-4xs text-gray-500 uppercase tracking-widest font-semibold">Nội dung chuyển khoản</span>
                    <span class="block bg-gaming-dark py-1.5 px-3 border border-gaming-border rounded-lg text-xs text-gaming-neon font-gaming font-bold select-all tracking-wider" x-text="addInfo"></span>
                </div>

                <hr class="border-gaming-border w-full my-4">

                <!-- Simulator Submission -->
                <form action="{{ route('user.deposit.process') }}" method="POST" class="w-full">
                    @csrf
                    <input type="hidden" name="amount" :value="amount">
                    
                    <button type="submit"
                        class="w-full py-3.5 bg-gradient-to-r from-gaming-purple to-gaming-pink text-xs font-bold text-white rounded-xl shadow-neon-purple/20 hover:opacity-90 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-circle-check mr-1.5"></i>XÁC NHẬN NẠP THÀNH CÔNG
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Alpine script for dynamic QR and pricing -->
<script>
    function depositManager() {
        return {
            presets: [50000, 100000, 200000, 500000, 1000000],
            amount: 100000,
            addInfo: 'NAPTIEN GAMESHOP ' + '{{ Auth::user()->id }}',
            qrUrl: '',
            init() {
                this.updateQR();
            },
            selectPreset(val) {
                this.amount = val;
                this.updateQR();
            },
            formatCurrency(val) {
                return (val / 1000) + 'K';
            },
            updateQR() {
                // VietQR API format:
                // https://img.vietqr.io/image/<BANK_ID>-<ACCOUNT_NO>-<TEMPLATE>.jpg?amount=<AMOUNT>&addInfo=<ADD_INFO>&accountName=<ACCOUNT_NAME>
                const bankId = 'vietinbank';
                const accountNo = '970415050505';
                const template = 'qr_only';
                const accountName = 'GAMESHOP ADMIN';
                
                const encodedInfo = encodeURIComponent(this.addInfo);
                const encodedName = encodeURIComponent(accountName);
                
                this.qrUrl = `https://img.vietqr.io/image/${bankId}-${accountNo}-${template}.jpg?amount=${this.amount}&addInfo=${encodedInfo}&accountName=${encodedName}`;
            }
        }
    }
</script>
@endsection

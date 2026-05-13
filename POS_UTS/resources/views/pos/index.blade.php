<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern POS - Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        [x-cloak] { display: none !important; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #555; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-900" x-data="posSystem()">
    
    <!-- Top Navigation -->
    <nav class="bg-white shadow-sm border-b px-6 py-3 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="bg-blue-600 p-2 rounded-lg">
                <i class="fas fa-cash-register text-white text-xl"></i>
            </div>
            <h1 class="text-xl font-bold tracking-tight text-gray-800">Point Of Sales</h1>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-semibold text-gray-700">{{ auth()->user()?->nama ?? 'Kasir Utama' }}</p>
                <p class="text-xs text-gray-500">{{ date('d F Y') }}</p>
            </div>
            <a href="/admin" class="bg-gray-100 hover:bg-gray-200 p-2 rounded-full transition-colors" title="Dashboard Admin">
                <i class="fas fa-cog text-gray-600"></i>
            </a>
        </div>
    </nav>

    <main class="flex h-[calc(100vh-64px)] overflow-hidden">
        <!-- Sidebar Categories -->
        <aside class="w-20 md:w-64 bg-white border-r flex flex-col transition-all duration-300">
            <div class="p-4 border-b">
                <div class="relative">
                    <input type="text" x-model="search" placeholder="Cari barang..." 
                        class="w-full pl-10 pr-4 py-2 bg-gray-100 border-none rounded-xl text-sm focus:ring-2 focus:ring-blue-500 transition-all">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                </div>
            </div>
            <div class="flex-1 overflow-y-auto custom-scrollbar p-2 space-y-1">
                <button @click="selectedCategory = 'all'" 
                    :class="selectedCategory === 'all' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all group">
                    <i class="fas fa-th-large w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="hidden md:block font-medium">Semua Produk</span>
                </button>
                
                @foreach($categories as $cat)
                <button @click="selectedCategory = '{{ $cat->kategori_nama }}'" 
                    :class="selectedCategory === '{{ $cat->kategori_nama }}' ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all group">
                    <i class="fas fa-tag w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="hidden md:block font-medium">{{ $cat->kategori_nama }}</span>
                </button>
                @endforeach
            </div>
        </aside>

        <!-- Product Grid -->
        <section class="flex-1 bg-gray-50 overflow-y-auto p-6 custom-scrollbar">
            <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-6">
                <template x-for="product in filteredProducts()" :key="product.barang_id">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col group">
                        <div class="h-40 bg-gray-100 relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-400 to-indigo-500 opacity-20"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fas fa-box text-4xl text-gray-300 group-hover:scale-110 transition-transform"></i>
                            </div>
                            <div class="absolute top-2 right-2">
                                <span class="bg-white/90 backdrop-blur px-2 py-1 rounded-lg text-[10px] font-bold text-gray-600 border border-white/20" x-text="product.kategori.kategori_nama"></span>
                            </div>
                        </div>
                        <div class="p-4 flex flex-col flex-1">
                            <h3 class="font-bold text-gray-800 text-sm mb-1 line-clamp-2" x-text="product.barang_nama"></h3>
                            <p class="text-xs text-gray-400 mb-3" x-text="product.barang_kode"></p>
                            <div class="mt-auto flex items-center justify-between">
                                <span class="font-black text-blue-600" x-text="formatRupiah(product.harga_jual)"></span>
                                <button @click="addToCart(product)" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-xl shadow-lg shadow-blue-200 transition-all active:scale-95">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            
            <div x-show="filteredProducts().length === 0" class="flex flex-col items-center justify-center h-full text-gray-400">
                <i class="fas fa-search text-6xl mb-4 opacity-20"></i>
                <p class="text-lg">Produk tidak ditemukan</p>
            </div>
        </section>

        <!-- Cart Sidebar -->
        <aside class="w-96 bg-white border-l flex flex-col shadow-2xl z-40">
            <div class="p-6 border-b flex justify-between items-center">
                <h2 class="text-lg font-bold flex items-center gap-2">
                    <i class="fas fa-shopping-cart text-blue-600"></i>
                    Detail Pesanan
                </h2>
                <span class="bg-blue-100 text-blue-600 text-xs font-bold px-2 py-1 rounded-full" x-text="cart.length + ' Items'"></span>
            </div>

            <div class="p-4 border-b">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nama Pelanggan</label>
                <div class="relative">
                    <input type="text" x-model="pembeli" placeholder="Contoh: Umum / Budi" 
                        class="w-full pl-10 pr-4 py-3 bg-gray-50 border-gray-100 rounded-xl text-sm focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    <i class="fas fa-user absolute left-3 top-3.5 text-gray-400"></i>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar p-4 space-y-4">
                <template x-for="(item, index) in cart" :key="item.barang_id">
                    <div class="flex items-center gap-4 bg-gray-50 p-3 rounded-2xl border border-gray-100 animate-fadeIn">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center border text-blue-500">
                            <i class="fas fa-box text-sm"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-bold text-sm text-gray-800 truncate" x-text="item.barang_nama"></h4>
                            <p class="text-xs text-blue-600 font-semibold" x-text="formatRupiah(item.harga_jual)"></p>
                        </div>
                        <div class="flex items-center gap-2 bg-white rounded-lg border p-1">
                            <button @click="updateQty(index, -1)" class="w-6 h-6 flex items-center justify-center hover:bg-gray-100 rounded text-gray-500">-</button>
                            <span class="w-6 text-center text-xs font-bold" x-text="item.jumlah"></span>
                            <button @click="updateQty(index, 1)" class="w-6 h-6 flex items-center justify-center hover:bg-gray-100 rounded text-gray-500">+</button>
                        </div>
                        <button @click="removeFromCart(index)" class="text-red-400 hover:text-red-600 p-2 transition-colors">
                            <i class="fas fa-trash-can text-sm"></i>
                        </button>
                    </div>
                </template>

                <div x-show="cart.length === 0" class="flex flex-col items-center justify-center py-20 text-gray-300">
                    <i class="fas fa-shopping-basket text-5xl mb-4 opacity-30"></i>
                    <p class="text-sm font-medium">Keranjang masih kosong</p>
                </div>
            </div>

            <div class="p-6 bg-gray-50 border-t space-y-4">
                <div class="space-y-2">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Subtotal</span>
                        <span x-text="formatRupiah(calculateSubtotal())"></span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500" x-show="taxPercentage > 0">
                        <span x-text="'Pajak (' + taxPercentage + '%)'"></span>
                        <span x-text="formatRupiah(calculateTax())"></span>
                    </div>
                    <div class="flex justify-between items-end pt-2 border-t border-dashed border-gray-300">
                        <span class="font-bold text-gray-800">Total Akhir</span>
                        <span class="text-2xl font-black text-blue-600" x-text="formatRupiah(calculateTotal())"></span>
                    </div>
                </div>

                <button @click="checkout()" 
                    :disabled="cart.length === 0 || !pembeli || isProcessing"
                    :class="cart.length === 0 || !pembeli || isProcessing ? 'bg-gray-300 cursor-not-allowed' : 'bg-blue-600 hover:bg-blue-700 shadow-xl shadow-blue-200'"
                    class="w-full py-4 rounded-2xl text-white font-bold text-lg transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                    <template x-if="!isProcessing">
                        <span>Selesaikan Transaksi</span>
                    </template>
                    <template x-if="isProcessing">
                        <span class="flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Memproses...
                        </span>
                    </template>
                    <i x-show="!isProcessing" class="fas fa-arrow-right text-sm"></i>
                </button>
            </div>
        </aside>
    </main>

    <!-- Notification -->
    <div x-cloak x-show="notification.show" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-4"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform translate-y-4"
        class="fixed bottom-10 left-1/2 -translate-x-1/2 z-[100]">
        <div :class="notification.type === 'success' ? 'bg-green-600' : 'bg-red-600'" 
            class="px-6 py-3 rounded-2xl text-white shadow-2xl flex items-center gap-3 min-w-[300px]">
            <i :class="notification.type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle'"></i>
            <span class="font-medium" x-text="notification.message"></span>
        </div>
    </div>

    <script>
        function posSystem() {
            return {
                search: '',
                selectedCategory: 'all',
                pembeli: 'Umum',
                products: @json($products),
                taxPercentage: {{ $taxPercentage }},
                cart: [],
                isProcessing: false,
                notification: {
                    show: false,
                    message: '',
                    type: 'success'
                },

                filteredProducts() {
                    return this.products.filter(p => {
                        const matchesSearch = p.barang_nama.toLowerCase().includes(this.search.toLowerCase()) || 
                                            p.barang_kode.toLowerCase().includes(this.search.toLowerCase());
                        const matchesCategory = this.selectedCategory === 'all' || p.kategori.kategori_nama === this.selectedCategory;
                        return matchesSearch && matchesCategory;
                    });
                },

                addToCart(product) {
                    const existing = this.cart.findIndex(item => item.barang_id === product.barang_id);
                    if (existing > -1) {
                        this.cart[existing].jumlah++;
                    } else {
                        this.cart.push({
                            barang_id: product.barang_id,
                            barang_nama: product.barang_nama,
                            harga_jual: product.harga_jual,
                            jumlah: 1
                        });
                    }
                    this.showNotification('Item berhasil ditambahkan ke keranjang');
                },

                updateQty(index, delta) {
                    this.cart[index].jumlah += delta;
                    if (this.cart[index].jumlah < 1) {
                        this.removeFromCart(index);
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                calculateSubtotal() {
                    return this.cart.reduce((total, item) => total + (item.harga_jual * item.jumlah), 0);
                },

                calculateTax() {
                    return this.calculateSubtotal() * (this.taxPercentage / 100);
                },

                calculateTotal() {
                    return this.calculateSubtotal() + this.calculateTax();
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(number);
                },

                showNotification(message, type = 'success') {
                    this.notification.message = message;
                    this.notification.type = type;
                    this.notification.show = true;
                    setTimeout(() => {
                        this.notification.show = false;
                    }, 3000);
                },

                async checkout() {
                    if (this.cart.length === 0) return;
                    this.isProcessing = true;
                    
                    try {
                        const response = await fetch('{{ route("pos.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                pembeli: this.pembeli,
                                items: this.cart
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            this.showNotification('Transaksi Berhasil!');
                            this.cart = [];
                            this.pembeli = 'Umum';
                            
                            // Buka struk di tab baru
                            window.open(result.redirect, '_blank');
                        } else {
                            this.showNotification(result.message || 'Gagal menyimpan transaksi', 'error');
                        }
                    } catch (error) {
                        this.showNotification('Terjadi kesalahan sistem', 'error');
                    } finally {
                        this.isProcessing = false;
                    }
                }
            }
        }
    </script>
</body>
</html>

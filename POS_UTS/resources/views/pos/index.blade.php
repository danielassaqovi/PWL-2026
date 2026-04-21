@extends('layouts.app')

@section('content')
<div x-data="cartSystem()" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Bagian Kiri: Daftar Produk -->
    <div class="lg:col-span-2 space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">Menu <span class="text-navy">Produk</span></h2>
            <div class="relative w-64">
                <input type="text" placeholder="Cari barang..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-navy focus:border-navy outline-none transition-all">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($barang as $b)
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all group overflow-hidden relative">
                <div class="w-full h-32 bg-gray-50 rounded-xl mb-4 flex items-center justify-center text-gray-300">
                    <!-- Placeholder icon for image -->
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="space-y-1">
                    <span class="text-[10px] uppercase font-bold text-orange-500 bg-orange-50 px-2 py-0.5 rounded">{{ $b->kategori->kategori_nama }}</span>
                    <h3 class="font-bold text-gray-800 truncate">{{ $b->barang_nama }}</h3>
                    <p class="text-navy font-extrabold">{{ $b->harga_jual_formatted }}</p>
                </div>
                <button 
                    @click="addItem({ id: {{ $b->barang_id }}, nama: '{{ $b->barang_nama }}', harga: {{ $b->harga_jual }} })"
                    class="mt-4 w-full py-2 bg-gray-50 text-navy font-bold rounded-lg group-hover:bg-navy group-hover:text-white transition-all flex items-center justify-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah
                </button>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Bagian Kanan: Keranjang Belanja -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 flex flex-col sticky top-8 max-h-[calc(100vh-4rem)]">
            <div class="p-6 border-b border-gray-50 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-800">Keranjang</h3>
                <span class="bg-navy text-white text-xs px-2 py-1 rounded-full" x-text="items.length + ' item'"></span>
            </div>

            <!-- List Cart -->
            <div class="flex-grow overflow-y-auto p-6 space-y-4">
                <template x-if="items.length === 0">
                    <div class="text-center py-10">
                        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-400 font-medium text-sm">Keranjang masih kosong</p>
                    </div>
                </template>

                <template x-for="(item, index) in items" :key="item.id">
                    <div class="flex items-center justify-between group">
                        <div class="flex-grow">
                            <p class="font-bold text-gray-800 text-sm" x-text="item.nama"></p>
                            <p class="text-xs text-gray-400" x-text="formatRupiah(item.harga)"></p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                                <button @click="updateQty(index, -1)" class="px-2 py-1 bg-gray-50 hover:bg-gray-100 text-gray-500">-</button>
                                <span class="px-3 py-1 text-sm font-bold w-10 text-center" x-text="item.jumlah"></span>
                                <button @click="updateQty(index, 1)" class="px-2 py-1 bg-gray-50 hover:bg-gray-100 text-gray-500">+</button>
                            </div>
                            <button @click="removeItem(index)" class="text-gray-300 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Footer Keranjang -->
            <div class="p-6 bg-gray-50 border-t border-gray-100 space-y-4 rounded-b-2xl">
                <div>
                    <label class="text-xs font-bold text-gray-500 uppercase block mb-1">Nama Pembeli</label>
                    <input x-model="pembeli" type="text" placeholder="Masukkan nama..." class="w-full px-4 py-2 rounded-xl border border-gray-200 focus:ring-2 focus:ring-navy outline-none text-sm transition-all">
                </div>

                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-500 font-medium">Total Bayar</span>
                    <span class="text-2xl font-black text-navy" x-text="formatRupiah(total)"></span>
                </div>

                <button 
                    @click="checkout()"
                    :disabled="items.length === 0 || !pembeli || processing"
                    class="w-full py-4 bg-orange-custom hover-orange disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-black rounded-xl shadow-lg shadow-orange-500/30 transition-all flex items-center justify-center text-lg">
                    <span x-show="!processing">Proses Transaksi</span>
                    <span x-show="processing" class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Memproses...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function cartSystem() {
        return {
            items: [],
            pembeli: '',
            processing: false,
            
            addItem(product) {
                const existing = this.items.find(i => i.id === product.id);
                if (existing) {
                    existing.jumlah++;
                } else {
                    this.items.push({
                        id: product.id,
                        nama: product.nama,
                        harga: product.harga,
                        jumlah: 1
                    });
                }
            },

            updateQty(index, amount) {
                this.items[index].jumlah += amount;
                if (this.items[index].jumlah <= 0) {
                    this.removeItem(index);
                }
            },

            removeItem(index) {
                this.items.splice(index, 1);
            },

            get total() {
                return this.items.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
            },

            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            },

            async checkout() {
                this.processing = true;
                const data = {
                    pembeli: this.pembeli,
                    items: this.items.map(i => ({
                        barang_id: i.id,
                        jumlah: i.jumlah
                    })),
                    _token: '{{ csrf_token() }}'
                };

                try {
                    const response = await fetch('{{ route("pos.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();
                    if (result.success) {
                        window.location.href = result.redirect;
                    } else {
                        alert('Terjadi kesalahan saat memproses transaksi.');
                    }
                } catch (error) {
                    console.error(error);
                    alert('Gagal mengirim data ke server.');
                } finally {
                    this.processing = false;
                }
            }
        }
    }
</script>
@endpush
@endsection

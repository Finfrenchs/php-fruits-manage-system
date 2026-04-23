<?php
/**
 * ==========================================================
 * dashboard.php - Halaman Dashboard Manajemen Buah
 * ==========================================================
 * 
 * FUNGSI:
 * Menampilkan tabel data buah dari database dengan fitur CRUD:
 * - Tambah buah baru (modal form)
 * - Edit buah (modal form)
 * - Hapus buah (konfirmasi)
 * 
 * VARIABEL YANG DITERIMA DARI CONTROLLER:
 * - $fruits : Array berisi semua data buah dari database
 */
?>

<!-- ============================================ -->
<!-- STATISTIK CARDS                              -->
<!-- ============================================ -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
    <!-- Card: Total Buah -->
    <div class="relative overflow-hidden rounded-2xl bg-white border border-surface-200/60 p-6 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-surface-700/50">Total Buah</p>
                <p class="text-3xl font-extrabold text-surface-900 mt-1"><?= count($fruits) ?></p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-400 to-brand-600 flex items-center justify-center text-xl shadow-lg shadow-brand-500/20">🍉</div>
        </div>
        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-brand-100 rounded-full opacity-30"></div>
    </div>

    <!-- Card: Jenis Terbanyak -->
    <?php
    $jenisCounts = [];
    foreach ($fruits as $f) { $jenisCounts[$f['nama']] = ($jenisCounts[$f['nama']] ?? 0) + 1; }
    arsort($jenisCounts);
    $topJenis = array_key_first($jenisCounts) ?? '-';
    ?>
    <div class="relative overflow-hidden rounded-2xl bg-white border border-surface-200/60 p-6 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-surface-700/50">Buah Terbanyak</p>
                <p class="text-3xl font-extrabold text-surface-900 mt-1"><?= htmlspecialchars($topJenis) ?></p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-xl shadow-lg shadow-orange-500/20">🏆</div>
        </div>
        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-amber-100 rounded-full opacity-30"></div>
    </div>

    <!-- Card: Tahun Panen Terakhir -->
    <?php $latestYear = !empty($fruits) ? max(array_column($fruits, 'tahun_panen')) : '-'; ?>
    <div class="relative overflow-hidden rounded-2xl bg-white border border-surface-200/60 p-6 shadow-sm hover:shadow-md transition-shadow">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-surface-700/50">Panen Terbaru</p>
                <p class="text-3xl font-extrabold text-surface-900 mt-1"><?= $latestYear ?></p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-violet-400 to-purple-600 flex items-center justify-center text-xl shadow-lg shadow-purple-500/20">📅</div>
        </div>
        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-violet-100 rounded-full opacity-30"></div>
    </div>
</div>

<!-- ============================================ -->
<!-- TABEL DATA BUAH + TOMBOL TAMBAH             -->
<!-- ============================================ -->
<div x-data="{ showAddModal: false, showEditModal: false, editData: {} }" class="rounded-2xl bg-white border border-surface-200/60 shadow-sm overflow-hidden">
    
    <!-- Header Tabel -->
    <div class="flex items-center justify-between px-6 py-5 border-b border-surface-200/50">
        <div>
            <h3 class="text-lg font-bold text-surface-900">Daftar Buah</h3>
            <p class="text-xs text-surface-700/50 mt-0.5">Kelola data buah dalam sistem</p>
        </div>
        <button @click="showAddModal = true" id="btn-add-fruit"
                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 text-white text-sm font-semibold shadow-lg shadow-brand-500/25 hover:shadow-brand-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Buah
        </button>
    </div>

    <!-- Tabel -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="fruits-table">
            <thead>
                <tr class="bg-surface-50/80">
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-surface-700/50">No</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-surface-700/50">Nama</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-surface-700/50">Jenis</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-surface-700/50">Tahun Panen</th>
                    <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-surface-700/50">Dibuat</th>
                    <th class="px-6 py-3.5 text-right text-[11px] font-bold uppercase tracking-wider text-surface-700/50">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-surface-100">
                <?php if (empty($fruits)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="text-4xl mb-3">🍃</div>
                            <p class="text-surface-700/50 font-medium">Belum ada data buah.</p>
                            <p class="text-xs text-surface-700/30 mt-1">Klik "Tambah Buah" untuk menambahkan data.</p>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($fruits as $i => $fruit): ?>
                        <tr class="hover:bg-brand-50/30 transition-colors">
                            <td class="px-6 py-4 font-semibold text-surface-700/40"><?= $i + 1 ?></td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center text-sm">
                                        <?= $fruit['nama'] === 'Mangga' ? '🥭' : ($fruit['nama'] === 'Apel' ? '🍎' : ($fruit['nama'] === 'Jeruk' ? '🍊' : '🍇')) ?>
                                    </div>
                                    <span class="font-semibold text-surface-900"><?= htmlspecialchars($fruit['nama']) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-2.5 py-1 rounded-lg bg-brand-50 text-brand-700 text-xs font-semibold border border-brand-200/50">
                                    <?= htmlspecialchars($fruit['jenis']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-medium text-surface-700"><?= $fruit['tahun_panen'] ?></td>
                            <td class="px-6 py-4 text-xs text-surface-700/50"><?= date('d M Y', strtotime($fruit['created_at'])) ?></td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <!-- Tombol Edit -->
                                    <button @click="editData = { id: <?= $fruit['id'] ?>, nama: '<?= htmlspecialchars($fruit['nama'], ENT_QUOTES) ?>', jenis: '<?= htmlspecialchars($fruit['jenis'], ENT_QUOTES) ?>', tahun_panen: <?= $fruit['tahun_panen'] ?> }; showEditModal = true"
                                            class="p-2 rounded-lg text-surface-700/50 hover:bg-blue-50 hover:text-blue-600 transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <!-- Tombol Hapus -->
                                    <form method="POST" action="index.php?action=delete" onsubmit="return confirm('Yakin ingin menghapus buah ini?')">
                                        <input type="hidden" name="id" value="<?= $fruit['id'] ?>">
                                        <button type="submit" class="p-2 rounded-lg text-surface-700/50 hover:bg-red-50 hover:text-red-600 transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- ============================================ -->
    <!-- MODAL: TAMBAH BUAH                          -->
    <!-- ============================================ -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="showAddModal" @click="showAddModal = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-surface-900/50 backdrop-blur-sm"></div>
        <div x-show="showAddModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-7 z-10" @click.away="showAddModal = false">
            <h3 class="text-lg font-bold text-surface-900 mb-5">Tambah Buah Baru</h3>
            <form method="POST" action="index.php?action=store" class="space-y-4" id="form-add-fruit">
                <div>
                    <label class="block text-xs font-semibold text-surface-700 mb-1.5">Nama Buah</label>
                    <input type="text" name="nama" required placeholder="Contoh: Mangga" class="w-full px-4 py-2.5 rounded-xl border border-surface-200 bg-surface-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-surface-700 mb-1.5">Jenis / Varietas</label>
                    <input type="text" name="jenis" required placeholder="Contoh: Harum Manis" class="w-full px-4 py-2.5 rounded-xl border border-surface-200 bg-surface-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-surface-700 mb-1.5">Tahun Panen</label>
                    <input type="number" name="tahun_panen" required min="2000" max="2099" placeholder="Contoh: 2025" class="w-full px-4 py-2.5 rounded-xl border border-surface-200 bg-surface-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-400 transition-all">
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showAddModal = false" class="flex-1 px-4 py-2.5 rounded-xl border border-surface-200 text-sm font-semibold text-surface-700 hover:bg-surface-50 transition-colors">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-brand-500 to-brand-600 text-white text-sm font-semibold shadow-lg shadow-brand-500/25 hover:shadow-brand-500/40 transition-all">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ============================================ -->
    <!-- MODAL: EDIT BUAH                            -->
    <!-- ============================================ -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div x-show="showEditModal" @click="showEditModal = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-surface-900/50 backdrop-blur-sm"></div>
        <div x-show="showEditModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-7 z-10" @click.away="showEditModal = false">
            <h3 class="text-lg font-bold text-surface-900 mb-5">Edit Buah</h3>
            <form method="POST" action="index.php?action=update" class="space-y-4" id="form-edit-fruit">
                <input type="hidden" name="id" :value="editData.id">
                <div>
                    <label class="block text-xs font-semibold text-surface-700 mb-1.5">Nama Buah</label>
                    <input type="text" name="nama" required :value="editData.nama" class="w-full px-4 py-2.5 rounded-xl border border-surface-200 bg-surface-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-surface-700 mb-1.5">Jenis / Varietas</label>
                    <input type="text" name="jenis" required :value="editData.jenis" class="w-full px-4 py-2.5 rounded-xl border border-surface-200 bg-surface-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-400 transition-all">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-surface-700 mb-1.5">Tahun Panen</label>
                    <input type="number" name="tahun_panen" required min="2000" max="2099" :value="editData.tahun_panen" class="w-full px-4 py-2.5 rounded-xl border border-surface-200 bg-surface-50/50 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500/30 focus:border-brand-400 transition-all">
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" @click="showEditModal = false" class="flex-1 px-4 py-2.5 rounded-xl border border-surface-200 text-sm font-semibold text-surface-700 hover:bg-surface-50 transition-colors">Batal</button>
                    <button type="submit" class="flex-1 px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-semibold shadow-lg shadow-blue-500/25 hover:shadow-blue-500/40 transition-all">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

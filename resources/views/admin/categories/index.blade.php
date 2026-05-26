@extends('layouts.admin')

@section('page_title', 'Kelola Kategori')
@section('page_subtitle', 'Manajemen daftar kategori event AmikomEventHub.')

@section('content')

{{-- Form Tambah Kategori --}}
<div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm max-w-2xl mb-8">
    <h3 class="text-lg font-black text-slate-800 mb-6">Tambah Kategori Baru</h3>
    <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Nama Kategori
            </label>
            <input type="text" name="name" value="{{ old('name') }}"
                placeholder="Contoh: Musik, Teknologi, Olahraga"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                required>
            @error('name')
                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
            @enderror
        </div>
        <div class="pt-2">
            <button type="submit"
                class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                + Simpan Kategori
            </button>
        </div>
    </form>
</div>

{{-- Form Search --}}
<div class="mb-6 max-w-md">
    <form action="{{ route('admin.categories.index') }}" method="GET" class="flex gap-2">
        <input type="text" name="search" value="{{ $search ?? '' }}"
            placeholder="Cari nama kategori..."
            class="flex-1 px-5 py-3 bg-white border-2 border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium">
        <button type="submit"
            class="px-6 py-3 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
            Cari
        </button>
        @if($search)
            <a href="{{ route('admin.categories.index') }}"
                class="px-6 py-3 bg-slate-200 text-slate-700 rounded-2xl font-bold hover:bg-slate-300 transition">
                Reset
            </a>
        @endif
    </form>
</div>

{{-- Tabel Kategori --}}
<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">No</th>
                    <th class="px-8 py-4">ID</th>
                    <th class="px-8 py-4">Nama Kategori</th>
                    <th class="px-8 py-4">Created At</th>
                    <th class="px-8 py-4">Updated At</th>
                    <th class="px-8 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($categories as $index => $category)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $index + 1 }}</td>
                    <td class="px-8 py-6 text-slate-500">{{ $category->id }}</td>
                    <td class="px-8 py-6 font-black text-slate-800">{{ $category->name }}</td>
                    <td class="px-8 py-6 text-sm text-slate-400">{{ $category->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-8 py-6 text-sm text-slate-400">{{ $category->updated_at->format('d M Y, H:i') }}</td>
                    <td class="px-8 py-6">
                        <div class="flex gap-2">
                            <button onclick="openEditModal({{ $category->id }}, '{{ addslashes($category->name) }}')"
                                class="px-4 py-2 bg-amber-100 text-amber-700 rounded-xl font-bold text-sm hover:bg-amber-200 transition">
                                Edit
                            </button>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 bg-red-100 text-red-700 rounded-xl font-bold text-sm hover:bg-red-200 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-8 py-10 text-center text-slate-500">
                        @if($search)
                            Tidak ada kategori "<strong>{{ $search }}</strong>".
                        @else
                            Belum ada kategori yang terdaftar.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal Edit --}}
<div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden items-center justify-center z-50">
    <div class="bg-white rounded-[2.5rem] p-8 w-full max-w-md shadow-2xl mx-4">
        <h3 class="text-lg font-black text-slate-800 mb-6">Edit Kategori</h3>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                    Nama Kategori
                </label>
                <input type="text" id="editName" name="name"
                    class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                    required>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="flex-1 px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold hover:bg-indigo-700 transition">
                    Simpan Perubahan
                </button>
                <button type="button" onclick="closeEditModal()"
                    class="px-6 py-4 bg-slate-100 text-slate-700 rounded-2xl font-bold hover:bg-slate-200 transition">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name) {
    document.getElementById('editName').value = name;
    document.getElementById('editForm').action = '/admin/categories/' + id;
    const modal = document.getElementById('editModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeEditModal() {
    const modal = document.getElementById('editModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.getElementById('editModal').addEventListener('click', function(e) {
    if (e.target === this) closeEditModal();
});
</script>

@endsection
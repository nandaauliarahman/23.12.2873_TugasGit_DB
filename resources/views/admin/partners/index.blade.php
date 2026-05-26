@extends('layouts.admin')

@section('page_title', 'Kelola Partner')
@section('page_subtitle', 'Daftar partner yang mendukung AmikomEventHub.')

@section('content')

{{-- Form Tambah Partner --}}
<div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm max-w-2xl mb-8">
    <h3 class="text-lg font-black text-slate-800 mb-6">Tambah Partner Baru</h3>
    <form action="{{ route('admin.partners.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                Nama Partner
            </label>
            <input type="text" name="name" value="{{ old('name') }}"
                placeholder="Contoh: PT. Amikom Digital"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                required>
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide">
                URL Logo
            </label>
            <input type="text" name="logo_url" value="{{ old('logo_url', 'https://placehold.co/200x200') }}"
                placeholder="https://placehold.co/200x200"
                class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-600 outline-none transition font-medium"
                required>
            @error('logo_url')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <div class="pt-2">
            <button type="submit"
                class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                + Simpan Partner
            </button>
        </div>
    </form>
</div>

{{-- Tabel Daftar Partner --}}
@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6 font-bold text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-400 uppercase text-[10px] font-black tracking-widest">
                <tr>
                    <th class="px-8 py-4">No</th>
                    <th class="px-8 py-4">Logo</th>
                    <th class="px-8 py-4">Nama Partner</th>
                    <th class="px-8 py-4">URL Logo</th>
                </tr>
            </thead>
            <tbody class="divide-y border-t">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-8 py-6 font-bold text-slate-400">{{ $index + 1 }}</td>
                    <td class="px-8 py-6">
                        <img src="{{ $partner->logo_url }}"
                            alt="{{ $partner->name }}"
                            class="w-16 h-16 rounded-xl object-cover shadow-sm border">
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-black text-slate-800">{{ $partner->name }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-sm text-slate-500 truncate max-w-xs">{{ $partner->logo_url }}</p>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-8 py-10 text-center text-slate-500">
                        Belum ada partner yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
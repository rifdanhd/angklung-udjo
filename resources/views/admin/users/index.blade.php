{{-- resources/views/admin/users/index.blade.php --}}
@extends('admin.layouts.app')

@section('title', 'Manajemen User')

@push('styles')
<style>
/* Page header */
.page-header {
    display: flex; align-items: flex-start; justify-content: space-between;
    margin-bottom: 20px; gap: 12px; flex-wrap: wrap;
}
.page-title { font-size: 22px; font-weight: 700; color: var(--text); letter-spacing: -.5px; }
.page-breadcrumb {
    display: flex; align-items: center; gap: 6px;
    font-size: 12.5px; color: var(--text-muted); margin-top: 4px;
}
.page-breadcrumb a { color: var(--text-muted); text-decoration: none; }
.page-breadcrumb a:hover { color: var(--text); }
.page-breadcrumb svg { width: 12px; height: 12px; }

/* Modal styles */
.modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(15,15,21,.55);
    backdrop-filter: blur(4px);
    z-index: 10000;
    align-items: center;
    justify-content: center;
    padding: 20px;
}
.modal-backdrop.open { display: flex; }
.modal-box {
    background: var(--surface);
    border-radius: var(--radius-lg);
    width: 100%;
    max-width: 480px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: var(--shadow-lg);
    padding: 24px;
    position: relative;
    animation: slideUp .2s cubic-bezier(.4,0,.2,1);
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px) scale(.96); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}
.modal-close {
    position: absolute;
    top: 16px; right: 16px;
    background: var(--surface2);
    border: none;
    width: 32px; height: 32px;
    border-radius: 8px;
    cursor: pointer;
    color: var(--text-muted);
    font-size: 18px;
    display: flex; align-items: center; justify-content: center;
    transition: all var(--transition);
}
.modal-close:hover { background: var(--surface3); color: var(--text); }
.modal-header {
    margin-bottom: 20px;
}
.modal-title {
    font-size: 18px; font-weight: 700;
    color: var(--text);
    margin-bottom: 6px;
}
.form-group {
    margin-bottom: 16px;
}
.form-group label {
    display: block;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 6px;
}
.form-control {
    width: 100%;
    padding: 9px 12px;
    border: 1px solid var(--border-strong);
    border-radius: var(--radius-sm);
    font-family: var(--font);
    font-size: 13.5px;
    background: var(--surface);
    outline: none;
    transition: all var(--transition);
}
.form-control:focus {
    border-color: var(--border-focus);
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}
</style>
@endpush

@section('content')

{{-- Page Header --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Manajemen User (Staf &amp; Admin)</h1>
        <div class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:12px;height:12px;margin:0 4px;"><path d="M9 5l7 7-7 7"/></svg>
            Manajemen User
        </div>
    </div>
    <button onclick="openModal()" class="btn btn-primary">
        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width:14px;height:14px;margin-right:6px;"><path d="M12 4v16m8-8H4"/></svg>
        Tambah Admin / Editor
    </button>
</div>

{{-- Table Card --}}
<div class="card">
    <div class="card-header">
        <div>
            <div class="card-title">Daftar Pengguna Dashboard</div>
            <div class="card-sub">Mengelola hak akses editor, admin, dan super admin</div>
        </div>
        <span class="badge badge-brand">{{ $users->total() }} Pengguna</span>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Hak Akses (Role)</th>
                    <th>Tanggal Terdaftar</th>
                    <th style="width:120px; text-align:right;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td style="font-weight:600;">
                        {{ $user->name }}
                        @if(auth()->id() === $user->id)
                            <span class="badge badge-success" style="margin-left:4px; font-size:10px; padding:2px 6px;">Anda</span>
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @php
                            $roleLabel = match($user->role) {
                                'super_admin' => 'Super Admin',
                                'admin'       => 'Admin',
                                'editor'      => 'Editor',
                                default       => $user->role ?? 'Admin',
                            };
                            $roleClass = match($user->role) {
                                'super_admin' => 'badge-danger',
                                'admin'       => 'badge-brand',
                                'editor'      => 'badge-info',
                                default       => 'badge-muted',
                            };
                        @endphp
                        <span class="badge {{ $roleClass }}">{{ $roleLabel }}</span>
                    </td>
                    <td style="color:var(--text-muted);">
                        {{ $user->created_at->format('d M Y H:i') }}
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;justify-content:flex-end;">
                            <button onclick="openModal({{ $user->toJson() }})" class="btn btn-outline btn-sm btn-icon-sm" title="Edit Pengguna">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            @if(auth()->id() !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna admin ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm btn-icon-sm" title="Hapus">
                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6m5 0V4h4v2"/></svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div style="padding:16px 20px;border-top:1px solid var(--border);">
        {{ $users->links() }}
    </div>
    @endif
</div>

{{-- MODAL CREATE / EDIT --}}
<div class="modal-backdrop" id="user-backdrop" onclick="handleBackdropClick(event)">
    <div class="modal-box">
        <button class="modal-close" onclick="closeModal()">×</button>
        <div class="modal-header">
            <h2 class="modal-title" id="modal-title">Tambah Pengguna</h2>
            <div style="font-size:12.5px;color:var(--text-muted);" id="modal-sub">Daftarkan akun admin / editor baru</div>
        </div>

        <form id="user-form" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" id="field-name" class="form-control" required placeholder="e.g. Ahmad Hidayat">
            </div>

            <div class="form-group">
                <label>Alamat Email</label>
                <input type="email" name="email" id="field-email" class="form-control" required placeholder="e.g. ahmad@saungangklung.com">
            </div>

            <div class="form-group">
                <label id="password-label">Password</label>
                <input type="password" name="password" id="field-password" class="form-control" placeholder="Maksimal 8 karakter">
                <div style="font-size:11px;color:var(--text-muted);margin-top:4px;" id="password-help">Minimal 8 karakter.</div>
            </div>

            <div class="form-group">
                <label>Hak Akses / Role</label>
                <select name="role" id="field-role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="editor">Editor</option>
                    <option value="super_admin">Super Admin</option>
                </select>
            </div>

            <div style="display:flex;justify-content:flex-end;gap:8px;margin-top:24px;border-top:1px solid var(--border);padding-top:16px;">
                <button type="button" class="btn btn-outline" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn btn-primary" id="submit-btn">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
const backdrop = document.getElementById('user-backdrop');
const form = document.getElementById('user-form');

function openModal(user = null) {
    form.reset();
    
    if (user) {
        // Edit mode
        document.getElementById('modal-title').textContent = 'Edit Pengguna';
        document.getElementById('modal-sub').textContent = 'Perbarui akun admin / editor';
        document.getElementById('submit-btn').textContent = 'Simpan Perubahan';
        
        form.action = '/admin/users/' + user.id;
        document.getElementById('form-method').value = 'PUT';
        
        document.getElementById('field-name').value = user.name || '';
        document.getElementById('field-email').value = user.email || '';
        document.getElementById('field-role').value = user.role || 'admin';
        
        // Password optional
        document.getElementById('password-label').textContent = 'Ganti Password (Opsional)';
        document.getElementById('password-help').textContent = 'Biarkan kosong jika tidak ingin mengubah password.';
        document.getElementById('field-password').required = false;
    } else {
        // Create mode
        document.getElementById('modal-title').textContent = 'Tambah Pengguna';
        document.getElementById('modal-sub').textContent = 'Daftarkan akun admin / editor baru';
        document.getElementById('submit-btn').textContent = 'Simpan';
        
        form.action = '{{ route('admin.users.store') }}';
        document.getElementById('form-method').value = 'POST';
        
        document.getElementById('password-label').textContent = 'Password';
        document.getElementById('password-help').textContent = 'Minimal 8 karakter.';
        document.getElementById('field-password').required = true;
    }
    
    backdrop.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    backdrop.classList.remove('open');
    document.body.style.overflow = '';
}

function handleBackdropClick(e) {
    if (e.target === backdrop) closeModal();
}

// Keyboard ESC
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });
</script>
@endpush

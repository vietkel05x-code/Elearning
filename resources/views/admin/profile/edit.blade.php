@extends('layouts.admin')

@section('title', 'Chỉnh sửa thông tin')
@section('page-title', 'Chỉnh sửa thông tin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/admin.css') }}">
@endpush

@section('content')
<div class="admin-form-page admin-form-page--narrow">
  <div class="admin-profile-edit-form">
    <h2 class="admin-profile-edit-form__title">Chỉnh sửa thông tin cá nhân</h2>

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      @php
        $adminUser = \App\Helpers\AdminHelper::user();
      @endphp
      <!-- Avatar Upload -->
      <div class="admin-profile-avatar-section admin-mb--xl">
        <div class="admin-profile-avatar" style="width: 120px; height: 120px; margin-bottom: var(--spacing-md);">
          @if($adminUser && $adminUser->avatar)
            <img src="{{ $adminUser->avatar_url }}" alt="Avatar" id="avatarPreview">
          @else
            <span id="avatarPreview" style="font-size: 50px;">{{ $adminUser ? strtoupper(substr($adminUser->name, 0, 1)) : 'A' }}</span>
          @endif
        </div>
        <label for="avatar" class="admin-profile-avatar-upload">
          <i class="fas fa-camera" style="margin-right: var(--spacing-sm);"></i>
          Chọn ảnh đại diện
        </label>
        <input type="file" name="avatar" id="avatar" accept="image/*" onchange="previewAvatar(this)">
      </div>

      <!-- Name -->
      <div class="admin-profile-edit-form__field">
        <label class="admin-profile-edit-form__label" for="name">Họ và tên *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $adminUser ? $adminUser->name : '') }}" required
               class="admin-profile-edit-form__input">
        @error('name')
          <div class="admin-profile-edit-form__error">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Email -->
      <div class="admin-profile-edit-form__field">
        <label class="admin-profile-edit-form__label" for="email">Email *</label>
        <input type="email" name="email" id="email" value="{{ old('email', $adminUser ? $adminUser->email : '') }}" required
               class="admin-profile-edit-form__input">
        @error('email')
          <div class="admin-profile-edit-form__error">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Current Password -->
      <div class="admin-profile-edit-form__field">
        <label class="admin-profile-edit-form__label" for="current_password">Mật khẩu hiện tại</label>
        <input type="password" name="current_password" id="current_password"
               class="admin-profile-edit-form__input" placeholder="Chỉ điền nếu muốn đổi mật khẩu">
        <small class="admin-profile-edit-form__help">Để trống nếu không muốn đổi mật khẩu</small>
        @error('current_password')
          <div class="admin-profile-edit-form__error">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
          </div>
        @enderror
      </div>

      <!-- New Password -->
      <div class="admin-profile-edit-form__field">
        <label class="admin-profile-edit-form__label" for="new_password">Mật khẩu mới</label>
        <input type="password" name="new_password" id="new_password"
               class="admin-profile-edit-form__input" placeholder="Tối thiểu 8 ký tự">
        @error('new_password')
          <div class="admin-profile-edit-form__error">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
          </div>
        @enderror
      </div>

      <!-- Confirm Password -->
      <div class="admin-profile-edit-form__field">
        <label class="admin-profile-edit-form__label" for="new_password_confirmation">Xác nhận mật khẩu mới</label>
        <input type="password" name="new_password_confirmation" id="new_password_confirmation"
               class="admin-profile-edit-form__input" placeholder="Nhập lại mật khẩu mới">
      </div>

      <!-- Buttons -->
      <div class="admin-profile-edit-form__actions">
        <a href="{{ route('admin.profile.show') }}" class="btn btn--outline admin-form-actions__button admin-flex admin-flex--center">
          <i class="fas fa-times"></i>
          <span>Hủy</span>
        </a>
        <button type="submit" class="btn btn--primary admin-form-actions__button admin-flex admin-flex--center">
          <i class="fas fa-save"></i>
          <span>Lưu thay đổi</span>
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                preview.outerHTML = '<img src="' + e.target.result + '" alt="Avatar Preview" id="avatarPreview" style="width: 100%; height: 100%; object-fit: cover;">';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection

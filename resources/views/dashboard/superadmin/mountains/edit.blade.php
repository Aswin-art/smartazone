@extends('dashboard.layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">
                                    <i class="icon-base ri ri-pencil-line icon-22px me-2"></i>
                                    Edit Data Gunung
                                </h5>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a
                                                href="{{ route('superadmin.mountains.index') }}">Gunung</a></li>
                                        <li class="breadcrumb-item active">Edit</li>
                                    </ol>
                                </nav>
                            </div>
                            <div>
                                <a href="{{ route('superadmin.mountains.index') }}" class="btn btn-secondary">
                                    <i class="ri ri-arrow-left-line me-1"></i> Kembali
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <div class="fw-bold mb-2">Periksa kembali input Anda:</div>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $e)
                                            <li>{{ $e }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('superadmin.mountains.update', $mountain->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Gunung</label>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name', $mountain->name) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Lokasi</label>
                                            <input type="text" class="form-control" name="location"
                                                value="{{ old('location', $mountain->location) }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Subdomain (opsional)</label>
                                            <input type="text" class="form-control" name="subdomains"
                                                value="{{ old('subdomains', $mountain->subdomains ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            @php $s = old('status', $mountain->status); @endphp
                                            <select class="form-select" name="status" required>
                                                <option value="active" {{ $s === 'active' ? 'selected' : '' }}>Active
                                                </option>
                                                <option value="inactive" {{ $s === 'inactive' ? 'selected' : '' }}>Inactive
                                                </option>
                                                <option value="pending" {{ $s === 'pending' ? 'selected' : '' }}>Pending
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="description" rows="4" required>{{ old('description', $mountain->description) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Banner Image</label>
                                            <input type="file" class="form-control" name="banner_image" id="bannerImageInput" accept="image/*">

                                            <!-- Preview Container -->
                                            <div id="bannerPreviewContainer" class="mt-2">
                                                @if ($mountain->banner_image_url)
                                                    <div class="position-relative d-inline-block banner-preview-item">
                                                        <img src="{{ $mountain->banner_image_url }}"
                                                            class="img-fluid rounded border" style="max-height: 150px;">
                                                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-existing-banner"
                                                            style="padding: 0.25rem 0.5rem; line-height: 1;">
                                                            <i class="ri ri-close-line"></i>
                                                        </button>
                                                        <input type="hidden" name="remove_banner" id="removeBannerFlag" value="0">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Konten</label>
                                            <textarea class="form-control" name="content" rows="3">{{ old('content', $mountain->content) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Gallery Images</label>
                                    <input type="file" class="form-control" name="gallery[]" id="galleryInput" multiple accept="image/*">

                                    <!-- Preview Container -->
                                    <div id="galleryPreviewContainer" class="d-flex flex-wrap gap-2 mt-2">
                                        @if (!empty($mountain->gallery))
                                            @foreach (json_decode($mountain->gallery, true) ?? [] as $index => $img)
                                                <div class="position-relative gallery-existing-item" data-index="{{ $index }}">
                                                    <img src="{{ $img }}" class="img-thumbnail rounded"
                                                        style="max-height:100px; max-width:100px; object-fit:cover;">
                                                    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-existing-gallery"
                                                        data-index="{{ $index }}"
                                                        style="padding: 0.25rem 0.5rem; line-height: 1;">
                                                        <i class="ri ri-close-line"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <input type="hidden" name="remove_gallery" id="removeGalleryFlag" value="">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">FAQ (JSON array of {question, answer})</label>
                                    <textarea class="form-control font-monospace" name="faq" rows="6"
                                        placeholder='[{"question":"...","answer":"..."}]'>{{ old('faq', $mountain->faq_json) }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Elevation (m)</label>
                                            <input type="number" step="1" class="form-control" name="meta[elevation]"
                                                value="{{ old('meta.elevation', optional(json_decode($mountain->meta ?? '{}'))->elevation) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Difficulty</label>
                                            @php $md = old('meta.difficulty', optional(json_decode($mountain->meta ?? '{}'))->difficulty); @endphp
                                            <select class="form-select" name="meta[difficulty]">
                                                <option value="">—</option>
                                                <option value="easy" {{ $md === 'easy' ? 'selected' : '' }}>Easy
                                                </option>
                                                <option value="moderate" {{ $md === 'moderate' ? 'selected' : '' }}>
                                                    Moderate</option>
                                                <option value="hard" {{ $md === 'hard' ? 'selected' : '' }}>Hard
                                                </option>
                                                <option value="expert" {{ $md === 'expert' ? 'selected' : '' }}>Expert
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Estimated Duration</label>
                                            <input type="text" class="form-control" name="meta[estimated_duration]"
                                                placeholder="e.g., 3 days"
                                                value="{{ old('meta.estimated_duration', optional(json_decode($mountain->meta ?? '{}'))->estimated_duration) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Meta (JSON object)</label>
                                    <textarea class="form-control font-monospace" name="meta_json" rows="5" readonly>{{ json_encode(json_decode($mountain->meta ?? '{}'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</textarea>
                                </div>


                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="icon-base ri ri-save-line me-1"></i> Simpan Perubahan
                                    </button>
                                    <a href="{{ route('superadmin.mountains.index') }}" class="btn btn-secondary">
                                        <i class="icon-base ri ri-arrow-left-line me-1"></i> Batal
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl">
                <div
                    class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                    <div class="mb-2 mb-md-0">
                        &#169;
                        <script>
                            document.write(new Date().getFullYear());
                        </script>, Mountain Management System
                    </div>
                </div>
            </div>
        </footer>

        <div class="content-backdrop fade"></div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Banner Image Preview
    $('#bannerImageInput').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $('#bannerPreviewContainer').html(`
                    <div class="position-relative d-inline-block banner-preview-item">
                        <img src="${event.target.result}" class="img-fluid rounded border" style="max-height: 150px;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-banner-preview"
                            style="padding: 0.25rem 0.5rem; line-height: 1;">
                            <i class="ri ri-close-line"></i>
                        </button>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        }
    });

    // Remove new banner preview
    $(document).on('click', '.remove-banner-preview', function() {
        $('#bannerImageInput').val('');
        $('#bannerPreviewContainer').html('');
    });

    // Remove existing banner
    $(document).on('click', '.remove-existing-banner', function() {
        $('#removeBannerFlag').val('1');
        $(this).closest('.banner-preview-item').fadeOut(300, function() {
            $(this).remove();
        });
    });

    // Gallery Images Preview
    let removedGalleryIndices = [];

    $('#galleryInput').on('change', function(e) {
        const files = e.target.files;

        // Remove old new previews (keep existing ones)
        $('.gallery-new-item').remove();

        $.each(files, function(index, file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $('#galleryPreviewContainer').append(`
                    <div class="position-relative gallery-new-item">
                        <img src="${event.target.result}" class="img-thumbnail rounded"
                            style="max-height:100px; max-width:100px; object-fit:cover;">
                        <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 remove-gallery-preview"
                            style="padding: 0.25rem 0.5rem; line-height: 1;">
                            <i class="ri ri-close-line"></i>
                        </button>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    });

    // Remove new gallery preview
    $(document).on('click', '.remove-gallery-preview', function() {
        $('#galleryInput').val('');
        $('.gallery-new-item').remove();
    });

    // Remove existing gallery item
    $(document).on('click', '.remove-existing-gallery', function() {
        const index = $(this).data('index');
        removedGalleryIndices.push(index);
        $('#removeGalleryFlag').val(removedGalleryIndices.join(','));

        $(this).closest('.gallery-existing-item').fadeOut(300, function() {
            $(this).remove();
        });
    });
});
</script>
@endpush

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
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('superadmin.mountains.index') }}">Gunung</a>
                                    </li>
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

                        <form method="POST" action="{{ route('superadmin.mountains.update', $mountain->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Gunung</label>
                                    <input type="text" name="name" class="form-control" required
                                           value="{{ old('name', $mountain->name) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="location" class="form-control" required
                                           value="{{ old('location', $mountain->location) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Subdomain (opsional)</label>
                                    <input type="text" name="subdomains" class="form-control"
                                           value="{{ old('subdomains', $mountain->subdomains ?? '') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status</label>
                                    @php $s = old('status', $mountain->status); @endphp
                                    <select class="form-select" name="status" required>
                                        <option value="active" {{ $s === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $s === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="pending" {{ $s === 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea name="description" class="form-control" rows="4" required>{{ old('description', $mountain->description) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Banner Image</label>
                                    <input type="file" class="form-control" id="bannerImageInput" name="banner_image" accept="image/*">
                                    <div id="bannerPreview" class="mt-2">
                                        @if ($mountain->banner_image_url)
                                            <div class="position-relative d-inline-block" data-existing="true" data-url="{{ $mountain->banner_image_url }}">
                                                <img src="{{ $mountain->banner_image_url }}" class="img-fluid rounded border w-100" style="max-width:250px;">
                                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-banner" style="border-radius:50%;background:rgba(0,0,0,0.6);border:none;">✕</button>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="hidden" name="keep_banner" id="keepBannerInput" value="{{ $mountain->banner_image_url ? '1' : '0' }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Konten</label>
                                    <textarea name="content" class="form-control" rows="3">{{ old('content', $mountain->content) }}</textarea>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Gallery Images</label>
                                <input type="file" class="form-control" id="galleryInput" name="gallery[]" multiple accept="image/*">
                                <div id="galleryPreview" class="d-flex flex-wrap gap-2 mt-2">
                                    @php $existingGallery = json_decode($mountain->gallery ?? '[]', true); @endphp
                                    @foreach ($existingGallery as $img)
                                        <div class="position-relative d-inline-block gallery-item" data-existing="true" data-url="{{ $img }}">
                                            <img src="{{ $img }}" class="img-thumbnail rounded" style="max-height:100px;max-width:100px;object-fit:cover;">
                                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-gallery" style="border-radius:50%;background:rgba(0,0,0,0.6);border:none;">✕</button>
                                        </div>
                                    @endforeach
                                </div>
                                <input type="hidden" name="keep_gallery" id="keepGalleryInput" value="{{ json_encode($existingGallery) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">FAQ (JSON array of {question, answer})</label>
                                <textarea class="form-control font-monospace" name="faq" rows="6" placeholder='[{"question":"...","answer":"..."}]'>{{ old('faq', $mountain->faq_json) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Elevation (m)</label>
                                    <input type="number" step="1" name="meta[elevation]" class="form-control"
                                           value="{{ old('meta.elevation', optional(json_decode($mountain->meta ?? '{}'))->elevation) }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Difficulty</label>
                                    @php $md = old('meta.difficulty', optional(json_decode($mountain->meta ?? '{}'))->difficulty); @endphp
                                    <select class="form-select" name="meta[difficulty]">
                                        <option value="">—</option>
                                        <option value="easy" {{ $md === 'easy' ? 'selected' : '' }}>Easy</option>
                                        <option value="moderate" {{ $md === 'moderate' ? 'selected' : '' }}>Moderate</option>
                                        <option value="hard" {{ $md === 'hard' ? 'selected' : '' }}>Hard</option>
                                        <option value="expert" {{ $md === 'expert' ? 'selected' : '' }}>Expert</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Estimated Duration</label>
                                    <input type="text" name="meta[estimated_duration]" class="form-control" placeholder="e.g., 3 days"
                                           value="{{ old('meta.estimated_duration', optional(json_decode($mountain->meta ?? '{}'))->estimated_duration) }}">
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri ri-save-line me-1"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('superadmin.mountains.index') }}" class="btn btn-secondary">
                                    <i class="ri ri-arrow-left-line me-1"></i> Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    $('#bannerImageInput').on('change', function(e){
        const file = e.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(evt){
            $('#bannerPreview').html(`
                <div class="position-relative d-inline-block">
                    <img src="${evt.target.result}" class="img-fluid rounded border w-100" style="max-width:250px;">
                    <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-banner" style="border-radius:50%;background:rgba(0,0,0,0.6);border:none;">✕</button>
                </div>
            `);
            $('#keepBannerInput').val('0');
        };
        reader.readAsDataURL(file);
    });

    $(document).on('click', '.remove-banner', function(){
        $('#bannerPreview').empty();
        $('#bannerImageInput').val('');
        $('#keepBannerInput').val('0');
    });

    $('#galleryInput').on('change', function(e){
        const files = Array.from(e.target.files);
        const preview = $('#galleryPreview');
        files.forEach(file=>{
            const reader = new FileReader();
            reader.onload = function(evt){
                const img = `
                    <div class="position-relative d-inline-block gallery-item" data-existing="false">
                        <img src="${evt.target.result}" class="img-thumbnail rounded" style="max-height:100px;max-width:100px;object-fit:cover;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 remove-gallery" style="border-radius:50%;background:rgba(0,0,0,0.6);border:none;">✕</button>
                    </div>
                `;
                preview.append(img);
            };
            reader.readAsDataURL(file);
        });
    });

    $(document).on('click', '.remove-gallery', function(){
        const item = $(this).closest('.gallery-item');
        const url = item.data('url');
        const keepInput = $('#keepGalleryInput');
        let kept = [];
        try { kept = JSON.parse(keepInput.val() || '[]'); } catch(e) {}
        if (item.data('existing') && url) {
            kept = kept.filter(u => u !== url);
            keepInput.val(JSON.stringify(kept));
        }
        item.remove();
    });
});
</script>
@endsection

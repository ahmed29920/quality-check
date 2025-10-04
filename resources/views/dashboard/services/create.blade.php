@extends('dashboard.layouts.app')

@section('title', 'Create Service')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent">
                <h4 class="mb-0 text-purple fw-bold">Create New Service</h4>
                <small class="text-muted">Add service details and associated MCQ questions</small>
            </div>
        </div>

        {{-- Service Form --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h5 class="fw-bold mb-4 text-purple">
                        <i class="fas fa-cogs"></i> Service Information
                    </h5>

                    <div class="row">
                        <div class="col-md-8">
                            {{-- Service Name (EN) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Service Name (EN)<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name[en]') is-invalid @enderror" 
                                       name="name[en]" value="{{ old('name[en]') }}" placeholder="Enter service name in English" required>
                                @error('name[en]')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Service Name (AR) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Service Name (AR)<span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name[ar]') is-invalid @enderror" 
                                       name="name[ar]" value="{{ old('name[ar]') }}" placeholder="أدخل اسم الخدمة بالعربية" required dir="rtl">
                                @error('name[ar]')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Service Description (EN) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description (EN)</label>
                                <textarea class="form-control @error('description[en]') is-invalid @enderror" 
                                          name="description[en]" rows="4" placeholder="Enter service description in English">{{ old('description[en]') }}</textarea>
                                @error('description[en]')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Service Description (AR) --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description (AR)</label>
                                <textarea class="form-control @error('description[ar]') is-invalid @enderror" 
                                          name="description[ar]" rows="4" placeholder="أدخل وصف الخدمة بالعربية" dir="rtl">{{ old('description[ar]') }}</textarea>
                                @error('description[ar]')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            {{-- Service Image --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Service Image</label>
                                <div class="upload-area border-dashed border-2 p-4 text-center position-relative"
                                    onclick="document.getElementById('imageInput').click()">

                                    <div id="uploadPlaceholder">
                                        <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Click to upload image</p>
                                        <small class="text-muted">Max 2MB (JPEG, PNG, JPG, GIF)</small>
                                    </div>

                                    <img id="imagePreview" src="" alt="Preview"
                                        class="img-fluid rounded d-none w-100 h-100"
                                        style="object-fit: contain; max-height: 200px;">

                                    <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                                </div>

                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Service Category --}}
                            <div class="col-md-12 mt-2 mb-3">
                                <label class="form-label fw-bold">Service Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-control select2 p-3 @error('category_id') is-invalid @enderror">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            


                            {{-- Active Status --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold">Status</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }} id="is_active">
                                    <label class="form-check-label" for="is_active">
                                        Active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-purple">
                            <i class="fas fa-save"></i> Create Service
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
              document.getElementById('imageInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const placeholder = document.getElementById('uploadPlaceholder');
                    const imgTag = document.getElementById('imagePreview');

                    placeholder.style.display = "none";
                    imgTag.classList.remove("d-none");
                    imgTag.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush
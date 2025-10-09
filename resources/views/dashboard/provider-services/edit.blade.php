@extends('dashboard.layouts.app')

@section('title', 'Edit Provider Service - ' . $providerService->service->name)

@section('content')
    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0 text-info fw-bold">Edit Provider Service</h4>
                        <small class="text-muted">Update provider service information</small>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.provider-services.show', $providerService->id) }}"
                                class="btn btn-outline-info">
                                <i class="fas fa-eye"></i> View Service
                            </a>
                            <a href="{{ route('admin.provider-services.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Form --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.provider-services.update', $providerService) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        {{-- Left Column --}}
                        <div class="col-md-8">
                            {{-- Service Information --}}
                            <div class="card border-0 shadow mb-4">
                                <div class="card-body">
                                    <h5 class="fw-bold text-dark mb-3">
                                        <i class="fas fa-cogs text-info me-2"></i>Service Information
                                    </h5>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="service_id" class="form-label fw-bold">Service <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select @error('service_id') is-invalid @enderror"
                                                    id="service_id" name="service_id" required>
                                                    <option value="">Select Service</option>
                                                    @foreach ($services as $service)
                                                        <option value="{{ $service->id }}"
                                                            {{ old('service_id', $providerService->service_id) == $service->id ? 'selected' : '' }}>
                                                            {{ $service->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('service_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="provider_id" class="form-label fw-bold">Provider <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select @error('provider_id') is-invalid @enderror"
                                                    id="provider_id" name="provider_id" required>
                                                    <option value="">Select Provider</option>
                                                    @foreach ($providers as $provider)
                                                        <option value="{{ $provider->id }}"
                                                            {{ old('provider_id', $providerService->provider_id) == $provider->id ? 'selected' : '' }}>
                                                            {{ $provider->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('provider_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="price" class="form-label fw-bold">Price</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">$</span>
                                                    <input type="number" step="0.01" min="0"
                                                        class="form-control @error('price') is-invalid @enderror"
                                                        id="price" name="price"
                                                        value="{{ old('price', $providerService->price) }}">
                                                    @error('price')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Status</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" value="1" type="checkbox" id="is_active"
                                                        name="is_active"
                                                        {{ old('is_active', $providerService->is_active) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        Active Service
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description" class="form-label fw-bold">Description</label>
                                                <textarea class="form-control @error('description[en]') is-invalid @enderror" id="description" name="description[en]"
                                                    rows="4">{{ old('description[en]', $providerService->getTranslation('description', 'en')) }}</textarea>
                                                @error('description[en]')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description" class="form-label fw-bold">Description</label>
                                                <textarea class="form-control @error('description[ar]') is-invalid @enderror" id="description" name="description[ar]"
                                                    rows="4">{{ old('description[ar]', $providerService->getTranslation('description', 'ar')) }}</textarea>
                                                @error('description[ar]')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="col-md-4">
                            {{-- Service Image --}}
                            <div class="card border-0 shadow mb-4">
                                <div class="card-body">
                                    <h6 class="fw-bold text-dark mb-3">
                                        <i class="fas fa-image text-info me-2"></i>Service Image
                                    </h6>

                                    <div class="upload-area border-dashed border-2 p-4 text-center position-relative"
                                        onclick="document.getElementById('imageInput').click()">

                                        <!-- Current Image or Upload Placeholder -->
                                        <div id="uploadPlaceholder"
                                            style="{{ $providerService->image_url ? 'display: none;' : '' }}">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Click to upload image</p>
                                            <small class="text-muted">Max 2MB (JPEG, PNG, JPG, GIF)</small>
                                        </div>

                                        <!-- Current or New Image -->
                                        <img id="imagePreview" src="{{ $providerService->image_url }}" alt="Preview"
                                            class="img-fluid rounded {{ $providerService->image_url ? '' : 'd-none' }} w-100 h-100"
                                            style="object-fit: contain; max-height: 200px;">

                                        </img>
                                        <input type="file" name="image" id="imageInput" class="d-none"
                                            accept="image/*">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Buttons --}}
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.provider-services.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update Provider Service
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script>
        // Auto-update price format
        // document.getElementById('price').addEventListener('input', function(e) {
        //     let value = parseFloat(e.target.value);
        //     if (!isNaN(value) && value >= 0) {
        //         // Format to 2 decimal places
        //         e.target.value = value.toFixed(2);
        //     }
        // });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const serviceId = document.getElementById('service_id').value;
            const providerId = document.getElementById('provider_id').value;

            if (!serviceId || !providerId) {
                e.preventDefault();
                alert('Please select both service and provider.');
                return false;
            }
        });
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

@extends('dashboard.layouts.app')

@section('title', 'Create Provider Service')

@section('content')
<div class="container-fluid py-4">
    {{-- Header --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0 text-info fw-bold">Create Provider Service</h4>
                    <small class="text-muted">Add a new service for a provider</small>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.provider-services.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Create Form --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.provider-services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

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
                                            <label for="service_id" class="form-label fw-bold">Service <span class="text-danger">*</span></label>
                                            <select class="form-select @error('service_id') is-invalid @enderror" id="service_id" name="service_id" required>
                                                <option value="">Select Service</option>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
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
                                            <label for="provider_id" class="form-label fw-bold">Provider <span class="text-danger">*</span></label>
                                            <select class="form-select @error('provider_id') is-invalid @enderror" id="provider_id" name="provider_id" required>
                                                <option value="">Select Provider</option>
                                                @foreach($providers as $provider)
                                                    <option value="{{ $provider->id }}" {{ old('provider_id') == $provider->id ? 'selected' : '' }}>
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
                                                <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror"
                                                       id="price" name="price" value="{{ old('price') }}">
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
                                                <input class="form-check-input" value="1" type="checkbox" id="is_active" name="is_active"
                                                       {{ old('is_active', true) ? 'checked' : '' }}>
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
                                            <label for="description" class="form-label fw-bold">Description (EN)</label>
                                            <textarea class="form-control @error('description[en]') is-invalid @enderror"
                                                      id="description" name="description[en]" rows="4" placeholder="Describe the service...">{{ old('description[en]') }}</textarea>
                                            @error('description[en]')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description" class="form-label fw-bold">Description (AR)</label>
                                            <textarea class="form-control @error('description[ar]') is-invalid @enderror"
                                                      id="description" name="description[ar]" rows="4" placeholder="Describe the service...">{{ old('description[ar]') }}</textarea>
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

                                <div class="upload-area border-dashed border-2 p-4 text-center position-relative" onclick="document.getElementById('imageInput').click()">

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
                            </div>
                        </div>

                        {{-- Help Information --}}
                        <div class="card border-0 shadow">
                            <div class="card-body">
                                <h6 class="fw-bold text-dark mb-3">
                                    <i class="fas fa-question-circle text-info me-2"></i>Help
                                </h6>

                                <div class="mb-2">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Select a service and provider to create the relationship.
                                    </small>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-dollar-sign me-1"></i>
                                        Set a price for the service (optional).
                                    </small>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-image me-1"></i>
                                        Upload an image to represent the service.
                                    </small>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-toggle-on me-1"></i>
                                        Toggle the service active/inactive status.
                                    </small>
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
                                <i class="fas fa-plus"></i> Create Provider Service
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
        // Image preview
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

    </script>

@endpush

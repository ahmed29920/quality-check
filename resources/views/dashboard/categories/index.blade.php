@extends('dashboard.layouts.app')

@section('title', 'Categories')

@section('content')
<div class="container-fluid py-4">
    {{-- Header Card --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h4 class="mb-0 text-purple fw-bold">Categories</h4>
                    <small class="text-muted">Manage categories and their MCQ questions</small>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-purple">
                        <i class="fas fa-plus"></i> Create Category
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Categories Grid --}}
    @if($categories->count() > 0)
        <div class="row">
            @foreach($categories as $category)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card border-0 shadow-sm h-100">
                        {{-- Category Image --}}
                        @if($category->image_url)
                            <div class="position-relative">
                                <img src="{{ $category->image_url }}"
                                    alt="{{ $category->getTranslation('name', app()->getLocale()) }}"
                                    class="card-img-top" style="height: 200px; object-fit: cover;">
                                <div class="position-absolute top-0 start-0 m-2">
                                    @if($category->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                    @if(!$category->has_pricable_services)
                                        <span class="badge bg-warning">Paid</span>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                style="height: 200px;">
                                <i class="fas fa-folder fa-3x text-muted"></i>
                                <div class="position-absolute top-0 start-0 m-2">
                                    @if($category->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                    @if($category->has_pricable_services)
                                        <span class="badge bg-warning">Paid</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            {{-- Category Info --}}
                            <h5 class="card-title text-purple fw-bold">
                                {{ $category->getTranslation('name', app()->getLocale()) }}
                            </h5>
                            <p class="card-text text-muted">
                                {!! Str::limit(strip_tags($category->getTranslation('description', app()->getLocale())), 100) !!}

                            </p>

                            {{-- Pricing Info --}}
                            @if(!$category->has_pricable_services)
                                <div class="mb-3">
                                    @if($category->monthly_subscription_price)
                                        <small class="text-purple fw-bold">
                                            <i class="fas fa-calendar-alt"></i>
                                            Price Per Month: ${{ $category->monthly_subscription_price }}
                                        </small><br>
                                    @endif
                                    @if($category->yearly_subscription_price)
                                        <small class="text-purple fw-bold">
                                            <i class="fas fa-calendar-alt"></i>
                                            Price Per Year: ${{ $category->yearly_subscription_price }}
                                        </small>
                                    @endif
                                </div>
                            @endif

                            {{-- Questions Stats --}}
                            <div class="row text-center mb-3">
                                <div class="col-4">
                                    <div class="fw-bold text-purple">{{ $category->questions_count ?? 0 }}</div>
                                    <small class="text-muted">Questions</small>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold text-success">{{ $category->total_score ?? 0 }}</div>
                                    <small class="text-muted">Points</small>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold text-warning">
                                        {{ $category->created_at->diffForHumans() }}
                                    </div>
                                    <small class="text-muted">Created</small>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="mt-auto">
                                <div class="btn-group w-100" role="group">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger" onclick="deleteCategory({{ $category->id }})">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                {{-- MCQ Questions Link --}}
                                <a href="{{ route('admin.mcq-questions.index', ['category_id' => $category->id]) }}"
                                    class="btn btn-purple w-100 mt-2">
                                     Manage Questions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center">
            {{ $categories->links() }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body py-5">
                    <i class="fas fa-folder-plus fa-4x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">No Categories Yet</h3>
                    <p class="text-muted mb-4">Create your first quality check category to get started.</p>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-purple btn-lg">
                        <i class="fas fa-plus"></i> Create First Category
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function deleteCategory(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This will delete the category and all its questions.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/categories/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        Swal.fire(
                            'Deleted!',
                            'The category has been deleted.',
                            'success'
                        ).then(() => {
                            // Refresh page or remove row from table
                            location.reload();
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            'Something went wrong. Please try again.',
                            'error'
                        );
                    }
                })
                .catch(() => {
                    Swal.fire(
                        'Error!',
                        'Request failed. Please try again.',
                        'error'
                    );
                });
            }
        });
    }
</script>
@endpush

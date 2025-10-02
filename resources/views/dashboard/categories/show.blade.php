@extends('dashboard.layouts.app')

@section('title', 'Category Details')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4">
                {{-- Category Card --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-info fw-bold">Category Information</h5>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- Category Image --}}
                        @if ($category->image_url)
                            <img src="{{ $category->image_url }}"
                                alt="{{ $category->getTranslation('name', app()->getLocale()) }}"
                                class="img-fluid rounded mb-3">
                        @else
                            <div class="bg-light rounded p-5 text-center mb-3">
                                <i class="fas fa-folder fa-3x text-muted"></i>
                            </div>
                        @endif

                        {{-- Category Info --}}
                        <h4 class="fw-bold text-info mb-2">
                            {{ $category->getTranslation('name', app()->getLocale()) }}
                        </h4>

                        @if ($category->getTranslation('description', app()->getLocale()))
                            <p class="text-muted mb-3">
                                {!! strip_tags($category->getTranslation('description', app()->getLocale())) !!}
                            </p>
                        @endif

                        {{-- Status Badges --}}
                        <div class="mb-3">
                            @if ($category->is_active)
                                <span class="badge bg-success me-2">Active</span>
                            @else
                                <span class="badge bg-secondary me-2">Inactive</span>
                            @endif

                            @if (!$category->has_pricable_services)
                                <span class="badge bg-warning">Paid Category</span>
                            @endif
                        </div>

                        {{-- Pricing Info --}}
                        @if ($category->has_pricable_services)
                            <div class="border-top pt-3">
                                <h6 class="fw-bold text-success">Pricing</h6>
                                @if ($category->monthly_subscription_price)
                                    <p class="mb-1">
                                        <i class="fas fa-calendar-alt"></i>
                                        Monthly:
                                        <strong>${{ number_format($category->monthly_subscription_price, 2) }}</strong>
                                    </p>
                                @endif
                                @if ($category->yearly_subscription_price)
                                    <p class="mb-0">
                                        <i class="fas fa-calendar-year"></i>
                                        Yearly:
                                        <strong>${{ number_format($category->yearly_subscription_price, 2) }}</strong>
                                    </p>
                                @endif
                            </div>
                        @endif

                        {{-- Meta Info --}}
                        <div class="border-top pt-3 mt-3">
                            <small class="text-muted">
                                <i class="fas fa-calendar-plus"></i> Created:
                                {{ $category->created_at->format('M d, Y') }}<br>
                                <i class="fas fa-clock"></i> Updated: {{ $category->updated_at->format('M d, Y') }}
                            </small>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0 text-info fw-bold">Quick Actions</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i> Edit Category
                            </a>

                            <a href="{{ route('admin.mcq-questions.index', ['category_id' => $category->id]) }}"
                                class="btn btn-outline-info">
                                <i class="fas fa-question-circle"></i> Manage Questions
                            </a>

                            <a href="{{ route('admin.mcq-questions.create', ['category_id' => $category->id]) }}"
                                class="btn btn-outline-success">
                                <i class="fas fa-plus"></i> Add Question
                            </a>

                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                onsubmit="return confirm('Are you sure? This will delete the category and all its questions.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-trash"></i> Delete Category
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                {{-- Statistics --}}
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <h3 class="text-info fw-bold">{{ $category->questions_count ?? 0 }}</h3>
                                <p class="text-muted mb-0">Total Questions</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <h3 class="text-success fw-bold">{{ $category->total_score ?? 0 }}</h3>
                                <p class="text-muted mb-0">Total Points</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <h3 class="text-warning fw-bold">
                                    {{ $category->questions()->where('is_active', true)->count() }}</h3>
                                <p class="text-muted mb-0">Active Questions</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-0 shadow-sm text-center">
                            <div class="card-body">
                                <h3 class="text-primary fw-bold">
                                    {{ $category->questions()->where('allows_attachments', true)->count() }}</h3>
                                <p class="text-muted mb-0">With Attachments</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Questions List --}}
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-info fw-bold">MCQ Questions</h5>
                            <a href="{{ route('admin.mcq-questions.create', ['category_id' => $category->id]) }}"
                                class="btn btn-info btn-sm">
                                <i class="fas fa-plus"></i> Add Question
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($category->questions->count() > 0)
                            @foreach ($category->questions as $index => $question)
                                <div class="question-item border rounded p-3 mb-3">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div>
                                                    <h6 class="mb-1 text-info fw-bold">
                                                        Question {{ $index + 1 }}
                                                        @if (!$question->is_active)
                                                            <span class="badge bg-secondary ms-2">Inactive</span>
                                                        @endif
                                                    </h6>
                                                    <span class="text-muted small">
                                                        Order: {{ $question->sort_order }}
                                                        | Score: {{ $question->score }} pts
                                                    </span>
                                                </div>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('admin.mcq-questions.edit', $question) }}"
                                                        class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                                        onclick="deleteQuestion({{ $question->id }})">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <p class="mb-2">{{ $question->title }}</p>

                                            <div class="options-preview">
                                                <small class="text-muted">Options:</small>
                                                <div class="d-flex flex-wrap gap-1 mt-1">
                                                    @foreach ($question->options as $option)
                                                        <span class="badge bg-light text-dark">
                                                            {{ chr(65 + $loop->index) }}. {{ $option }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 text-end">
                                            <div class="question-meta">
                                                @if ($question->allows_attachments)
                                                    <span class="badge bg-primary mb-1">
                                                        {{ $question->requires_attachment ? 'Required' : 'Optional' }}
                                                        Attachments
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary mb-1">No Attachments</span>
                                                @endif

                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        Added: {{ $question->created_at->format('M d, Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No Questions Yet</h5>
                                <p class="text-muted">This category doesn't have any MCQ questions.</p>
                                <a href="{{ route('admin.mcq-questions.create', ['category_id' => $category->id]) }}"
                                    class="btn btn-info">
                                    <i class="fas fa-plus"></i> Add First Question
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function deleteQuestion(questionId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the question and all its options.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete Question',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/admin/mcq-questions/${questionId}`, {
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
                                    'The question has been deleted.',
                                    'success'
                                ).then(() => {
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
                        .catch(error => {
                            Swal.fire('Error deleting question.', error.message, 'error');
                        });
                }
            });
        }
    </script>
@endpush

@extends('dashboard.layouts.app')

@section('title', 'MCQ Questions')

@section('content')
    <div class="container-fluid py-4">
        {{-- Filter Card --}}
        <div class="card border-0 col-12 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0 text-purple fw-bold">
                            MCQ Questions
                            @if ($category)
                                <small class="text-muted">for
                                    {{ $category->getTranslation('name', app()->getLocale()) }}</small>
                            @endif
                        </h4>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2 justify-content-end">
                            <form method="GET" class="d-inline">
                                <select name="category_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            @if ($category && $category->id == $cat->id) selected @endif>
                                            {{ $cat->getTranslation('name', app()->getLocale()) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                            <a href="{{ route('admin.mcq-questions.create', $category ? ['category_id' => $category->id] : []) }}"
                                class="btn btn-purple">
                                <i class="fas fa-plus"></i> Add Question
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Questions List --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if ($questions->count() > 0)
                    <div class="table-responsive">
                        <table id="questionsTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Category</th>
                                    <th>Title</th>
                                    <th>Options Count</th>
                                    <th>Order</th>
                                    <th>Score</th>
                                    <th>Attachments</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($questions as $index => $question)
                                    <tr id="row-{{ $question->id }}">
                                        <td>{{ $questions->firstItem() + $index }}</td>
                                        <td>{{ $question->title }}</td>
                                        <td>{{ $question->category->getTranslation('name', app()->getLocale()) }}</td>
                                        <td>{{ $question->title }}</td>
                                        <td>{{ count($question->options) }}</td>
                                        <td>{{ $question->sort_order }}</td>
                                        <td>{{ $question->score }} pts</td>
                                        <td>
                                            @if ($question->allows_attachments)
                                                <span class="badge bg-purple">
                                                    {{ $question->requires_attachment ? 'Required' : 'Optional' }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">None</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $question->is_active ? 'bg-success' : 'bg-secondary' }}"
                                                id="status-{{ $question->id }}">
                                                {{ $question->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.mcq-questions.edit', $question) }}"
                                                    class="btn btn-outline-primary edit-btn" data-id="{{ $question->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-warning status-btn"
                                                    data-id="{{ $question->id }}">
                                                    <i class="fas fa-{{ $question->is_active ? 'pause' : 'play' }}"></i>
                                                </button>
                                                <button class="btn btn-outline-danger delete-btn"
                                                    data-id="{{ $question->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>


                @else
                    <div class="text-center py-5">
                        <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No MCQ questions found</h5>
                        <p class="text-muted">
                            @if ($category)
                                No questions have been created for this category yet.
                            @else
                                No MCQ questions have been created yet.
                            @endif
                        </p>
                        <a href="{{ route('admin.mcq-questions.create', $category ? ['category_id' => $category->id] : []) }}"
                            class="btn btn-info">
                            <i class="fas fa-plus"></i> Create First Question
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            let table = $('#questionsTable').DataTable();

            // Delete Row
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "This will delete the question permanently.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/admin/mcq-questions/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                table.row($('#row-' + id)).remove().draw();
                                Swal.fire("Deleted!", "The question has been deleted.",
                                    "success");
                            }
                        });
                    }
                });
            });

            // Change Status
            $(document).on('click', '.status-btn', function() {
                let id = $(this).data('id');
                $.ajax({
                    url: `/admin/mcq-questions/${id}/toggle-status`,
                    type: 'PATCH',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        // Update Badge Text
                        let badge = $('#status-' + id);
                        if (res.is_active) {
                            badge.removeClass('bg-secondary').addClass('bg-success').text('Active');
                            console.log( $(this).find('i'))
                            $(this).find('i').removeClass('fa-pause').addClass('fa-play');
                        } else {
                            badge.removeClass('bg-success').addClass('bg-secondary').text('Inactive');
                            $(this).find('i').removeClass('fa-play').addClass('fa-pause');
                            console.log( $(this).find('i'))
                        }
                        Swal.fire("Updated!", "Status has been changed.", "success");
                    }
                });
            });

        });
    </script>
@endpush

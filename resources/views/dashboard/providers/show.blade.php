@extends('dashboard.layouts.app')

@section('title', 'Provider Details - ' . $provider->name)

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Card --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            @if ($provider->image)
                                <img src="{{ $provider->image_url }}" alt="{{ $provider->name }}" class="rounded-circle me-3"
                                    style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="  shadow rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 60px; height: 60px;">
                                    <i class="fas fa-user fa-2x text-muted"></i>
                                </div>
                            @endif
                            <div>
                                <h4 class="mb-0 text-info fw-bold">{{ $provider->name }}</h4>
                                <small class="text-muted">Provider ID: {{ $provider->id }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="d-flex gap-2 justify-content-end">
                            <button class="btn {{ $provider->is_active ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                onclick="toggleProviderStatus({{ $provider->id }})">
                                <i class="fas fa-toggle-{{ $provider->is_active ? 'on' : 'off' }}"></i>
                                {{ $provider->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                            <button class="btn {{ $provider->is_verified ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                onclick="toggleProviderVerification({{ $provider->id }})">
                                <i class="fas fa-{{ $provider->is_verified ? 'times' : 'check' }}"></i>
                                {{ $provider->is_verified ? 'Unverify' : 'Verify' }}
                            </button>
                            <a href="{{ route('admin.providers.edit', $provider->slug) }}" class="btn btn-outline-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent p-0">
                <ul class="nav nav-tabs nav-tabs-custom" id="providerTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="information-tab" data-bs-toggle="tab"
                            data-bs-target="#information" type="button" role="tab" aria-controls="information"
                            aria-selected="true">
                            <i class="fas fa-info-circle me-2"></i>Information
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="answers-tab" data-bs-toggle="tab" data-bs-target="#answers"
                            type="button" role="tab" aria-controls="answers" aria-selected="false">
                            <i class="fas fa-clipboard-list me-2"></i>Answers
                            <span class="badge bg-info ms-2">{{ $stats['total_answers'] }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="services-tab" data-bs-toggle="tab" data-bs-target="#services"
                            type="button" role="tab" aria-controls="services" aria-selected="false">
                            <i class="fas fa-cogs me-2"></i>Services
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="providerTabsContent">
                    {{-- Information Tab --}}
                    <div class="tab-pane fade show active" id="information" role="tabpanel"
                        aria-labelledby="information-tab">
                        <div class="row">
                            <div class="col-md-8">
                                {{-- Business Information --}}
                                <div class="card border-0 shadow mb-4">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-dark mb-3">
                                            <i class="fas fa-building text-info me-2"></i>Business Information
                                        </h5>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Description</h6>
                                                    <p class="mb-0">{!! $provider->description ?? '--' !!}</p>
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Address</h6>
                                                    <p class="mb-0">
                                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                                        {{ $provider->address ?? '--' }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Website</h6>
                                                    <p class="mb-0">
                                                        <a href="{{ $provider->website_link }}" target="_blank"
                                                            class="text-decoration-none">
                                                            <i class="fas fa-globe text-primary me-1"></i>
                                                            {{ $provider->website_link ?? '--' }}
                                                        </a>
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Established</h6>
                                                    <p class="mb-0">
                                                        <i class="fas fa-calendar text-success me-1"></i>
                                                        {{ $provider->established_date?->format('M d, Y') ?? '--' }}
                                                    </p>
                                                </div>

                                                <div class="mb-3">
                                                    <h6 class="fw-bold text-muted mb-1">Business Hours</h6>
                                                    <p class="mb-0">
                                                        <i class="fas fa-clock text-warning me-1"></i>
                                                        {{ $provider->start_time }} - {{ $provider->end_time }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Category & Badge --}}
                                <div class="card border-0 shadow mb-4">
                                    <div class="card-body">
                                        <h5 class="fw-bold text-dark mb-3">
                                            <i class="fas fa-tags text-info me-2"></i>Category & Badge
                                        </h5>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-muted mb-2">Category</h6>
                                                @if ($provider->category)
                                                    <span class="badge bg-info fs-6">
                                                        <i class="fas fa-tag me-1"></i>{{ $provider->category->name }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary fs-6">
                                                        <i class="fas fa-times me-1"></i>No Category
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-muted mb-2">Badge</h6>
                                                @if ($provider->badge)
                                                    <span class="badge bg-success fs-6">
                                                        <i class="fas fa-award me-1"></i>{{ $provider->badge->name }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary fs-6">
                                                        <i class="fas fa-times me-1"></i>No Badge
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Files (image and pdf) --}}
                                <div class="card border-0 shadow mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-muted mb-2">Image</h6>
                                                @if ($provider->image)
                                                    <span class="badge bg-success fs-6">
                                                        <i class="fas fa-image me-1"></i>
                                                        <a href="{{ $provider->image_url }}" target="_blank">
                                                            Download Image
                                                        </a>
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary fs-6">
                                                        <i class="fas fa-times me-1"></i>No Image
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold text-muted mb-2">PDF</h6>
                                                @if ($provider->pdf)
                                                    <span class="badge bg-success fs-6">
                                                        <i class="fas fa-file-pdf me-1"></i>
                                                        <a href="{{ $provider->pdf_url }}" target="_blank">
                                                            Download PDF
                                                        </a>
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary fs-6">
                                                        <i class="fas fa-times me-1"></i>No PDF
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                {{-- Status Cards --}}
                                <div class="card border-0 shadow mb-3">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bold text-dark mb-3">
                                            <i class="fas fa-shield-alt text-info me-2"></i>Account Status
                                        </h5>

                                        <div class="mb-3">
                                            @if ($provider->is_verified)
                                                <span class="badge bg-success fs-6 px-3 py-2">
                                                    <i class="fas fa-check me-1"></i>Verified Provider
                                                </span>
                                            @else
                                                <span class="badge bg-danger fs-6 px-3 py-2">
                                                    <i class="fas fa-times me-1"></i>Unverified Provider
                                                </span>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            @if ($provider->is_active)
                                                <span class="badge bg-success fs-6 px-3 py-2">
                                                    <i class="fas fa-toggle-on me-1"></i>Active Account
                                                </span>
                                            @else
                                                <span class="badge bg-danger fs-6 px-3 py-2">
                                                    <i class="fas fa-toggle-off me-1"></i>Inactive Account
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Score Summary --}}
                                @php
                                    $scoreSummary = app(
                                        \App\Services\ProviderAnswerService::class,
                                    )->getProviderScoreSummary($provider->id);
                                    $categoryStats = app(
                                        \App\Services\ProviderAnswerService::class,
                                    )->getProviderCategoryStats($provider->id);
                                @endphp
                                <div class="card border-0 shadow mb-3">
                                    <div class="card-body text-center">
                                        <h6 class="fw-bold text-dark mb-3">
                                            <i class="fas fa-chart-line text-info me-2"></i>Score Summary
                                        </h6>

                                        @if ($scoreSummary['total_answers'] > 0)
                                            <div class="mb-2">
                                                <h4 class="fw-bold text-primary mb-1">{{ $scoreSummary['percentage'] }}%
                                                </h4>
                                                <small class="text-muted">
                                                    {{ $scoreSummary['total_score'] }}/{{ $scoreSummary['max_possible_score'] }}
                                                    points
                                                </small>
                                            </div>

                                            <div class="mb-2">
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    {{ $scoreSummary['evaluated_answers'] }}/{{ $scoreSummary['total_answers'] }}
                                                    evaluated
                                                </small>
                                            </div>

                                            @if ($scoreSummary['pending_answers'] > 0)
                                                <div class="mb-2">
                                                    <small class="text-warning d-block">
                                                        <i class="fas fa-clock me-1"></i>
                                                        {{ $scoreSummary['pending_answers'] }} pending evaluation
                                                    </small>
                                                </div>
                                            @endif

                                            @if ($scoreSummary['is_complete'])
                                                <div class="alert alert-success py-2 mb-0">
                                                    <small><i class="fas fa-trophy me-1"></i>All questions
                                                        evaluated!</small>
                                                </div>
                                            @endif
                                        @else
                                            <p class="text-muted mb-0">No answers submitted yet</p>
                                        @endif
                                    </div>
                                </div>


                                {{-- Dates Information --}}
                                <div class="card border-0 shadow">
                                    <div class="card-body">
                                        <h6 class="fw-bold text-dark mb-3">
                                            <i class="fas fa-info-circle text-info me-2"></i>Dates Information
                                        </h6>

                                        <div class="mb-2">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-calendar-plus me-1"></i>
                                                <strong>Joined:</strong> {{ $provider->created_at->format('M d, Y') }}
                                            </small>
                                        </div>

                                        <div class="mb-2">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-clock me-1"></i>
                                                <strong>Last Updated:</strong>
                                                {{ $provider->updated_at->format('M d, Y') }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Answers Tab --}}
                    <div class="tab-pane fade" id="answers" role="tabpanel" aria-labelledby="answers-tab">
                        {{-- Statistics --}}
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card border-0 shadow text-center">
                                    <div class="card-body">
                                        <i class="fas fa-question-circle fa-2x text-info mb-2"></i>
                                        <h4 class="fw-bold text-info">{{ $stats['total_answers'] }}</h4>
                                        <small class="text-muted">Total Answers</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow text-center">
                                    <div class="card-body">
                                        <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                        <h4 class="fw-bold text-success">{{ $stats['evaluated_answers'] }}</h4>
                                        <small class="text-muted">Evaluated</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow text-center">
                                    <div class="card-body">
                                        <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                        <h4 class="fw-bold text-warning">{{ $stats['pending_answers'] }}</h4>
                                        <small class="text-muted">Pending</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card border-0 shadow text-center">
                                    <div class="card-body">
                                        <i class="fas fa-star fa-2x text-primary mb-2"></i>
                                        <h4 class="fw-bold text-primary">{{ $stats['average_score'] }}</h4>
                                        <small class="text-muted">Average Score</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Answers List --}}
                        <div class="card border-0 shadow">
                            <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                                <h5 class="mb-0 text-dark fw-bold">
                                    <i class="fas fa-clipboard-list me-2"></i>Provider Answers
                                </h5>
                                <span class="badge bg-info">
                                    Total: {{ $answers->total() }}
                                </span>
                            </div>

                            <div class="card-body">
                                @forelse($answers as $answer)
                                    <div class="border rounded-3 mb-3 p-3 bg-white">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div>
                                                <h6 class="fw-bold text-dark mb-1">
                                                    <i class="fas fa-question-circle text-info me-2"></i>
                                                    {{ $answer->question->title }}
                                                </h6>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-hashtag"></i> Question ID: {{ $answer->question_id }}
                                                </small>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-star text-warning"></i> Score:
                                                    {{ $answer->question->score }}
                                                </small>
                                            </div>

                                            <div class="text-end">
                                                @if ($answer->is_evaluated)
                                                    <span
                                                        class="badge {{ $answer->is_correct ? 'bg-success' : 'bg-danger' }}">
                                                        <i
                                                            class="fas fa-{{ $answer->is_correct ? 'check' : 'times' }}"></i>
                                                        {{ $answer->is_correct ? 'Correct' : 'Incorrect' }}
                                                    </span>
                                                    <span class="badge bg-info text-white">
                                                        <i class="fas fa-chart-line"></i>
                                                        {{ $answer->score }}/{{ $answer->question->score }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="fas fa-clock"></i> Pending Evaluation
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="ps-1">
                                            <p class="mb-2 text-dark">
                                                <strong>Answer:</strong> {{ $answer->answer }}
                                            </p>

                                            @if ($answer->attachment)
                                                <a href="{{ $answer->attachment_url }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-paperclip me-1"></i> View Attachment
                                                </a>
                                            @endif
                                        </div>

                                        <div
                                            class="d-flex justify-content-between align-items-center mt-3 border-top pt-2">
                                            <div>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    Submitted: {{ $answer->submitted_at->format('M d, Y H:i') }}
                                                    @if ($answer->evaluated_at)
                                                        <br>
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Evaluated: {{ $answer->evaluated_at->format('M d, Y H:i') }}
                                                    @endif
                                                </small>
                                            </div>

                                            @if (!$answer->is_evaluated)
                                                <form
                                                    action="{{ route('admin.providers.answers.evaluate', [$provider->id, $answer->id]) }}"
                                                    method="POST" class="mb-0">
                                                    @csrf
                                                    <div class="btn-group">
                                                        <button type="submit" name="is_correct" value="1"
                                                            class="btn btn-sm btn-outline-success">
                                                            <i class="fas fa-check"></i> Correct
                                                        </button>
                                                        <button type="submit" name="is_correct" value="0"
                                                            class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-times"></i> Incorrect
                                                        </button>
                                                    </div>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No answers submitted yet</h5>
                                    </div>
                                @endforelse

                                @if ($answers->hasPages())
                                    <div class="mt-4 d-flex justify-content-center">
                                        {{ $answers->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Services Tab (Future) --}}
                    <div class="tab-pane fade" id="services" role="tabpanel" aria-labelledby="services-tab">
                        @if ($provider->services->count() > 0)
                            <div class="card border-0 shadow">
                                <div class="card-body">
                                    <h5 class="fw-bold text-dark mb-3">
                                        <i class="fas fa-cogs me-2"></i>Services
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="border-0">Service</th>
                                                    <th class="border-0">Provider</th>
                                                    <th class="border-0">Price</th>
                                                    <th class="border-0">Status</th>
                                                    <th class="border-0">Created</th>
                                                    <th class="border-0 text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @include('dashboard.provider-services._rows', [
                                                    'providerServices' => $provider->services,
                                                ])
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-cogs fa-4x text-muted mb-3"></i>
                                <h4 class="text-muted mb-3">Services Management</h4>
                                <p class="text-muted">This feature will be available in a future update.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleProviderStatus(providerId) {
            fetch(`/admin/providers/${providerId}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update provider status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update provider status');
                });
        }

        function toggleProviderVerification(providerId) {
            fetch(`/admin/providers/${providerId}/toggle-verification`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update provider verification');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update provider verification');
                });
        }
    </script>
@endsection

@extends('dashboard.layouts.app')

@section('content')
<div class="container-fluid py-4">
            <div class="row mt-4">
                <div class="col-lg-12 mb-lg-0 mb-4">
                    <div class="card z-index-2 h-100">
                        <div class="card-header pb-0 pt-3 bg-transparent">
                            <h6 class="text-capitalize">{{ __('Settings') }}</h6>
                        </div>
                        <div class="card-body p-3">
                            <form action="{{ route('admin.settings.update') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- App Name --}}
                                <div class="form-group">
                                    <label for="name" class="form-control-label">App Name</label>
                                    <input class="form-control" id="name" type="text" name="app_name" value="{{ old('app_name', $settings['app_name'] ?? '') }}">
                                </div>

                                <div class="row">
                                    {{-- Logo --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="logo" class="form-control-label">App Logo</label>
                                            <input class="form-control" id="logo" type="file" name="app_logo">
                                            @if (!empty($settings['app_logo']))
                                                <img src="{{ asset('storage/' . $settings['app_logo']) }}" id="review_logo" alt="logo" class="mt-2" height="50">
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Icon --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="icon" class="form-control-label">App Icon</label>
                                            <input class="form-control" id="icon" type="file" name="app_icon">
                                            @if (!empty($settings['app_icon']))
                                                <img src="{{ asset('storage/' . $settings['app_icon']) }}" id="review_icon" alt="icon" class="mt-2" height="50">
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <button class="btn btn-purple mt-3" type="submit">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

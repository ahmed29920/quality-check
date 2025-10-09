<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\UpdateProviderRequest;
use App\Models\Provider;
use App\Services\ProviderService;
use App\Services\ProviderAnswerService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProviderController extends Controller
{
    protected $providerService;
    protected $providerAnswerService;

    public function __construct(ProviderService $providerService, ProviderAnswerService $providerAnswerService)
    {
        $this->providerService = $providerService;
        $this->providerAnswerService = $providerAnswerService;
    }

    /**
     * Display a listing of providers.
     */
    public function index(Request $request): View
    {
        $providers = $this->providerService->getAll($request);

        return view('dashboard.providers.index', compact('providers'));
    }

    /**
     * Filter providers via AJAX.
     */
    public function filter(Request $request)
    {
        $providers = $this->providerService->getAll($request);

        $html = view('dashboard.providers._rows', compact('providers'))->render();

        return response()->json(['html' => $html]);
    }

    /**
     * Display the specified provider with their answers.
     */
    public function show($slug)
    {
        $provider = $this->providerService->findBySlug($slug);

        if (!$provider) {
            abort(404, 'Provider not found');
        }

        // Get provider's answers with pagination
        $answers = $this->providerAnswerService->getByProvider($provider->id, 10);

        // Get statistics
        $stats = $this->providerAnswerService->getProviderStats($provider->id);


        return view('dashboard.providers.show', compact('provider', 'answers', 'stats'));
    }

    /**
     * Show the form for editing the specified provider.
     */
    public function edit($slug): View
    {
        $provider = $this->providerService->findBySlug($slug);

        if (!$provider) {
            abort(404, 'Provider not found');
        }

        // Get categories for dropdown
        $categories = \App\Models\Category::active()->get();
        $badges = \App\Models\Badge::all();

        return view('dashboard.providers.edit', compact('provider', 'categories', 'badges'));
    }

    /**
     * Update the specified provider in storage.
     */
    public function update(UpdateProviderRequest $request, string $id): RedirectResponse
    {
        try {
            $provider = $this->providerService->findById($id);

            if (!$provider) {
                return redirect()->back()->with('error', 'Provider not found');
            }

            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = $this->providerService->storeImage($request->file('image'), $provider->id);
            }

            // Handle PDF upload
            if ($request->hasFile('pdf')) {
                $data['pdf'] = $this->providerService->storePdf($request->file('pdf'), $provider->id);
            }

            $this->providerService->update($provider, $data);

            return redirect()->route('admin.providers.show', $provider->slug)
                ->with('success', 'Provider updated successfully');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update provider: ' . $e->getMessage());
        }
    }

    /**
     * Evaluate a provider answer.
     */
    public function evaluateAnswer(Request $request, string $providerId, string $answerId): RedirectResponse
    {
        $request->validate([
            'is_correct' => 'required|boolean'
        ]);

        try {
            $answer = $this->providerAnswerService->findById($answerId);

            if (!$answer || $answer->provider_id != $providerId) {
                return redirect()->back()->with('error', 'Answer not found');
            }

            // Check if this is the last unanswered question before evaluation
            $provider = $this->providerService->findById($providerId);
            $allAnswers = $this->providerAnswerService->getByProvider($providerId);
            $pendingAnswers = $allAnswers->where('is_evaluated', false)->count();
            $isLastQuestion = $pendingAnswers === 1;

            $this->providerAnswerService->evaluateAnswer($answer, $request->boolean('is_correct'));

            // Check if badge and category were assigned
            $provider->refresh();
            $message = 'Answer evaluated successfully';

            if ($isLastQuestion) {
                $assignments = [];

                if ($provider->badge) {
                    $assignments[] = 'badge "' . $provider->badge->name . '"';
                }

                if ($provider->category) {
                    $assignments[] = 'category "' . $provider->category->name . '"';
                }

                if (!empty($assignments)) {
                    $message .= ' and ' . implode(' and ', $assignments) . ' has been assigned!';
                }
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to evaluate answer: ' . $e->getMessage());
        }
    }

    /**
     * Toggle provider active status.
     */
    public function toggleStatus(string $id)
    {
        try {
            $provider = $this->providerService->findById($id);

            if (!$provider) {
                return redirect()->back()->with('error', 'Provider not found');
            }

            $this->providerService->toggleStatus($provider);

            $status = $provider->is_active ? 'activated' : 'deactivated';
            return response()->json(['success' => true, 'message' => "Provider {$status} successfully"]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update provider status: ' . $e->getMessage());
        }
    }

    /**
     * Toggle provider verification status.
     */
    public function toggleVerification(string $id)
    {
        try {
            $provider = $this->providerService->findById($id);

            if (!$provider) {
                return redirect()->back()->with('error', 'Provider not found');
            }

            $this->providerService->toggleVerification($provider);

            $status = $provider->is_verified ? 'verified' : 'unverified';
            return response()->json(['success' => true, 'message' => "Provider {$status} successfully"]);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update provider verification: ' . $e->getMessage());
        }
    }
}

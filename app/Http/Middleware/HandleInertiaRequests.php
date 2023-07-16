<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user()->load(['notificationSetting']),
                'isSuperAdmin' => !empty($request->user()) ? $request->user()->isSuperAdmin() : 0,
                'isDeviceAdmin' => !empty($request->user()) ? $request->user()->isDeviceAdmin() : 0,
                'isViewer' => !empty($request->user()) ? $request->user()->isViewer() : 0,
            ],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'delete' => fn () => $request->session()->get('delete'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'ziggy' => function () use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}

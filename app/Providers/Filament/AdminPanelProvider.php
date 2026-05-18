<?php
namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Enums\UserMenuPosition;
use App\Filament\Resources\Users\UserResource;
use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Resources\Listings\ListingResource;
use App\Filament\Resources\Bids\BidResource;
use App\Filament\Resources\Reviews\ReviewResource;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\HtmlString;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('DirectDeal')

            ->colors([
                'primary' => Color::hex('#1a3d2b'), // Jouw Forest Green als de basis van het hele systeem
                'gray' => Color::Zinc,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth('20rem')
            ->userMenu(position: UserMenuPosition::Sidebar)
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->assets([
                \Filament\Support\Assets\Css::make('custom-stylesheet', asset('css/filament.css')),
            ])
            ->renderHook(
                'panels::body.end',
                fn() => new HtmlString('
                    <style>
                        /* Sidebar smooth collapse animation */
                        .fi-sidebar {
                            transition: width 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
                        }

                        .fi-sidebar.sidebar-collapsed {
                            width: 6rem !important;
                            max-width: 6rem !important;
                        }

                        /* Content area */
                        .fi-sidebar-content {
                            flex: 1 !important;
                            overflow-y: auto !important;
                            overflow-x: hidden !important;
                        }

                        /* Header logo fade */
                        .fi-sidebar .fi-sidebar-logo {
                            transition: opacity 0.4s ease !important;
                            opacity: 1 !important;
                        }

                        .fi-sidebar.sidebar-collapsed .fi-sidebar-logo {
                            opacity: 0 !important;
                            pointer-events: none !important;
                        }

                        /* Nav text fade */
                        .fi-sidebar .fi-sidebar-nav span:not(.fi-icon) {
                            transition: opacity 0.4s ease, width 0.4s ease !important;
                            opacity: 1 !important;
                            width: auto !important;
                        }

                        .fi-sidebar.sidebar-collapsed .fi-sidebar-nav span:not(.fi-icon) {
                            opacity: 0 !important;
                            width: 0 !important;
                            overflow: hidden !important;
                            margin: 0 !important;
                        }

                        /* Groups fade */
                        .fi-sidebar .fi-sidebar-groups {
                            transition: opacity 0.4s ease !important;
                            opacity: 1 !important;
                        }

                        .fi-sidebar.sidebar-collapsed .fi-sidebar-groups {
                            opacity: 0 !important;
                            pointer-events: none !important;
                        }

                        /* Collapsed nav styling */
                        .fi-sidebar.sidebar-collapsed .fi-sidebar-nav {
                            display: flex !important;
                            flex-direction: column !important;
                            gap: 0.25rem !important;
                            padding: 0.5rem !important;
                        }

                        .fi-sidebar.sidebar-collapsed .fi-sidebar-nav li {
                            display: flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                        }

                        .fi-sidebar.sidebar-collapsed .fi-sidebar-nav a {
                            width: 100% !important;
                            padding: 0.75rem !important;
                            display: flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                            border-radius: 0.5rem !important;
                        }

                        .fi-sidebar.sidebar-collapsed .fi-sidebar-nav a:hover {
                            background: rgba(255, 255, 255, 0.1) !important;
                        }

                        /* Footer styling */
                        .fi-sidebar-footer {
                            margin-top: auto !important;
                            border-top: 1px solid rgba(255, 255, 255, 0.2) !important;
                            display: flex !important;
                            flex-direction: column !important;
                            gap: 0.5rem !important;
                            padding: 1rem 0.5rem !important;
                            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
                        }

                        .fi-sidebar.sidebar-collapsed .fi-sidebar-footer {
                            padding: 0.75rem 0.5rem !important;
                            gap: 0 !important;
                        }

                        /* Footer items fade */
                        .fi-sidebar-footer > *:not(#sidebar-toggle-btn) {
                            transition: opacity 0.3s ease !important;
                            opacity: 1 !important;
                        }

                        .fi-sidebar.sidebar-collapsed .fi-sidebar-footer > *:not(#sidebar-toggle-btn) {
                            opacity: 0 !important;
                            pointer-events: none !important;
                            height: 0 !important;
                            margin: 0 !important;
                            padding: 0 !important;
                            overflow: hidden !important;
                        }

                        /* Toggle button */
                        #sidebar-toggle-btn {
                            width: calc(100% - 1rem) !important;
                            margin: 0.5rem !important;
                            padding: 0.8rem !important;
                            border: 2px solid rgba(255, 255, 255, 0.25) !important;
                            background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.05) 100%) !important;
                            color: rgba(255, 255, 255, 0.95) !important;
                            font-size: 1.25rem !important;
                            cursor: pointer !important;
                            display: flex !important;
                            align-items: center !important;
                            justify-content: center !important;
                            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                            border-radius: 0.55rem !important;
                            font-weight: 700 !important;
                            backdrop-filter: blur(10px) !important;
                        }

                        #sidebar-toggle-btn:hover {
                            background: linear-gradient(135deg, rgba(255, 255, 255, 0.18) 0%, rgba(255, 255, 255, 0.08) 100%) !important;
                            border-color: rgba(255, 255, 255, 0.4) !important;
                        }

                        .fi-sidebar:not(.sidebar-collapsed) #sidebar-toggle-btn:hover {
                            transform: translateX(-2px) !important;
                        }

                        .fi-sidebar.sidebar-collapsed #sidebar-toggle-btn:hover {
                            transform: translateX(2px) !important;
                        }

                        #sidebar-toggle-btn:active {
                            transform: scale(0.98) !important;
                        }

                        /* Toggle icon animation */
                        .toggle-icon {
                            display: inline-block !important;
                            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
                        }

                        .fi-sidebar.sidebar-collapsed .toggle-icon {
                            transform: scaleX(-1) !important;
                        }
                    </style>
                    <script>
                    (function () {
                        const STORAGE_KEY = "sidebar_collapsed";
                        let initialized = false;

                        function getSidebar() {
                            return document.querySelector(".fi-sidebar");
                        }

                        function getFooter() {
                            return document.querySelector(".fi-sidebar-footer");
                        }

                        function initToggleButton() {
                            const sidebar = getSidebar();
                            const footer = getFooter();
                            
                            if (!sidebar || !footer || initialized) {
                                return;
                            }

                            // Remove old button
                            const oldBtn = document.getElementById("sidebar-toggle-btn");
                            if (oldBtn) oldBtn.remove();

                            // Create button
                            const btn = document.createElement("button");
                            btn.id = "sidebar-toggle-btn";
                            btn.type = "button";
                            btn.setAttribute("title", "Sidebar in-/uitklappen");
                            btn.innerHTML = `<span class="toggle-icon">←</span>`;
                            
                            // Restore state
                            const isCollapsed = localStorage.getItem(STORAGE_KEY) === "true";
                            if (isCollapsed) {
                                sidebar.classList.add("sidebar-collapsed");
                            }

                            // Toggle event
                            btn.addEventListener("click", function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                sidebar.classList.toggle("sidebar-collapsed");
                                localStorage.setItem(STORAGE_KEY, sidebar.classList.contains("sidebar-collapsed"));
                            });

                            footer.appendChild(btn);
                            initialized = true;
                        }

                        if (document.readyState === "loading") {
                            document.addEventListener("DOMContentLoaded", initToggleButton);
                        } else {
                            initToggleButton();
                        }

                        document.addEventListener("livewire:navigated", function() {
                            initialized = false;
                            setTimeout(initToggleButton, 100);
                        });
                    })();
                    </script>
                ')
            )
            ->resources([
                UserResource::class,
                CategoryResource::class,
                ListingResource::class,
                BidResource::class,
                ReviewResource::class,
            ])
            ->navigationGroups([
                \Filament\Navigation\NavigationGroup::make()
                    ->label('BEHEER')
                    ->collapsible(false),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
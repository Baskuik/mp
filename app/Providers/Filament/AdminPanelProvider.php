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
                'primary' => Color::hex('#1a3d2b'),
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
/* Sidebar breedte-animatie */
.fi-sidebar {
    transition:
        width 0.35s cubic-bezier(0.4, 0, 0.2, 1),
        min-width 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
    will-change: width !important;
    overflow: visible !important;
}

/* BEHEER label centreren bij ingeklapt */
.fi-sidebar.sidebar-collapsed .fi-sidebar-group-label {
    text-align: center !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    font-size: 0.55rem !important;
    letter-spacing: 0.05em !important;
    width: 100% !important;
}

/* Inner content clipped */
.fi-sidebar-content {
    overflow-x: hidden !important;
    overflow-y: auto !important;
}

/* Merknaam: fade weg bij inklappen */
.fi-sidebar-header {
    overflow: hidden !important;
    transition: opacity 0.2s ease 0.05s !important;
}

.fi-sidebar.sidebar-collapsed .fi-sidebar-header {
    opacity: 0 !important;
    pointer-events: none !important;
}

/* Label fade — eerst verdwijnen bij inklappen, later verschijnen bij uitklappen */
.fi-sidebar-item-label,
.fi-sidebar-item-badge-ctn {
    transition: opacity 0.15s ease !important;
    white-space: nowrap !important;
}

.fi-sidebar.sidebar-collapsed .fi-sidebar-item-label,
.fi-sidebar.sidebar-collapsed .fi-sidebar-item-badge-ctn {
    opacity: 0 !important;
}

/* Nav item container */
.fi-sidebar.sidebar-collapsed .fi-sidebar-item-btn {
    width: 2.5rem !important;
    height: 2.5rem !important;
    padding: 0 !important;
    margin: 0 auto !important;
    display: flex !important;
    justify-content: center !important;
    align-items: center !important;
    gap: 0 !important;
    border-radius: 0.375rem !important;
    transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                height 0.35s cubic-bezier(0.4, 0, 0.2, 1),
                padding 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

/* Icoon: subtiele scale bij collapse/expand */
.fi-sidebar-item-icon {
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1),
                opacity 0.3s ease !important;
    flex-shrink: 0 !important;
}

.fi-sidebar.sidebar-collapsed .fi-sidebar-item-icon {
    width: 1.5rem !important;
    height: 1.5rem !important;
    display: block !important;
}

/* Label en badge verbergen (display:none alleen in collapsed) */
.fi-sidebar.sidebar-collapsed .fi-sidebar-item-label,
.fi-sidebar.sidebar-collapsed .fi-sidebar-item-badge-ctn {
    display: none !important;
}

/* Badges/nummers verbergen */
.fi-sidebar-nav-item-badge,
.fi-badge {
    display: none !important;
}

/* Footer */
.fi-sidebar-footer {
    margin-top: auto !important;
    border-top: 1px solid rgba(255,255,255,0.2) !important;
    display: flex !important;
    flex-direction: column !important;
    gap: 0.5rem !important;
    padding: 1rem 0.5rem !important;
}

.fi-sidebar-footer > *:not(#sidebar-toggle-btn) {
    transition: opacity 0.2s ease, max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
    max-height: 100px !important;
    overflow: hidden !important;
}

.fi-sidebar.sidebar-collapsed .fi-sidebar-footer > *:not(#sidebar-toggle-btn) {
    opacity: 0 !important;
    max-height: 0 !important;
    pointer-events: none !important;
}

/* Toggle knop */
#sidebar-toggle-btn {
    width: calc(100% - 1rem) !important;
    margin: 0.5rem !important;
    padding: 0.8rem !important;
    border: 2px solid rgba(255,255,255,0.25) !important;
    background: linear-gradient(135deg, rgba(255,255,255,0.12) 0%, rgba(255,255,255,0.05) 100%) !important;
    color: rgba(255,255,255,0.95) !important;
    font-size: 1.25rem !important;
    cursor: pointer !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: background 0.25s ease, border-color 0.25s ease, transform 0.2s ease !important;
    border-radius: 0.55rem !important;
    font-weight: 700 !important;
    flex-shrink: 0 !important;
}

#sidebar-toggle-btn:hover {
    background: linear-gradient(135deg, rgba(255,255,255,0.18) 0%, rgba(255,255,255,0.08) 100%) !important;
    border-color: rgba(255,255,255,0.4) !important;
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

.toggle-icon {
    display: inline-block !important;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.fi-sidebar.sidebar-collapsed .toggle-icon {
    transform: scaleX(-1) !important;
}
                    </style>

                    <script>
                    (function () {
                        const STORAGE_KEY = "sidebar_collapsed";
                        const EXPANDED_W  = "20rem";
                        const COLLAPSED_W = "5rem";
                        let initialized   = false;

                        function getSidebar() { return document.querySelector(".fi-sidebar"); }
                        function getFooter()  { return document.querySelector(".fi-sidebar-footer"); }

                        /*
                         * DE ECHTE FIX:
                         * Filament gebruikt Alpine x-show="$store.sidebar.isOpen" op de labels.
                         * Als isOpen=false zet Alpine display:none op labels EN iconen.
                         * We moeten $store.sidebar.isOpen altijd op TRUE houden,
                         * en de breedte zelf regelen via CSS/JS.
                         */
                        function setAlpineStoreOpen(open) {
                            try {
                                if (window.Alpine && Alpine.store("sidebar")) {
                                    Alpine.store("sidebar").isOpen = open;
                                }
                            } catch(e) {}
                        }

                        function collapse(sidebar) {
                            sidebar.classList.add("sidebar-collapsed");
                            sidebar.style.setProperty("width",     COLLAPSED_W, "important");
                            sidebar.style.setProperty("min-width", COLLAPSED_W, "important");
                            /*
                             * Store blijft op TRUE zodat Alpine de labels/iconen
                             * NIET verbergt met display:none.
                             * Wij regelen de visuele staat via CSS opacity/classes.
                             */
                            setAlpineStoreOpen(true);
                        }

                        function expand(sidebar) {
                            sidebar.classList.remove("sidebar-collapsed");
                            sidebar.style.setProperty("width",     EXPANDED_W, "important");
                            sidebar.style.setProperty("min-width", EXPANDED_W, "important");
                            setAlpineStoreOpen(true);
                        }
                            

                        function initToggleButton() {
                            const sidebar = getSidebar();
                            const footer  = getFooter();
                            if (!sidebar || !footer || initialized) return;

                            const old = document.getElementById("sidebar-toggle-btn");
                            if (old) old.remove();

                            // Zet Alpine store altijd open zodat iconen zichtbaar zijn
                            setAlpineStoreOpen(true);

                            // Herstel staat zonder animatie
                            const wasCollapsed = localStorage.getItem(STORAGE_KEY) === "true";
                            sidebar.style.transition = "none";
                            wasCollapsed ? collapse(sidebar) : expand(sidebar);
                            requestAnimationFrame(() => requestAnimationFrame(() => {
                                sidebar.style.transition = "";
                            }));

                            const btn = document.createElement("button");
                            btn.id        = "sidebar-toggle-btn";
                            btn.type      = "button";
                            btn.title     = "Sidebar in-/uitklappen";
                            btn.innerHTML = `<span class="toggle-icon">←</span>`;

                            btn.addEventListener("click", function (e) {
                                e.preventDefault();
                                e.stopPropagation();
                                const isCollapsed = sidebar.classList.contains("sidebar-collapsed");
                                if (isCollapsed) {
                                    expand(sidebar);
                                    localStorage.setItem(STORAGE_KEY, "false");
                                } else {
                                    collapse(sidebar);
                                    localStorage.setItem(STORAGE_KEY, "true");
                                }
                            });

                            footer.appendChild(btn);
                            initialized = true;

                            /*
                             * Bewaker: als Alpine de store toch op false zet
                             * (bijv. via Filament\'s eigen collapse-knop of resize),
                             * zetten we hem direct terug op true.
                             */
                            setInterval(function() {
                                try {
                                    if (window.Alpine && Alpine.store("sidebar")) {
                                        if (Alpine.store("sidebar").isOpen === false) {
                                            Alpine.store("sidebar").isOpen = true;
                                            // Sync onze breedte ook mee
                                            const sb = getSidebar();
                                            if (sb) {
                                                const w = sb.style.width;
                                                if (!w || parseFloat(w) < 80) {
                                                    collapse(sb);
                                                }
                                            }
                                        }
                                    }
                                } catch(e) {}
                            }, 200);
                        }

                        // Wacht tot Alpine klaar is voor we beginnen
                        function waitForAlpine(cb) {
                            if (window.Alpine && Alpine.store) {
                                cb();
                            } else {
                                document.addEventListener("alpine:init", cb);
                                setTimeout(cb, 500); // fallback
                            }
                        }

                        if (document.readyState === "loading") {
                            document.addEventListener("DOMContentLoaded", function() {
                                waitForAlpine(initToggleButton);
                            });
                        } else {
                            waitForAlpine(initToggleButton);
                        }

                        document.addEventListener("livewire:navigated", function () {
                            initialized = false;
                            setTimeout(function() {
                                waitForAlpine(initToggleButton);
                            }, 150);
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
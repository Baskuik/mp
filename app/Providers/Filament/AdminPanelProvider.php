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
                <script>
                (function () {
                    const STORAGE_KEY = "dd_sidebar_collapsed";

                    function init() {
                        // Verwijder oude knop als die al bestaat (na Livewire navigatie)
                        const old = document.getElementById("dd-sidebar-toggle");
                        if (old) old.remove();

                        const footer = document.querySelector(".fi-sidebar-footer");
                        if (!footer) return;

                        // Maak de << >> toggle knop
                        const btn = document.createElement("button");
                        btn.id = "dd-sidebar-toggle";
                        btn.title = "Sidebar in-/uitklappen";
                        btn.setAttribute("aria-label", "Sidebar in-/uitklappen");

                        // Gebruik Filament\'s eigen collapse functionaliteit via de bestaande knop
                        // Zoek de originele Filament toggle knop
                        function getFilamentToggle() {
                            return document.querySelector("[x-data] button[x-on\\\\:click], .fi-sidebar-close-overlay-btn, [wire\\\\:click*=\'collaps\']")
                                || document.querySelector(".fi-topbar button[title], .fi-sidebar button[aria-label*=\'close\'], .fi-sidebar button[aria-label*=\'collapse\']");
                        }

                        // Lees huidige collapsed staat uit localStorage van Filament
                        function isCollapsed() {
                            return localStorage.getItem("sidebarIsOpen") === "false"
                                || document.querySelector(".fi-sidebar")?.offsetWidth < 50;
                        }

                        function updateIcon() {
                            btn.textContent = isCollapsed() ? ">>" : "<<";
                        }

                        updateIcon();

                        btn.addEventListener("click", function () {
                            // Trigger Filament\'s eigen Alpine.js sidebar toggle
                            const sidebar = document.querySelector(".fi-sidebar");
                            if (sidebar) {
                                // Zoek naar de Alpine component en toggle die
                                const alpineEl = document.querySelector("[x-data*=\'sidebar\']")
                                    || document.querySelector(".fi-layout > div[x-data]")
                                    || document.querySelector("[x-data]");

                                if (alpineEl && window.Alpine) {
                                    // Trigger via Alpine
                                    const component = Alpine.$data(alpineEl);
                                    if (component && typeof component.sidebarIsOpen !== "undefined") {
                                        component.sidebarIsOpen = !component.sidebarIsOpen;
                                        localStorage.setItem("sidebarIsOpen", component.sidebarIsOpen);
                                    }
                                } else {
                                    // Fallback: zoek Filament\'s toggle knop in de topbar en klik die
                                    const topbarBtn = document.querySelector(".fi-topbar-sidebar-toggle-btn")
                                        || document.querySelector("[aria-controls*=\'sidebar\']")
                                        || document.querySelector(".fi-icon-btn[title*=\'sidebar\']");
                                    if (topbarBtn) topbarBtn.click();
                                }
                            }
                            setTimeout(updateIcon, 300);
                        });

                        footer.appendChild(btn);

                        // Update icoon ook als Filament zelf de sidebar toggle triggert
                        const observer = new MutationObserver(() => updateIcon());
                        const sidebar = document.querySelector(".fi-sidebar");
                        if (sidebar) {
                            observer.observe(sidebar, { attributes: true, attributeFilter: ["style", "class"] });
                        }
                    }

                    if (document.readyState === "loading") {
                        document.addEventListener("DOMContentLoaded", init);
                    } else {
                        setTimeout(init, 100);
                    }

                    document.addEventListener("livewire:navigated", () => setTimeout(init, 100));
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
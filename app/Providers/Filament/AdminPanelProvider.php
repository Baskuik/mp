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
        let sidebarObserver = null;

        function init() {
            const old = document.getElementById("dd-sidebar-toggle");
            if (old) old.remove();

            const footer = document.querySelector(".fi-sidebar-footer");
            if (!footer) return;

            const btn = document.createElement("button");
            btn.id = "dd-sidebar-toggle";
            btn.title = "Sidebar in-/uitklappen";
            btn.setAttribute("aria-label", "Sidebar in-/uitklappen");

            function isOpen() {
                return window.Alpine && Alpine.store("sidebar") && Alpine.store("sidebar").isOpen;
            }

            function updateIcon() {
                btn.textContent = isOpen() ? "<<" : ">>";
            }

            updateIcon();

            btn.addEventListener("click", function () {
                if (window.Alpine && Alpine.store("sidebar")) {
                    Alpine.store("sidebar").isOpen = !Alpine.store("sidebar").isOpen;
                    setTimeout(updateIcon, 150);
                }
            });

            footer.appendChild(btn);

            // Disconnect old observer before creating new one
            if (sidebarObserver) {
                sidebarObserver.disconnect();
            }

            // Luister naar sidebar-klasse wijzigingen voor icoon-update
            const sidebar = document.querySelector(".fi-sidebar");
            if (sidebar) {
                sidebarObserver = new MutationObserver(updateIcon);
                sidebarObserver.observe(sidebar, {
                    attributes: true,
                    attributeFilter: ["style", "class"]
                });
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
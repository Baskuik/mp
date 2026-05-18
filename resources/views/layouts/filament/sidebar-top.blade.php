@if (filament()->isSidebarOpen())
    <style>
        /* Verberg het originele logo in de topbar */
        .fi-topbar-logo {
            display: none !important;
        }

        /* Voeg logo en terug-knop toe aan sidebar header */
        .fi-sidebar-header {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            padding: 1rem !important;
            gap: 0.5rem !important;
            position: relative !important;
        }

        /* Style voor het terug-pijltje */
        .fi-sidebar-header::before {
            content: "← DirectDeal" !important;
            color: #ffffff !important;
            font-family: Georgia, serif !important;
            font-size: 16px !important;
            font-weight: 500 !important;
            cursor: pointer !important;
            flex: 1 !important;
            text-decoration: none !important;
        }
    </style>
@endif

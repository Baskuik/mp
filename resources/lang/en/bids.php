<?php

return [
    'col_listing'    => 'LISTING',
    'col_buyer'      => 'BIDDER',
    'col_amount'     => 'AMOUNT',
    'col_status'     => 'STATUS',
    'col_active'     => 'ACTIVE',
    'col_date'       => 'DATE',
    'col_updated_at' => 'LAST UPDATE',

    'badge_pending'   => '⏳ PENDING',
    'badge_accepted'  => '✓ ACCEPTED',
    'badge_rejected'  => '✗ REJECTED',
    'badge_cancelled' => '○ CANCELLED',

    'filter_active'   => 'Active bids only',
    'filter_inactive' => 'Deleted bids only',

    'decline_heading' => 'Decline bid',
    'decline_desc'    => 'Are you sure you want to decline this bid? The status will be changed to "Rejected".',
    'decline_confirm' => 'Yes, decline bid',
    'notify_declined' => 'Bid declined',

    'delete_heading' => 'Delete bid',
    'delete_desc'    => 'Are you sure you want to delete this bid? The bid will remain in the database but will no longer be shown.',
    'delete_confirm' => 'Yes, delete bid',
    'notify_deleted' => 'Bid deleted',

    'bulk_delete_label'   => 'Delete selection',
    'bulk_delete_heading' => 'Delete selected bids',
    'bulk_delete_desc'    => 'Are you sure you want to delete the selected bids? They will remain in the database but will no longer be shown.',
    'bulk_delete_confirm' => 'Yes, delete selection',
    'notify_bulk_deleted' => 'Bids deleted',

    'bulk_decline_label'   => 'Decline selection',
    'bulk_decline_heading' => 'Decline selected bids',
    'notify_bulk_declined' => 'Bids declined',
];
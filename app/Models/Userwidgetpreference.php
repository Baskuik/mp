<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserWidgetPreference extends Model
{
    protected $fillable = ['user_id', 'page', 'widget', 'enabled'];

    protected $casts = ['enabled' => 'boolean'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Geeft een array terug van widget-classnames die ENABLED zijn
     * voor de opgegeven gebruiker + pagina.
     *
     * Als er nog geen voorkeur is opgeslagen voor een widget,
     * wordt die widget als standaard INGESCHAKELD beschouwd.
     *
     * @param  int    $userId
     * @param  string $page
     * @param  array  $allWidgets   Alle widget-classnames voor die pagina
     * @return array<string>
     */
    public static function enabledForPage(int $userId, string $page, array $allWidgets): array
    {
        $saved = static::where('user_id', $userId)
            ->where('page', $page)
            ->pluck('enabled', 'widget');   // ['App\...\UserStatsOverview' => true, ...]

        return array_filter($allWidgets, function (string $widget) use ($saved) {
            // Geen voorkeur opgeslagen? Dan standaard aan.
            return $saved->get($widget, true);
        });
    }

    /**
     * Sla de aan/uit-staat op voor één widget.
     */
    public static function setWidget(int $userId, string $page, string $widget, bool $enabled): void
    {
        static::updateOrCreate(
            ['user_id' => $userId, 'page' => $page, 'widget' => $widget],
            ['enabled' => $enabled],
        );
    }
}
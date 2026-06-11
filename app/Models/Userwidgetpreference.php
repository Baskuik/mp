<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserWidgetPreference extends Model
{
    protected $fillable = ['user_id', 'page', 'widget', 'enabled'];

    protected $casts = ['enabled' => 'boolean'];

    // ── Relatie ───────────────────────────────────────────────────
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // ── Helpers ───────────────────────────────────────────────────

    /**
     * Sla de enabled/disabled staat van één widget op (upsert).
     */
    public static function setWidget(int $userId, string $page, string $widget, bool $enabled): void
    {
        static::updateOrCreate(
            ['user_id' => $userId, 'page' => $page, 'widget' => $widget],
            ['enabled' => $enabled]
        );
    }

    /**
     * Geeft de lijst van ingeschakelde widget-classnames terug voor een pagina.
     * Als een widget nog nooit is opgeslagen, wordt hij als 'aan' beschouwd ($defaults).
     *
     * `@param`  array<string>  $defaults  Alle bekende widgets voor deze pagina
     * `@return` array<string>
     */
    public static function enabledForPage(int $userId, string $page, array $defaults): array
    {
        $saved = static::where('user_id', $userId)
            ->where('page', $page)
            ->pluck('enabled', 'widget')
            ->all();

        // Widgets die nooit zijn opgeslagen → standaard aan
        return array_values(array_filter($defaults, function (string $widget) use ($saved) {
            return $saved[$widget] ?? true;
        }));
    }
}
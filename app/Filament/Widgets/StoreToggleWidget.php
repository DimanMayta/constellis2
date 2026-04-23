<?php

namespace App\Filament\Widgets;

use App\Models\SiteSetting;
use Filament\Widgets\Widget;

class StoreToggleWidget extends Widget
{
    protected static string $view = 'filament.widgets.store-toggle-widget';

    protected static ?int $sort = -2;

    protected int | string | array $columnSpan = 'full';

    public bool $storeEnabled = true;

    public function mount(): void
    {
        $this->storeEnabled = SiteSetting::get('store_enabled', 'true') === 'true';
    }

    public function toggleStore(): void
    {
        $this->storeEnabled = !$this->storeEnabled;
        SiteSetting::set('store_enabled', $this->storeEnabled ? 'true' : 'false');
    }
}

<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\PatientTypeOverview;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.settings';

    public $site_name;

    protected $rules = [
        'site_name' => 'required'
    ];

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('site_name'),
        ];
    }

    public function submit()
    {
        $this->validate();

        // SAVE THE SETTINGS HERE
    }
}

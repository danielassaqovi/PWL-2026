<?php

namespace App\Filament\Pages;

use App\Models\MSetting;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Filament\Actions\Action;

class SettingPenjualan extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected string $view = 'filament.pages.setting-penjualan';

    protected static ?string $title = 'Setting Penjualan';

    protected static ?string $navigationLabel = 'Setting Penjualan';

    protected static string | \UnitEnum | null $navigationGroup = 'Master Data';

    public ?array $data = [];

    public function mount(): void
    {
        $tax = MSetting::where('key', 'pajak_persentase')->first();
        
        $this->form->fill([
            'pajak_persentase' => $tax->value ?? 0,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Konfigurasi Pajak')
                    ->description('Tentukan persentase pajak yang akan dikenakan pada setiap transaksi penjualan.')
                    ->schema([
                        TextInput::make('pajak_persentase')
                            ->label('Persentase Pajak (%)')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->helperText('Jika diisi 0 atau kosong, maka tidak ada pajak yang dikenakan.'),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            MSetting::where('key', 'pajak_persentase')->update([
                'value' => $data['pajak_persentase'],
            ]);

            Notification::make()
                ->success()
                ->title('Pengaturan berhasil disimpan')
                ->send();
        } catch (Halt $exception) {
            return;
        }
    }

    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label('Simpan Perubahan')
            ->submit('save');
    }
}

<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Level;
use App\Models\UserModel;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = UserModel::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|\UnitEnum|null $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 5;

    public static function getNavigationLabel(): string
    {
        return 'Pengguna';
    }

    public static function getModelLabel(): string
    {
        return 'Pengguna';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Pengguna';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Section::make('Informasi Akun')
                    ->description('Isi data pengguna dengan lengkap.')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Forms\Components\TextInput::make('username')
                            ->label('Username')
                            ->required()
                            ->maxLength(20)
                            ->unique(table: 'm_user', column: 'username', ignoreRecord: true)
                            ->placeholder('Contoh: johndoe')
                            ->prefixIcon('heroicon-o-at-symbol'),

                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(100)
                            ->placeholder('Contoh: John Doe')
                            ->prefixIcon('heroicon-o-user'),

                        Forms\Components\Select::make('level_id')
                            ->label('Level Pengguna')
                            ->options(Level::query()->pluck('level_nama', 'level_id'))
                            ->required()
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih level pengguna'),

                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->minLength(6)
                            ->placeholder('Minimal 6 karakter')
                            ->prefixIcon('heroicon-o-lock-closed')
                            ->dehydrated(fn ($state) => filled($state))
                            ->helperText('Kosongkan jika tidak ingin mengubah password (saat edit).'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->label('No.')
                    ->rowIndex()
                    ->width('60px'),

                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Username disalin!')
                    ->icon('heroicon-o-at-symbol'),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('level.level_nama')
                    ->label('Level')
                    ->badge()
                    ->color(fn ($record) => match ($record->level?->level_kode) {
                        'ADM'  => 'danger',
                        'MGR'  => 'warning',
                        'KSR'  => 'success',
                        default => 'info',
                    })
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('level_id')
                    ->label('Level')
                    ->options(Level::query()->pluck('level_nama', 'level_id'))
                    ->placeholder('Semua Level'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Pengguna berhasil diperbarui.')
                    ),

                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Pengguna berhasil dihapus.')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('user_id', 'asc')
            ->striped()
            ->emptyStateHeading('Belum ada data pengguna')
            ->emptyStateDescription('Klik tombol "Tambah Pengguna" untuk menambahkan data baru.')
            ->emptyStateIcon('heroicon-o-users');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}

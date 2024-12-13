<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteMonitorResource\Pages;
use App\Filament\Resources\SiteMonitorResource\RelationManagers;
use App\Models\SiteMonitor;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteMonitorResource extends Resource
{
    protected static ?string $model = SiteMonitor::class;

    // protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Monitoring';

    protected static ?string $navigationLabel = 'Site Monitoring';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('terminal_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sitecode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('modem')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mikrotik')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ap1')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ap2')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('modem_last_up')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('mikrotik_last_up')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('ap1_last_up')
                    ->nullable(),
                Forms\Components\DateTimePicker::make('ap2_last_up')
                    ->nullable(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('terminal_id')
                    ->sortable()
                    ->label('Terminal ID')
                    ->copyable()
                    // ->description(fn(ApiData $record): string => $record->sitecode)
                    ->searchable(),

                Tables\Columns\TextColumn::make('sitecode')
                    ->sortable()
                    ->searchable()
                    ->copyable()
                    ->label('Site Name'),

                Tables\Columns\TextColumn::make('status')->badge()->searchable()
                    ->sortable()->color(fn(string $state): string => match ($state) {
                        'Critical' => 'danger',
                        'Normal' => 'success',
                        'Minor' => 'primary',
                        'Major' => 'warning',
                    }),

                Tables\Columns\TextColumn::make('modem')->label('Modem')
                    ->sortable()->color(fn(string $state): string => match ($state) {
                        'Down' => 'danger',
                        'Up' => 'success',
                    })
                    ->weight(FontWeight::Bold)
                    ->description(fn(SiteMonitor $record): string => $record->modem_last_up === null ? "Normal" : $record->modem_last_up->since()),
                Tables\Columns\TextColumn::make('mikrotik')->label('Router')
                    ->sortable()->color(fn(string $state): string => match ($state) {
                        'Down' => 'danger',
                        'Up' => 'success',
                    })
                    ->weight(FontWeight::Bold)
                    ->description(fn(SiteMonitor $record): string => $record->mikrotik_last_up === null ? "Normal" : $record->mikrotik_last_up->since()),
                Tables\Columns\TextColumn::make('ap1')->label('AP 1')
                    ->sortable()->color(fn(string $state): string => match ($state) {
                        'Down' => 'danger',
                        'Up' => 'success',
                    })
                    ->weight(FontWeight::Bold)
                    ->description(fn(SiteMonitor $record): string => $record->ap1_last_up === null ? "Normal" : $record->ap1_last_up->since()),
                Tables\Columns\TextColumn::make('ap2')->label('AP 2')
                    ->sortable()->color(fn(string $state): string => match ($state) {
                        'Down' => 'danger',
                        'Up' => 'success',
                    })
                    ->weight(FontWeight::Bold)
                    ->description(fn(SiteMonitor $record): string => $record->ap2_last_up === null ? "Normal" : $record->ap2_last_up->since()),

                Tables\Columns\TextColumn::make('modem_last_up')
                    ->hidden()->since(),
                Tables\Columns\TextColumn::make('mikrotik_last_up')
                    ->hidden()->since(),
                Tables\Columns\TextColumn::make('ap1_last_up')
                    ->hidden()->since(),
                Tables\Columns\TextColumn::make('ap2_last_up')
                    ->hidden()->since(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'normal' => 'Normal',
                        'minor' => 'Minor',
                        'major' => 'Major',
                        'critical' => 'Critical',
                    ]),
                SelectFilter::make('modem')
                    ->options([
                        'up' => 'Up',
                        'down' => 'Down',
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('Details')
                    ->icon('heroicon-c-arrow-up-left')
                    // This is the important part!
                    ->infolist([
                        // Inside, we can treat this as any info list and add all the fields we want!
                        Section::make('Site Information')
                            ->schema([
                                TextEntry::make('terminal_id'),
                                TextEntry::make('sitecode'),
                            ])
                            ->columns(),
                        Section::make('Device Status')
                            ->schema([
                                TextEntry::make('modem')->badge()->label("Modem")
                                    ->color(fn(string $state): string => match ($state) {
                                        'Down' => 'danger',
                                        'Up' => 'success',
                                    }),
                                TextEntry::make('mikrotik')->badge()->label("Router")
                                    ->color(fn(string $state): string => match ($state) {
                                        'Down' => 'danger',
                                        'Up' => 'success',
                                    }),
                                TextEntry::make('ap1')->badge()->label("Access Point 1")
                                    ->color(fn(string $state): string => match ($state) {
                                        'Down' => 'danger',
                                        'Up' => 'success',
                                    }),
                                TextEntry::make('ap2')->badge()->label("Access Point 2")
                                    ->color(fn(string $state): string => match ($state) {
                                        'Down' => 'danger',
                                        'Up' => 'success',
                                    }),
                            ])
                            ->columns(4),
                        Section::make('Device Last UP')
                            ->schema([
                                TextEntry::make('modem_last_up')->badge()->label("Modem")
                                    ->dateTimeTooltip()->since()->default(Carbon::now()),
                                TextEntry::make('mikrotik_last_up')->badge()->label("Router")
                                    ->dateTimeTooltip()->since()->default(Carbon::now()),
                                TextEntry::make('ap1_last_up')->badge()->label("Access Point 1")
                                    ->dateTimeTooltip()->since()->default(Carbon::now()),
                                TextEntry::make('ap2_last_up')->badge()->label("Access Point 2")
                                    ->dateTimeTooltip()->since()->default(Carbon::now()),
                            ])
                            ->columns(4),
                    ])
                    ->modalSubmitAction(false)
                    ->modalHeading('Site Details'),
            ])
            ->recordUrl(null);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteMonitor::route('/'),
            'create' => Pages\CreateSiteMonitor::route('/create'),
            'edit' => Pages\EditSiteMonitor::route('/{record}/edit'),
        ];
    }
}

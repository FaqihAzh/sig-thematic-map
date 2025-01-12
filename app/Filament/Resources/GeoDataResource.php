<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeoDataResource\Pages;
use App\Models\GeoData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GeoDataResource extends Resource
{
    protected static ?string $model = GeoData::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('province_id')
                    ->relationship('province', 'name')
                    ->searchable()
                    ->required()
                    ->label('Province')
                    ->reactive(),

                Forms\Components\Select::make('regency_id')
                    ->label('Regency')
                    ->required()
                    ->searchable()
                    ->reactive()
                    ->options(function (callable $get) {
                        $provinceId = $get('province_id');
                        if (!$provinceId) {
                            return [];
                        }

                        return \App\Models\Regency::where('province_id', $provinceId)
                            ->pluck('name', 'id')
                            ->toArray();
                    }),

                Forms\Components\TextInput::make('capital')
                    ->required()
                    ->label('Capital'),

                Forms\Components\TextInput::make('year')
                    ->type('number')
                    ->required()
                    ->label('Year'),

                Forms\Components\TextInput::make('population')
                    ->type('number')
                    ->required()
                    ->label('Population'),

                Forms\Components\TextInput::make('area')
                    ->type('number')
                    ->step(0.01)
                    ->required()
                    ->label('Area (km²)'),

                Forms\Components\TextInput::make('male_population')
                    ->type('number')
                    ->required()
                    ->label('Male Population'),

                Forms\Components\TextInput::make('female_population')
                    ->type('number')
                    ->required()
                    ->label('Female Population'),

                Forms\Components\TextInput::make('student')
                    ->type('number')
                    ->required()
                    ->label('Students'),

                Forms\Components\TextInput::make('tpt')
                    ->type('number')
                    ->step(0.01)
                    ->label('TPT')
                    ->nullable(),
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('province.name')->label('Province'),
                Tables\Columns\TextColumn::make('regency.name')->label('Regency'),
                Tables\Columns\TextColumn::make('capital')->label('Capital'),
                Tables\Columns\TextColumn::make('year')->label('Year'),
                Tables\Columns\TextColumn::make('population')->label('Population'),
                Tables\Columns\TextColumn::make('area')->label('Area (km²)'),
                Tables\Columns\TextColumn::make('density')
                    ->label('Density (people/km²)')
                    ->getStateUsing(fn ($record) => number_format($record->density, 2)),
                Tables\Columns\TextColumn::make('male_population')->label('Male Population'),
                Tables\Columns\TextColumn::make('female_population')->label('Female Population'),
                Tables\Columns\TextColumn::make('student')->label('Student'),
                Tables\Columns\TextColumn::make('student_distribution')
                    ->label('Student Distribution (students/km²)')
                    ->getStateUsing(fn ($record) => number_format($record->student_distribution, 2)),
                Tables\Columns\TextColumn::make('tpt')->label('TPT'),
            ])
            ->filters([
                // You can add filters here if needed
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add relation managers if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGeoData::route('/'),
            'create' => Pages\CreateGeoData::route('/create'),
            'edit' => Pages\EditGeoData::route('/{record}/edit'),
        ];
    }
}

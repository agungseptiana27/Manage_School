<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Models\HomeRoom;
use App\Models\Periode;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomeroomRelationManager extends RelationManager
{
    protected static string $relationship = 'homeroom';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('homerooms_id')
                    ->label('Select Home Room')
                    ->options(HomeRoom::with(['teacher', 'classroom'])
                        ->get()->mapWithKeys(function ($homeRoom) {
                                $teacherName = $homeRoom->teacher->name ?? 'Tanpa Guru';
                                $classroomName = $homeRoom->classroom->name ?? 'Tanpa Kelas';
                                return [$homeRoom->id => "$classroomName - $teacherName"];
                        }
                    ))
                    ->searchable(),
                Select::make('periodes_id')
                    ->label('Select Periode')
                    ->options(Periode::whereNotNull('name')->pluck('name', 'id'))
                    ->searchable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('homeroom')
                    ->label('Kelas - Guru')
                    ->formatStateUsing(function ($record) {
                        $kelas = $record->homeroom?->classroom?->name ?? 'Tanpa Kelas';
                        $guru = $record->homeroom?->teacher?->name ?? 'Tanpa Guru';
                        return "$kelas - $guru";
                    }),
                Tables\Columns\TextColumn::make('periode.name'),
                ToggleColumn::make('is_open'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
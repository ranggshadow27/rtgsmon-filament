<?php

namespace App\Filament\Resources\SiteMonitorResource\Pages;

use App\Filament\Resources\SiteMonitorResource;
use App\Models\SiteMonitor;
use Filament\Actions;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\ActionGroup;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Blade;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListSiteMonitor extends ListRecords
{
    protected static string $resource = SiteMonitorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([
                ExportAction::make('csv')
                    ->icon('phosphor-file-csv-duotone')
                    ->label("Export to CSV")
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename(fn($resource) => $resource::getModelLabel() . '-' . date('Y-m-d'))
                            ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                            ->withColumns([
                                Column::make('updated_at'),
                            ])
                    ]),
                ExportAction::make('xlsx')
                    ->icon('phosphor-file-xls-duotone')
                    ->label("Export to XLSX")
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                            ->withFilename(fn($resource) => $resource::getModelLabel() . '-' . date('Y-m-d'))
                            ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                            ->withColumns([
                                Column::make('updated_at'),
                            ])
                    ]),
                // ExportAction::make('pdf')
                //     ->label("Export to PDF")
                //     ->icon('phosphor-file-pdf-duotone')
                //     ->openUrlInNewTab()
                //     ->action(function () {
                //         $records = SiteMonitor::all();
                //         $now = now()->format('d-m-Y');
                //         $filename = 'tickets_export_' . $now . '.pdf';
                //         return response()->streamDownload(function () use ($records) {
                //             echo Pdf::loadHTML(
                //                 Blade::render('bulk-pdf', ['records' => $records])
                //             )->stream();
                //         }, $filename);
                //     }),

            ])
                ->icon('heroicon-m-arrow-down-tray')
                ->label("Export Data")
                ->tooltip("Export Data"),
        ];
    }
}

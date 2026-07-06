<?php

// Filament-сторінка для створення та завантаження резервної копії бази даних.
//
// Раніше бекап формувався вручну (SHOW CREATE TABLE + SELECT * + addslashes()),
// що небезпечно для MySQL: addslashes() не є коректним SQL-екрануванням
// (проблеми з multibyte-кодуванням, бінарними даними, NUL-байтами — можна
// отримати биту чи навіть інʼєктовану дамп-копію). Тепер дамп робить сам
// mysqldump, який коректно екранує будь-які дані.
namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DatabaseBackup extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';

    protected static ?string $navigationLabel = 'Резервна копія БД';

    protected static ?string $title = 'Резервна копія бази даних';

    protected static ?int $navigationSort = 11;

    protected static string $view = 'filament.pages.database-backup';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadBackup')
                ->label('Завантажити бекап')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn () => $this->generateBackup()),
        ];
    }

    public function generateBackup()
    {
        $connection = config('database.default');

        if ($connection !== 'mysql') {
            Notification::make()
                ->title('Бекап через mysqldump підтримується лише для MySQL-з’єднання.')
                ->danger()
                ->send();
            return;
        }

        $config   = config("database.connections.{$connection}");
        $filename = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';

        $process = new Process([
            'mysqldump',
            '--host=' . $config['host'],
            '--port=' . $config['port'],
            '--user=' . $config['username'],
            '--single-transaction',
            '--quick',
            '--default-character-set=' . ($config['charset'] ?? 'utf8mb4'),
            $config['database'],
        ], null, [
            'MYSQL_PWD' => $config['password'],
        ]);

        $process->setTimeout(300);

        try {
            $process->mustRun();
        } catch (ProcessFailedException $e) {
            report($e);
            Notification::make()
                ->title('Не вдалося створити бекап.')
                ->body('mysqldump завершився з помилкою. Деталі — у логах застосунку.')
                ->danger()
                ->send();
            return;
        }

        $dump = $process->getOutput();

        return response()->streamDownload(function () use ($dump) {
            echo $dump;
        }, $filename, [
            'Content-Type' => 'application/octet-stream',
        ]);
    }
}

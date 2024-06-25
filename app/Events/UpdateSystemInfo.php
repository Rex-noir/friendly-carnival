<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class UpdateSystemInfo implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */

    public $systemInfo;

    public function __construct()
    {
        //
        $this->systemInfo = $this->systemInfo();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('system-info'),
        ];
    }

    // public function broadcastWhen(): bool
    // {
    //     $route = request()->route()->getName();
    //     return $route === 'dashboard';
    // }


    private function systemInfo()
    {

        return
            [
                'cpu_load' => $this->calculateCPULoad(),
                'memory_usage' => $this->calculateMemoryUsage(),
                'storage_usage' => $this->getStorageInfo(),
                'database' => $this->getDatabaseSize(),
                'uptime' => $this->getUpTime()
            ];
    }
    private function calculateCPULoad(): array
    {
        // Get the load averages for 1, 5, and 15 minutes
        $loadAverages = sys_getloadavg();

        // Calculate the CPU load in percentage for each load average
        $cpuLoad1m = round(($loadAverages[0] * 100), 2);
        $cpuLoad5m = round(($loadAverages[1] * 100), 2);
        $cpuLoad15m = round(($loadAverages[2] * 100), 2);

        return [
            '1m' => $cpuLoad1m,
            '5m' => $cpuLoad5m,
            '15m' => $cpuLoad15m
        ];
    }
    private function calculateMemoryUsage(): array
    {
        // Get total and free memory
        $totalMemory = round(shell_exec('free -m | awk \'NR==2{print $2}\''));
        $freeMemory = round(shell_exec('free -m | awk \'NR==2{print $4}\''));
        $usedMemory = $totalMemory - $freeMemory;

        // Calculate memory usage percentage
        $memoryUsage = round(($usedMemory / $totalMemory) * 100, 2);

        return [
            'memory_total' => $totalMemory . ' MB',
            'memory_used' => $usedMemory . ' MB',
            'memory_usage' => $memoryUsage . ' %'
        ];
    }
    private function getStorageInfo(): array
    {
        // Get disk usage information in bytes
        $diskTotalBytes = disk_total_space('/');
        $diskFreeBytes = disk_free_space('/');
        $diskUsedBytes = $diskTotalBytes - $diskFreeBytes;

        // Convert bytes to megabytes
        $diskTotalMB = round($diskTotalBytes / (1024 * 1024), 2);
        $diskUsedMB = round($diskUsedBytes / (1024 * 1024), 2);
        $diskFreeMB = round($diskFreeBytes / (1024 * 1024), 2);

        return [
            'disk_total' => $diskTotalMB . ' MB',
            'disk_used' => $diskUsedMB . ' MB',
            'disk_free' => $diskFreeMB . ' MB'
        ];
    }
    public function getUpTime()
    {
        $uptime = exec('uptime');
        preg_match('/up\s+(.*?),\s+\d+\s+users?,\s+load/', $uptime, $matches);

        // If parsing fails, return an error message
        $parsedUptime = count($matches) >= 2 ? $matches[1] : 'Unable to determine uptime';

        return $parsedUptime;
    }
    public function getDatabaseSize()
    {
        $path = database_path('database.sqlite'); // replace with your database path
        if (file_exists($path)) {
            $size = $this->formatSizeUnits(filesize($path));
            return $size; // size in bytes
        } else {
            return 'Database file does not exist.';
        }
    }
    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }
}

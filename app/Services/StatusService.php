<?php
namespace App\Services;

use App\Models\Status;
use App\Models\Reading;
use App\Models\Weather;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class StatusService{
    public function getDateTimes():array{
        $latestDateTime = Reading::query()->max('updated_at');

        $recentDateTimes['readings']['latestDateTime'] = $latestDateTime;
        $recentDateTimes['readings']['nextDateTime'] = (Carbon::parse($latestDateTime)->addHours(1))->toDateTimeString();

        $latestDateTime = Weather::query()->max('updated_at');
        $recentDateTimes['weather']['latestDateTime'] = $latestDateTime;
        $recentDateTimes['weather']['nextDateTime'] = (Carbon::parse($latestDateTime)->addHours(1))->toDateTimeString();

        $latestDateTime = Status::query()->max('updated_at');
        $recentDateTimes['status']['latestDateTime'] = $latestDateTime;
        $recentDateTimes['status']['nextDateTime'] = (Carbon::parse($latestDateTime)->addHours(1))->toDateTimeString();

        return $recentDateTimes;
    }
    # gets information from API and inserts to database
    public function deleteRecords():bool{
        try{
            $query = Reading::query();
            $query->where('measuredAt','<',Carbon::now()->subMonth(1));
            $query->delete();

            $query = Weather::query();
            $query->where('measuredAt','<',Carbon::now()->subMonth(1));
            $query->delete();
            Log::channel("weather")->info("Successfully deleted entries beyond one month");
            return true;
        }
        catch(\Throwable $e){
            Log::channel("weather")->info("Unable to delete entries beyond one month because of $e");
            return false;
        }

    }
    public function updateStatus(string $description):bool{
        Log::channel('weather')->info('Updating status for status service');
        try {
            Log::channel("weather")->info("Trying to update status");
            
            Status::create([
                'description' => $description,
            ]);

            Log::channel('weather')->info('Successfully updated status');
            return true;
        } catch (\Throwable $e) {
            Log::channel('weather')->error('Unable to update status table', [
                'exception' => $e,
            ]);
            return false;
        }
    }
}
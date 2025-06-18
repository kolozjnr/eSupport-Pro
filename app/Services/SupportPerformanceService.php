<?php

namespace App\Services;

use App\Models\SupportPerformanceMetric;
use App\Models\Ticket;

class SupportPerformanceService
{
    public function updateSupportPerformance(int $supportId, int $ticketId): void
    {
        // Get the specific ticket being resolved
        $resolvedTicket = Ticket::where('support_id', $supportId)
            ->where('id', $ticketId)
            ->whereNotNull('resolved_at')
            ->first();
        
        if (!$resolvedTicket) return;
        
        // Get current metrics or create new
        $metrics = SupportPerformanceMetric::firstOrNew(['support_id' => $supportId]);
        
        // Update metrics incrementally
        $metrics->total_tickets_resolved = ($metrics->total_tickets_resolved ?? 0) + 1;
        
        // Calculate new rolling averages (more efficient than querying all tickets)
        $newCount = $metrics->total_tickets_resolved;
        $oldAvgResponse = $metrics->average_response_time ?? 0;
        $oldAvgResolution = $metrics->average_resolution_time ?? 0;
        
        $metrics->average_response_time = 
            (($oldAvgResponse * ($newCount - 1)) + $resolvedTicket->response_time) / $newCount;
        
        $metrics->average_resolution_time = 
            (($oldAvgResolution * ($newCount - 1)) + $resolvedTicket->resolution_time) / $newCount;
        
        $metrics->save();
    }
    
    public function calculatePerformanceScore(int $supportId): float
    {
        $metrics = SupportPerformanceMetric::where('support_id', $supportId)->first();
        
        if (!$metrics) return 0;
        
        // Weighted scoring formula (adjust as needed)
        $responseScore = max(0, 100 - ($metrics->average_response_time / 10));
        $resolutionScore = max(0, 100 - ($metrics->average_resolution_time / 30));
        
        return ($responseScore * 0.4) + ($resolutionScore * 0.4) + 
               (min($metrics->total_tickets_resolved, 100) * 0.2);
    }

    public function getSupportPerformanceMetrics()
    {
        $supportMetrics = SupportPerformanceMetric::with('support.user')->get();

        return $supportMetrics;
    }
}
<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get location ranking based on total asset value
     * 
     * @return array
     */
    public function getLocationRanking()
    {
        $query = "
            SELECT 
                l.name AS location_name,
                SUM(a.purchase_price) AS total_asset_value,
                DENSE_RANK() OVER (ORDER BY SUM(a.purchase_price) DESC) AS location_rank
            FROM 
                assets a
                INNER JOIN locations l ON a.location_id = l.id
            GROUP BY 
                l.name
            ORDER BY 
                location_rank
        ";
        
        return DB::select($query);
    }
}
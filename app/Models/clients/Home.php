<?php

namespace App\Models\clients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Home extends Model
{
    use HasFactory;

    protected $table = 'tbl_tours' ;
    
    public function getHomeTours() :Collection{
        // Lấy thông tin tour
        $tours = DB::table($this->table)
            ->get();

        foreach ($tours as $tour) {
            // Lấy danh sách hình ảnh thuộc về tour
            $tour->images = DB::table('tbl_images')
                ->where('tourId', $tour->tourId)
                ->pluck('imageUrl');

            // Lấy danh sách timeline thuộc về tour
            // $tour->timeline = DB::table('tbl_timeline')
            //     ->where('tourId', $tour->tourId)
            //     ->pluck('title');
        }

        return $tours;
    }
}

<?php

namespace App\Models\clients;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Tours extends Model
{
    use HasFactory;
   protected $table = 'tbl_tours';
   //Lấy tất cả tour
   public function getAllTours()
   {
       $allTours = DB::table($this->table)->get();
       foreach ($allTours as $tour) {
            // Lấy danh sách hình ảnh thuộc về tour
            $tour->images = DB::table('tbl_images')
                ->where('tourId', $tour->tourId)
                ->pluck('imageUrl');
        }
       return $allTours;
   }
   //Lấy chi tiết tour
    public function getTourDetail($id)
    {
        $getTourDetail = DB::table($this->table)
            ->where('tourId', $id)
            ->first();

        if ($getTourDetail) {
            // Lấy danh sách hình ảnh thuộc về tour
            $getTourDetail->images = DB::table('tbl_images')
                ->where('tourId', $getTourDetail->tourId)
                ->limit(5)
                ->pluck('imageUrl');

            // Lấy danh sách timeline thuộc về tour
            $getTourDetail->timeline = DB::table('tbl_timeline')
                ->where('tourId', $getTourDetail->tourId)
                ->get();
        }
        return $getTourDetail;
    }

    //Lấy khu vực đến Bắc - Trung - Nam
    function getDomain()
    {
        return DB::table($this->table)
            ->select('domain', DB::raw('COUNT(*) as count'))
            //->where('availability', 1)
            ->whereIn('domain', ['b', 't', 'n'])
            ->groupBy('domain')
            ->get();
    }
    //Filter tours
    public function filterTours($filters = [], $sorting = null, $perPage = null)
    {
        DB::enableQueryLog();
        $getTours = DB::table($this->table)->where($filters);
        if (!empty($filters)) {
            foreach ($filters as $filter) {
                if (count($filter) === 3) {
                    $getTours = $getTours->where($filter[0], $filter[1], $filter[2]);
                }
            }
        }
        if (!empty($sorting) && isset($sorting[0]) && isset($sorting[1])) {
            $getTours = $getTours->orderBy($sorting[0], $sorting[1]);
        }
        // Thực hiện truy vấn để ghi log
        $tours = $getTours->get();
        // In ra câu lệnh SQL đã ghi lại (nếu cần thiết)
        $queryLog = DB::getQueryLog();
        // Lấy danh sách hình ảnh cho mỗi tour
        foreach ($tours as $tour) {
            $tour->images = DB::table('tbl_images')
                ->where('tourId', $tour->tourId)
                ->pluck('imageUrl');
            //$tour->rating = $this->reviewStats($tour->tourId)->averageRating;
        }
        //dd($queryLog); 
        return $tours;
            
    }
    //Filter tours
    // public function filterTours($filters = [], $sorting = null, $perPage = null)
    // {
    //     DB::enableQueryLog();

    //     // Khởi tạo truy vấn với bảng tours
    //     $getTours = DB::table($this->table)
    //         ->leftJoin('tbl_reviews', 'tbl_tours.tourId', '=', 'tbl_reviews.tourId') // Join với bảng reviews
    //         ->select(
    //             'tbl_tours.tourId',
    //             'tbl_tours.title',
    //             'tbl_tours.description',
    //             'tbl_tours.priceAdult',
    //             'tbl_tours.priceChild',
    //             'tbl_tours.time',
    //             'tbl_tours.destination',
    //             'tbl_tours.quantity',
    //             DB::raw('AVG(tbl_reviews.rating) as averageRating')
    //         )
    //         ->groupBy(
    //             'tbl_tours.tourId',
    //             'tbl_tours.title',
    //             'tbl_tours.description',
    //             'tbl_tours.priceAdult',
    //             'tbl_tours.priceChild',
    //             'tbl_tours.time',
    //             'tbl_tours.destination',
    //             'tbl_tours.quantity'
    //         );
    //     $getTours = $getTours->where('availability', 1);

    //     if (!empty($filters)) {
    //         foreach ($filters as $filter) {
    //             if ($filter[0] !== 'averageRating') {
    //                 $getTours = $getTours->where($filter[0], $filter[1], $filter[2]);
    //             }
    //         }
    //     }

    //     // Áp dụng điều kiện về averageRating trong phần HAVING
    //     if (!empty($filters)) {
    //         foreach ($filters as $filter) {
    //             if ($filter[0] === 'averageRating') {
    //                 $getTours = $getTours->having('averageRating', $filter[1], $filter[2]); // Sử dụng HAVING để lọc averageRating
    //             }
    //         }
    //     }

        // if (!empty($sorting) && isset($sorting[0]) && isset($sorting[1])) {
        //     $getTours = $getTours->orderBy($sorting[0], $sorting[1]);
        // }

    //     // Thực hiện truy vấn để ghi log
    //     $tours = $getTours->get();

    //     // In ra câu lệnh SQL đã ghi lại (nếu cần thiết)
    //     $queryLog = DB::getQueryLog();

        // // Lấy danh sách hình ảnh cho mỗi tour
        // foreach ($tours as $tour) {
        //     $tour->images = DB::table('tbl_images')
        //         ->where('tourId', $tour->tourId)
        //         ->pluck('imageUrl');
        //     $tour->rating = $this->reviewStats($tour->tourId)->averageRating;
        // }

    //     // dd($queryLog); // In ra log truy vấn nếu cần thiết
    //     return $tours;
    // }

}

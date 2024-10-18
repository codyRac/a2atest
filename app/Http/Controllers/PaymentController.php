<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
          // Define the allowed dates
        $allowedDates = ['2024-10-16', '2024-10-17', '2024-10-18'];

        // Validate that the date is one of the allowed dates
        $request->validate([
            'date' => ['required', 'date', 'in:' . implode(',', $allowedDates)],
        ]);

        // Retrieve the validated date from the request query parameter
        $date = $request->query('date');

        // Fetch all payments for the specified date, including related data (user, movie, theater)
        $payments = Payment::with(['user', 'movie', 'theater'])
            ->whereDate('created_at', $date)
            ->get();

        // Calculate counts from the single query result
        $movieCount = $payments->unique('movie_id')->count();
        $theaterCount = $payments->unique('theater_id')->count();
        $userCount = $payments->unique('user_id')->count();
        $paymentCount = $payments->count();

         // Calculate total amount sold per movie
        $totalAmountPerMovie = $payments->groupBy('movie_id')->map(function ($group) {
            return [
                'movie_id' => $group->first()->movie_id,
                'movie' => $group->first()->movie,
                'total_amount' => $group->sum('amount')
            ];
        })->values();

        // Calculate total amount sold per theater
        $totalAmountPerTheater = $payments->groupBy('theater_id')->map(function ($group) {
            return [
                'theater_id' => $group->first()->theater_id,
                'theater' => $group->first()->theater,
                'total_amount' => $group->sum('amount')
            ];
        })->values();

        $totalAmountPerMovieByTheater = $payments->groupBy('theater_id')->map(function ($theaterGroup) {
            return [
                'theater_id' => $theaterGroup->first()->theater_id,
                'theater' => $theaterGroup->first()->theater,
                'movies' => $theaterGroup->groupBy('movie_id')->map(function ($movieGroup) {
                    return [
                        'movie_id' => $movieGroup->first()->movie_id,
                        'movie' => $movieGroup->first()->movie,
                        'total_amount' => $movieGroup->sum('amount')
                    ];
                })->values()
            ];
        })->values();

        $paginatedPayments = Payment::with(['user', 'movie', 'theater'])->whereDate('created_at', $date)
        ->paginate();


        // Return the payments along with the counts and total amounts
        return response()->json([
            'payments' => $paginatedPayments, // Paginated payments
            'counts' => [
                'movies' => $movieCount,
                'theaters' => $theaterCount,
                'users' => $userCount,
                'total_payments' => $paymentCount
            ],
            'total_amount_per_movie' => $totalAmountPerMovie,
            'total_amount_per_theater' => $totalAmountPerTheater,
            'total_amount_per_movie_by_theater' => $totalAmountPerMovieByTheater, // Total by theater and movie

        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}

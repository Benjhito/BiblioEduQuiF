<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use App\Models\Entry;
use App\Models\Stock;
use App\Models\Member;
use App\Models\LoanItem;
use App\Models\Provider;
use App\Models\Publisher;
use App\Models\Collection;
use App\Models\Devolution;
use App\Models\Reservation;
use App\Models\DevolutionItem;
use App\Models\ReservationItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create();

        $this->call(LookupSeeder::class);

        Member::factory(20)->create();

        Provider::factory(20)->create();

        Collection::factory(20)->create();

        Publisher::factory(20)->create();

        Book::factory(20)->hasCategories(2)->hasStock()->create();

        Entry::factory(20)->create();

        Loan::factory(20)->create()->each(function ($loan) {
            LoanItem::factory(2)->create([
                'loan_id' => $loan->id,
            ]);
        });

        Reservation::factory(20)->create()->each(function ($reservation) {
            ReservationItem::factory(2)->create([
                'reservation_id' => $reservation->id,
            ]);
        });

        Devolution::factory(20)->create()->each(function ($devolution) {
            DevolutionItem::factory(2)->create([
                'devolution_id' => $devolution->id,
            ]);
        });
    }
}

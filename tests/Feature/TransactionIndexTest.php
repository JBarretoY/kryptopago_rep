<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Tests\TestCase;

class TransactionIndexTest extends TestCase
{
    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function sendRequest()
    {
        factory(Transaction::class)->times(5)->create();

        return $this->get('api/transaction/index', $this->getHeaders());
    }

    public function testGetIndex()
    {
        $this->actingAsUser();

        $this->sendRequest()
            ->assertSuccessful()
            ->assertJsonCount(5, 'transaction');
    }
}

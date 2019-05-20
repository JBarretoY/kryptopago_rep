<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Tests\TestCase;

class TransactionStoreTest extends TestCase
{
    /**
     * @param array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function sendRequest($data = [])
    {
        return $this->postJson('api/transaction/store', $data, $this->getHeaders());
    }

    public function testStore()
    {
        $this->actingAsUser();

        $this->sendRequest(factory(Transaction::class)->raw())
            ->assertSuccessful()
            ->assertJsonFragment(['id' => 1]);

        $this->assertDatabaseHas('transactions', ['id' => 1]);
    }

    public function testStoreOnFail()
    {
        $this->actingAsUser();

        $this->sendRequest()->assertStatus(500);
    }
}

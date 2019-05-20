<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Tests\TestCase;

class TransactionShowTest extends TestCase
{
    /**
     * @param $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function sendRequest($id)
    {
        return $this->get("api/transaction/show/$id", $this->getHeaders());
    }

    public function testShow()
    {
        $id = factory(Transaction::class)->create()->id;

        $this->sendRequest($id)
            ->assertSuccessful()
            ->assertJsonFragment(['id' => $id]);

        $anotherId = factory(Transaction::class)->create()->id;

        $this->sendRequest($anotherId)
            ->assertSuccessful()
            ->assertJsonFragment(['id' => $anotherId]);
    }
}

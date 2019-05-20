<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Tests\TestCase;

class TransactionUpdateTest extends TestCase
{
    /**
     * @param $id
     * @param array $data
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function sendRequest($id, $data = [])
    {
        return $this->putJson("api/transaction/update/$id", $data, $this->getHeaders());
    }

    public function testUpdate()
    {
        $this->actingAsUser();

        $trans = factory(Transaction::class)->create();

        $this->sendRequest($trans->id, ['amount_bs' => 200])
            ->assertSuccessful()
            ->assertJsonFragment(['id' => $trans->id])
            ->assertJsonFragment(['amount_bs' => 200]);
    }

    public function UpdateOnFail()
    {
        // TODO
    }
}

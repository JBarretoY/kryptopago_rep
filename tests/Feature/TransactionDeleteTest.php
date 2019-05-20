<?php

namespace Tests\Feature;

use App\Models\Transaction;
use Tests\TestCase;

class TransactionDeleteTest extends TestCase
{
    /**
     * @param $id
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function sendRequest($id)
    {
        return $this->delete("api/transaction/delete/$id", [], $this->getHeaders());
    }

    public function testDelete()
    {
        $trans = factory(Transaction::class)->create();

        $this->sendRequest($trans->id)->assertSuccessful();

        // Necesita especificar el deleted_at por el soft delete
        $this->assertDatabaseMissing('transactions', ['id' => $trans->id, 'deleted_at' => null]);
    }

    public function DeleteOnFail()
    {
        // TODO
    }
}

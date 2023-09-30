<?php

use App\Http\Requests\PegawaiRiwayatDiklatRequest;
use App\Models\PegawaiRiwayatDiklat;
use App\Models\User;

describe('handling crud pegawai riwayat diklat', function () {
    beforeEach(fn() => $this->user = User::factory()->create());

    it('can handle pegawai riwayat diklat store request', function () {
        PegawaiRiwayatDiklatRequest::fake();

        $response = $this->actingAs($this->user)
            ->post(route('riwayat-diklat.store'));

        expect(PegawaiRiwayatDiklat::first())->not->toBeNull()
            ->media->toHaveCount(1);

        $response->assertRedirect(route('riwayat-diklat.index'))
            ->assertSessionHas('toast', ['message' => 'Riwayat diklat berhasil disimpan']);
    });
});

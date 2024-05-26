<!-- resources/views/otp.blade.php -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Daftar OTP</div>

                <div class="card-body">
                    <a href="/sbuser/show" type="button" class="btn btn-primary">Tambah User</a>
                    @if ($otps->isEmpty())
                        <p>Tidak ada OTP yang tersimpan.</p>
                    @else
                        <ul>
                            @foreach ($otps as $otp)
                                <li>{{ $otp->code }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

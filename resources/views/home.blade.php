@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <form action="http://45.77.201.82/api" method="post" accept-charset="utf-8">
                    {{-- @csrf --}}
                    <input type='hidden' name='secretkey' value='kJ-NbalXEGDKBVOak0aRUow-WziCNFn8oEWAPgxuZaez62Kq2V'>

                    <input type='hidden' name='publickey' value='gXiO3fnlSa1fipVf0KxyevJs5PvPfyJxu3kyiJVaUXqdmktn50'>

                    <input type='hidden' name='businessemail' value='okonkwoflair@gmail.com'>

                    <input type='hidden' name='businessid' value='h8VfwCiMP0aj4YY'>

                    <input type='hidden' name='username' value='flairxy'>

                    <input type='hidden' name='email' value='okonkwoflair@gmail.com'>

                    <input type='hidden' name='amount' value='0.1'>

                    <input type='hidden' name='currency' value='BTC'>

                    <input type='submit' name='paynow' value='Pay Now'>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

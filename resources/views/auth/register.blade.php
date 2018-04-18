@extends('layouts.head')
@section('content')

        <div class="container">
          <div class="row">
              <div class="col col-login mx-auto">
                <div class="text-center mb-6">
                  <img src="./assets/brand/tabler.svg" class="h-6" alt="">
                </div>
                <form class="card" action="{{ route('register') }}" method="post">
                    {{ csrf_field() }}
                  <div class="card-body p-6">
                    <div class="card-title">Create new account</div>
                    <div class="form-group">
                      <label class="form-label">Name</label>
                      <input type="text" name="name" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="Enter name">
                      @if ($errors->has('name'))
                          <span class="invalid-feedback">
                              {{ $errors->first('name') }}
                          </span>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label">Email address</label>
                      <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Enter email">
                      @if ($errors->has('email'))
                          <span class="invalid-feedback">
                              {{ $errors->first('email') }}
                          </span>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label">Password</label>
                      <input type="password" name="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password">
                      @if ($errors->has('password'))
                          <span class="invalid-feedback">
                              {{ $errors->first('password') }}
                          </span>
                      @endif
                    </div>
                    <div class="form-group">
                      <label class="form-label">Password Confirmation</label>
                      <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
                    </div>

                    <div class="form-footer">
                      <button type="submit" class="btn btn-primary btn-block">Create new account</button>
                    </div>
                  </div>
                </form>
                <div class="text-center text-muted">
                  Already have account? <a href="/login">Sign in</a>
                </div>
              </div>
            </div>
        </div>

      @endsection

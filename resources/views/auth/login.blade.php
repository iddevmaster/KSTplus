<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <a href="{{ route('sso.login') }}" class="btn btn-primary">Login with SSO</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

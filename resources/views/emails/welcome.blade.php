Hello {{ $user->name }}
thank you for crate an account , Please verifiy your account form this link
{{ route('verifiy',$user->verification_token) }}

Hello {{ $user->name }}
You have changed your email . Please confirm the new email using the link below:
{{ route('verifiy',$user->verification_token) }}

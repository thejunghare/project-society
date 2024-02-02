<div>
    @foreach ($users as $user)
        <x-all-users :user="$user" />
    @endforeach
</div>

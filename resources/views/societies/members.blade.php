<!-- resources/views/societies/members.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Members of {{ $society->name }}</title>
    <!-- Add necessary CSS/JS here -->
</head>

<body>
    <h1>Members of {{ $society->name }}</h1>
    <ul>
        @foreach ($society->members as $member)
            <li>
                Member ID: {{ $member->user_id }}<br>  
                Room Number: {{ $member->room_number }}<br>
                Is Rented: {{ $member->is_rented ? 'Yes' : 'No' }}
            </li>
        @endforeach
    </ul>
</body>

</html>
